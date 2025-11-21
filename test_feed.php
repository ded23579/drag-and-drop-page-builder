<?php
// Test script to get the RSS feed content
$rssContent = file_get_contents('https://edu.abjad.eu.org/feed/');

if ($rssContent === false) {
    echo "Error: Could not fetch RSS feed\n";
    exit(1);
}

echo "RSS Feed Content Length: " . strlen($rssContent) . " characters\n\n";

// Display the first 3000 characters to see the structure
echo substr($rssContent, 0, 3000) . "\n\n---SNIP---\n\n";

// Search for image-related content in the feed
preg_match_all('/<(enclosure|img|media:thumbnail|media:content)[^>]*>/i', $rssContent, $matches);
echo "Found image-related tags:\n";
foreach(array_slice($matches[0], 0, 20) as $tag) { // Show first 20
    echo htmlspecialchars($tag) . "\n";
}

// Also look for image URLs in the content
preg_match_all('/https?:\/\/[^\s"<>\']*\.(jpg|jpeg|png|gif|webp|svg)/i', $rssContent, $imgMatches);
echo "\n\nFound image URLs:\n";
foreach(array_slice($imgMatches[0], 0, 20) as $url) { // Show first 20
    echo $url . "\n";
}

// Look for content:encoded or description with images
preg_match_all('/<description><!\[CDATA\[(.*?)\]\]><\/description>/i', $rssContent, $descMatches);
echo "\n\nFound descriptions with potential images:\n";
foreach(array_slice($descMatches[1], 0, 5) as $desc) { // Show first 5
    if (strpos($desc, '<img') !== false) {
        preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $desc, $imgInDesc);
        if (isset($imgInDesc[1])) {
            echo "Image in description: " . $imgInDesc[1] . "\n";
        }
    }
}
?>