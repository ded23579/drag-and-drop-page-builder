<?php
require_once 'vendor/autoload.php';

// Manually test the article fetching functionality
use Illuminate\Support\Facades\Http;

function fetchFromRssFeed($siteUrl) {
    $feedUrl = rtrim($siteUrl, '/') . '/feed/';

    $httpClient = Http::withHeaders(['User-Agent' => 'Laravel ArticleProxy/1.0'])->timeout(10);
    
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

        $link = absUrl($feedUrl, $link);

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

        $validatedImage = validateImageUrl($image);
        $items[] = [
            'title' => $title,
            'link' => $link,
            'image' => $validatedImage ?: extractImageFromContent($el->description ?? $el->content) ?: 'https://picsum.photos/300/200?random=' . rand(100, 999)
        ];
        
        echo "Title: " . $title . "\n";
        echo "Image: " . $items[count($items)-1]['image'] . "\n\n";
        
        if (count($items) >= 5) break; // Just show first 5 for testing
    }

    if (empty($items)) {
        throw new \Exception('No items found in RSS feed');
    }

    return $items;
}

function absUrl($base, $relative) {
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

function validateImageUrl($url) {
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

function extractImageFromContent($content) {
    if (empty($content)) {
        return '';
    }

    // Remove CDATA tags if present
    $content = str_replace(['<![CDATA[', ']]>'], '', $content);

    // Look for featured image URLs in the content in various possible formats
    $patterns = [
        // Standard img tag with src attribute
        '/<img[^>]+src=["\']?([^"\'>\s]+)["\']?/i',
        // Also look for wp-image or attachment identifiers that might reference featured images
        '/wp-image-(\d+)/',
        // Look for URLs that might be featured image URLs in WordPress
        '/https?:\/\/[^\s"<>\']*\/wp-content\/uploads\/[^\s"<>\']*\.(jpg|jpeg|png|gif|webp)/i',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content, $matches)) {
            if (isset($matches[1])) {
                $imageUrl = $matches[1];
                
                // Handle attachment ID pattern (wp-image-123)
                if (strpos($pattern, 'wp-image') !== false) {
                    // For now, we'll skip this since we can't resolve without additional API call
                    continue;
                }
                
                // If it's already a full URL, validate and return it
                if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $validated = validateImageUrl($imageUrl);
                    if (!empty($validated)) return $validated;
                }
                
                // If it's a partial URL, try to make it absolute using the site URL
                $siteUrl = 'https://edu.abjad.eu.org'; // Default site URL
                if (strpos($imageUrl, '/') === 0) {
                    // It's an absolute path
                    $absoluteUrl = rtrim($siteUrl, '/') . $imageUrl;
                    $validated = validateImageUrl($absoluteUrl);
                    if (!empty($validated)) return $validated;
                } elseif (preg_match('/^wp-content\/uploads\/.*/', $imageUrl)) {
                    // It's a relative path to uploads
                    $absoluteUrl = rtrim($siteUrl, '/') . '/' . $imageUrl;
                    $validated = validateImageUrl($absoluteUrl);
                    if (!empty($validated)) return $validated;
                }
            }
        }
    }

    return '';
}

// Test the function
try {
    $articles = fetchFromRssFeed('https://edu.abjad.eu.org/feed/');
    echo "Fetched " . count($articles) . " articles\n";
    foreach ($articles as $index => $article) {
        echo ($index + 1) . ". " . $article['title'] . "\n";
        echo "   Image: " . $article['image'] . "\n\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}