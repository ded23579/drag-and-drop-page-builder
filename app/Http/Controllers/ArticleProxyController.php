<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArticleProxyController extends Controller
{
    /**
     * Fetch latest articles from a remote WordPress site using REST API.
     * Falls back to RSS parsing if REST API is unavailable.
     */
    public function index()
    {
        $items = [];

        // Try fetching from remote site with timeout and fallback
        $siteUrl = env('EDU_SITE_URL', 'https://edu.abjad.eu.org'); // Changed default to the correct site
        $cacheKey = 'edu_remote_articles_v2_rest_api'; // Changed to indicate REST API approach

        $items = Cache::remember($cacheKey, 30 * 60, function () use ($siteUrl) {
            try {
                // Try WordPress REST API first as it provides featured images more reliably
                // This will fetch from https://edu.abjad.eu.org/wp-json/wp/v2/posts?per_page=20&_embed
                return $this->fetchFromRestApi('https://edu.abjad.eu.org');
            } catch (\Exception $e) {
                Log::warning('REST API failed: ' . $e->getMessage() . '; trying RSS feed...');

                try {
                    // Try to get articles from the specific RSS feed URL
                    return $this->fetchFromRssFeed('https://edu.abjad.eu.org/feed/');
                } catch (\Exception $e2) {
                    Log::warning('Main feed failed: ' . $e2->getMessage() . '; trying direct RSS...');

                    // Try RSS from the site URL
                    try {
                        return $this->fetchFromRssFeed(rtrim($siteUrl, '/') . '/feed');
                    } catch (\Exception $e3) {
                        Log::error('All approaches failed: ' . $e3->getMessage());
                        // Return static sample items as final fallback
                        return $this->getSampleArticles();
                    }
                }
            }
        });

        return view('articles', ['items' => $items]);
    }

    /**
     * Provide sample articles as fallback
     */
    private function getSampleArticles()
    {
        return [
            [
                'title' => 'Pengantar Pemrograman Web',
                'link' => 'https://example.com/web-programming'
            ],
            [
                'title' => 'Dasar-dasar Laravel Framework',
                'link' => 'https://example.com/laravel-basics'
            ],
            [
                'title' => 'Membangun REST API',
                'link' => 'https://example.com/rest-api'
            ],
            [
                'title' => 'Database dan Eloquent',
                'link' => 'https://example.com/database-eloquent'
            ]
        ];
    }

    /**
     * Proxy image requests to avoid CORS issues
     */
    public function proxyImage($imageUrl)
    {
        // Decode URL - reverse the replacements made in the view
        $imageUrl = urldecode(base64_decode(str_replace(['__SLASH__', ''], ['/', '='], $imageUrl)));

        // Validate the URL
        if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid image URL');
        }

        // Only allow HTTP and HTTPS URLs
        if (!preg_match('#^https?://#i', $imageUrl)) {
            abort(400, 'Invalid image URL scheme');
        }

        // If it's a placeholder image, redirect directly instead of proxying
        if (str_contains($imageUrl, 'via.placeholder.com')) {
            return redirect()->away($imageUrl);
        }
        // If it's an edu.abjad.eu.org image, redirect directly as well
        if (str_contains($imageUrl, 'edu.abjad.eu.org')) {
            return redirect()->away($imageUrl);
        }

        try {
            // Use HTTP client to fetch the image with more permissive headers
            $httpClient = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'image/webp,image/apng,image/*,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'en-US,en;q=0.9',
            ])->timeout(10);

            $response = $httpClient->get($imageUrl);

            if (!$response->successful()) {
                \Log::warning('Image proxy failed for: ' . $imageUrl . ' Status: ' . $response->status());
                abort(404, 'Image not found');
            }

            // Get content type from response
            $contentType = $response->header('Content-Type') ?? 'image/jpeg';

            // Validate content type is actually an image
            if (!str_contains($contentType, 'image/')) {
                \Log::warning('Non-image content type received: ' . $contentType . ' for URL: ' . $imageUrl);
                abort(415, 'Content is not an image');
            }

            // Return the image content with appropriate headers
            return response($response->body())
                ->header('Content-Type', $contentType)
                ->header('Cache-Control', 'public, max-age=3600')
                ->header('Access-Control-Allow-Origin', '*');
        } catch (\Exception $e) {
            \Log::error('Image proxy error: ' . $e->getMessage() . ' for URL: ' . $imageUrl);
            abort(500, 'Error fetching image: ' . $e->getMessage());
        }
    }

    /**
     * Parse HTML body to extract article-like links and images.
     */
    private function parseHtmlItems(string $body, string $base)
    {
        $items = [];

        if (preg_match_all('/<article[\s\S]*?<a[^>]+href=["\']?([^"\'>\s]+)["\']?[^>]*>([\s\S]*?)<\/a>[\s\S]*?<\/article>/i', $body, $matches)) {
            foreach ($matches[1] as $i => $href) {
                $inner = $matches[2][$i] ?? '';
                $img = '';
                if (preg_match('/<img[^>]+src=["\']?([^"\'>\s]+)["\']?/i', $inner, $m)) {
                    $img = $m[1];
                }
                $text = trim(strip_tags($inner));
                $validatedImage = $this->validateImageUrl($img);
                $items[] = [
                    'title' => $text ?: $href,
                    'link' => $this->absUrl($base, $href),
                    'image' => $validatedImage ?: 'https://edu.abjad.eu.org/images/placeholder-' . rand(100, 999) . '.jpg'
                ];
                if (count($items) >= 20) break;
            }
            return $items;
        }

        if (preg_match_all('/<a[^>]+href=["\']?([^"\'>\s]+)["\']?[^>]*>([\s\S]{1,400}?)<\/a>/i', $body, $m2)) {
            foreach ($m2[1] as $i => $href) {
                $inner = $m2[2][$i] ?? '';
                $img = '';
                if (preg_match('/<img[^>]+src=["\']?([^"\'>\s]+)["\']?/i', $inner, $mi)) {
                    $img = $mi[1];
                }
                $text = trim(strip_tags($inner));
                if (preg_match('/\.(css|js|png|jpg|jpeg|svg|gif)$/i', $href)) continue;
                $validatedImage = $this->validateImageUrl($img);
                $items[] = [
                    'title' => $text ?: $href,
                    'link' => $this->absUrl($base, $href),
                    'image' => $validatedImage ?: 'https://edu.abjad.eu.org/images/placeholder-' . rand(100, 999) . '.jpg'
                ];
                if (count($items) >= 20) break;
            }
        }

        return $items;
    }

    private function absUrl($base, $relative)
    {
        if (preg_match('#^https?://#i', $relative)) return $relative;
        $parsed = parse_url($base);
        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? '';
        $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
        $baseRoot = $scheme . '://' . $host . $port;
        if (strpos($relative, '/') === 0) {
            return $baseRoot . $relative;
        }
        $path = isset($parsed['path']) ? rtrim(dirname($parsed['path']), '/') : '';
        return $baseRoot . $path . '/' . ltrim($relative, '/');
    }

    /**
     * Fetch articles from WordPress REST API with featured media image URLs.
     */
    private function fetchFromRestApi($siteUrl)
    {
        // Fetch posts with embeds to get featured media in the same request
        $restUrl = rtrim($siteUrl, '/') . '/wp-json/wp/v2/posts?per_page=20&_embed';

        $httpClient = Http::withHeaders(['User-Agent' => 'Laravel ArticleProxy/1.0'])->timeout(10);
        if (app()->environment(['local', 'testing'])) {
            $httpClient = $httpClient->withoutVerifying();
        }

        $resp = $httpClient->get($restUrl);
        if (!$resp->successful()) {
            throw new \Exception('REST API returned status: ' . $resp->status());
        }

        $posts = $resp->json();
        if (!is_array($posts) || empty($posts)) {
            throw new \Exception('No posts returned from REST API');
        }

        $items = [];

        foreach ($posts as $post) {
            if (empty($post['title']['rendered'])) continue;

            $title = trim(strip_tags($post['title']['rendered']));
            $link = $post['link'] ?? '';
            $image = '';

            // Check if featured media is embedded (WordPress includes it when _embed parameter is used)
            if (isset($post['_embedded']['wp:featuredmedia']) && !empty($post['_embedded']['wp:featuredmedia'])) {
                $featuredMedia = $post['_embedded']['wp:featuredmedia'][0];
                if (isset($featuredMedia['source_url'])) {
                    $image = $featuredMedia['source_url'];
                }
                // Also try other common image sizes
                elseif (isset($featuredMedia['media_details']['sizes']['full']['source_url'])) {
                    $image = $featuredMedia['media_details']['sizes']['full']['source_url'];
                }
                elseif (isset($featuredMedia['media_details']['sizes']['large']['source_url'])) {
                    $image = $featuredMedia['media_details']['sizes']['large']['source_url'];
                }
                elseif (isset($featuredMedia['media_details']['sizes']['medium']['source_url'])) {
                    $image = $featuredMedia['media_details']['sizes']['medium']['source_url'];
                }
            }

            $validatedImage = $this->validateImageUrl($image);
            $items[] = [
                'title' => $title,
                'link' => $link,
            ];
        }

        return $items;
    }

    /**
     * Fetch articles from RSS feed and extract featured images from various sources.
     */
    private function fetchFromRssFeed($siteUrl)
    {
        $feedUrl = rtrim($siteUrl, '/') . '/feed/';

        $httpClient = Http::withHeaders(['User-Agent' => 'Laravel ArticleProxy/1.0'])->timeout(15);
        if (app()->environment(['local', 'testing'])) {
            $httpClient = $httpClient->withoutVerifying();
        }

        $resp = $httpClient->get($feedUrl);
        $body = (string) $resp->body();

        $xml = @simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($xml === false) {
            throw new \Exception('Failed to parse RSS feed as XML');
        }

        $items = [];
        $elements = $xml->channel->item ?? [];

        foreach ($elements as $el) {
            $title = trim((string) ($el->title ?? ''));
            if (empty($title)) continue;

            $link = (string) ($el->link ?? '');
            if (empty($link)) {
                if (isset($el->guid)) $link = (string) $el->guid;
                else continue;
            }

            $link = $this->absUrl($feedUrl, $link);

            $image = '';

            // Extract image from enclosure if available (common in RSS feeds)
            if (isset($el->enclosure)) {
                $enclosure = $el->enclosure;
                if (isset($enclosure['type']) && strpos($enclosure['type'], 'image/') === 0) {
                    $image = (string) $enclosure['url'];
                }
            }
            // Try to get media content from namespaces (like iTunes podcast feeds)
            elseif (isset($el->children('http://search.yahoo.com/mrss/')->thumbnail)) {
                $thumbnail = $el->children('http://search.yahoo.com/mrss/')->thumbnail;
                if (isset($thumbnail->attributes()['url'])) {
                    $image = (string) $thumbnail->attributes()['url'];
                }
            }
            // Look for content:encoded or description with images
            elseif (!empty($el->children('content', true)->encoded)) {
                $contentEncoded = (string)$el->children('content', true)->encoded;
                $image = $this->extractImageFromContent($contentEncoded);
            }
            elseif (!empty($el->description)) {
                $description = (string)$el->description;
                $image = $this->extractImageFromContent($description);
            }
            elseif (!empty($el->content)) {
                $content = (string)$el->content;
                $image = $this->extractImageFromContent($content);
            }

            $validatedImage = $this->validateImageUrl($image);
            $items[] = [
                'title' => $title,
                'link' => $link,
            ];
            if (count($items) >= 20) break;
        }

        if (empty($items)) {
            throw new \Exception('No items found in RSS feed');
        }

        return $items;
    }

    /**
     * Validate and sanitize the image URL
     */
    private function validateImageUrl($url)
    {
        if (empty($url)) {
            return '';
        }

        // Check if it's a valid URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        // Ensure the URL starts with http or https
        if (!preg_match('#^https?://#i', $url)) {
            return '';
        }

        // Some sites use query parameters for tracking or other reasons
        // Return the validated URL
        return $url;
    }

    /**
     * Extract image URL from content description
     */
    private function extractImageFromContent($content)
    {
        if (empty($content)) {
            return '';
        }

        // Remove CDATA tags if present
        $content = str_replace(['<![CDATA[', ']]>'], '', $content);

        // First, try to find the featured image from the content
        // WordPress often includes featured images in the content
        if (preg_match('/<img[^>]+class=["\'].*?wp-image-[\d]+.*?["\'][^>]*src=["\']?([^"\'>\s]+)["\']?/i', $content, $matches)) {
            $imageUrl = $matches[1];
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                return $this->validateImageUrl($imageUrl);
            }
        }

        // Then try to find any img tag with src
        if (preg_match('/<img[^>]+src=["\']?([^"\'>\s]+)["\']?/i', $content, $matches)) {
            $imageUrl = $matches[1];
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                return $this->validateImageUrl($imageUrl);
            }
        }

        // Try to find WordPress upload URLs within the content
        if (preg_match('/https?:\/\/[^\s"<>\']*\/wp-content\/uploads\/[^\s"<>\']*\.(jpg|jpeg|png|gif|webp)/i', $content, $matches)) {
            $imageUrl = $matches[0];
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                return $this->validateImageUrl($imageUrl);
            }
        }

        return '';
    }
}
