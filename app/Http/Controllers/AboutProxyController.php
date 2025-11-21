<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AboutProxyController extends Controller
{
    /**
     * Fetch remote site HTML and return a cleaned fragment with absolute asset URLs.
     */
    public function fetch(Request $request)
    {
        $target = env('ABOUT_PROXY_URL', 'https://ded23579.github.io');
        $cacheKey = 'about_proxy_fragment_v1_' . md5($target);

        try {
            $html = Cache::remember($cacheKey, 30 * 60, function () use ($target) {
                $httpClient = Http::withHeaders(['User-Agent' => 'Laravel AboutProxy/1.0']);
                if (app()->environment(['local', 'testing'])) {
                    $httpClient = $httpClient->withoutVerifying();
                }
                $resp = $httpClient->get($target);
                if (! $resp->successful()) {
                    return '';
                }
                $body = (string) $resp->body();

                // Use DOMDocument to extract body content and rewrite relative URLs to absolute
                libxml_use_internal_errors(true);
                $dom = new \DOMDocument();
                // suppress warnings for malformed HTML
                $dom->loadHTML('<?xml encoding="utf-8"?>' . $body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $xpath = new \DOMXPath($dom);
                $baseParsed = parse_url($target);
                $scheme = $baseParsed['scheme'] ?? 'https';
                $host = $baseParsed['host'] ?? '';
                $port = isset($baseParsed['port']) ? ':' . $baseParsed['port'] : '';
                $baseRoot = $scheme . '://' . $host . $port;

                // fix <link href>, <script src>, <img src>, <a href>, <source src/srcset>
                $attrs = [
                    ['link', 'href'],
                    ['script', 'src'],
                    ['img', 'src'],
                    ['a', 'href'],
                    ['source', 'src'],
                    ['source', 'srcset'],
                ];

                foreach ($attrs as [$tag, $attr]) {
                    $nodes = $xpath->query('//' . $tag . '[@' . $attr . ']');
                    foreach ($nodes as $node) {
                        $val = $node->getAttribute($attr);
                        if (empty($val)) continue;
                        // ignore anchors with mailto or javascript
                        if (preg_match('#^(\#|mailto:|javascript:)#i', $val)) continue;
                        // if already absolute, leave
                        if (preg_match('#^https?://#i', $val)) {
                            continue;
                        }
                        // make root relative -> absolute
                        if (strpos($val, '/') === 0) {
                            $new = rtrim($baseRoot, '/') . $val;
                        } else {
                            // relative path: combine with base path
                            $basePath = isset($baseParsed['path']) ? rtrim(dirname($baseParsed['path']), '/') : '';
                            $new = $baseRoot . $basePath . '/' . ltrim($val, '/');
                        }
                        $node->setAttribute($attr, $new);
                    }
                }

                // remove <base> tags to avoid conflicts
                $baseTags = $dom->getElementsByTagName('base');
                for ($i = $baseTags->length - 1; $i >= 0; $i--) {
                    $baseTags->item($i)->parentNode->removeChild($baseTags->item($i));
                }

                // extract innerHTML of body if present
                $bodies = $dom->getElementsByTagName('body');
                if ($bodies->length > 0) {
                    $bodyNode = $bodies->item(0);
                    $inner = '';
                    foreach ($bodyNode->childNodes as $child) {
                        $inner .= $dom->saveHTML($child);
                    }
                    return $inner;
                }

                // fallback: return entire document
                return $dom->saveHTML();
            });

            return response()->json(['ok' => true, 'html' => $html]);
        } catch (\Exception $e) {
            Log::error('AboutProxy fetch error: ' . $e->getMessage());
            return response()->json(['ok' => false, 'html' => ''], 500);
        }
    }
}
