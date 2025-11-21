<?php
// Debug script to check the RSS feed content and image extraction
$rssContent = file_get_contents('https://edu.abjad.eu.org/feed/');

if ($rssContent === false) {
    echo "Error: Could not fetch RSS feed\n";
    exit(1);
}

// Parse the RSS feed
$xml = simplexml_load_string($rssContent);
if ($xml === false) {
    echo "Error: Could not parse RSS feed XML\n";
    exit(1);
}

echo "RSS feed loaded successfully. Found " . count($xml->channel->item) . " items.\n\n";

// Check the first few items for images
$items = $xml->channel->item;
foreach (range(0, min(2, count($items) - 1)) as $i) {
    $item = $items[$i];
    echo "Item " . ($i+1) . " - Title: " . trim((string)$item->title) . "\n";
    
    // Check for enclosure
    if (isset($item->enclosure)) {
        echo "  Enclosure: " . $item->enclosure['url'] . "\n";
    } else {
        echo "  No enclosure found\n";
    }
    
    // Check for media:thumbnail
    $namespaces = $item->getNamespaces(true);
    if (isset($namespaces['media'])) {
        $media = $item->children($namespaces['media']);
        if (isset($media->thumbnail)) {
            echo "  Media thumbnail: " . $media->thumbnail->attributes()['url'] . "\n";
        } else {
            echo "  No media:thumbnail found\n";
        }
    } else {
        echo "  No media namespace found\n";
    }
    
    // Check for content:encoded
    $contentNamespaces = $item->getNamespaces(true);
    if (isset($contentNamespaces['content'])) {
        $content = $item->children($contentNamespaces['content']);
        if (isset($content->encoded)) {
            $contentStr = (string)$content->encoded;
            if (preg_match('/<img[^>]+src=["\']?([^"\'>\s]+)["\']?/i', $contentStr, $matches)) {
                echo "  Image in content:encoded: " . $matches[1] . "\n";
            } else {
                echo "  No image found in content:encoded\n";
            }
        }
    }
    
    // Check for description
    if (isset($item->description)) {
        $description = (string)$item->description;
        if (preg_match('/<img[^>]+src=["\']?([^"\'>\s]+)["\']?/i', $description, $matches)) {
            echo "  Image in description: " . $matches[1] . "\n";
        } else {
            echo "  No image found in description\n";
        }
        
        // Look for wp-image pattern in description
        if (preg_match('/wp-image-(\d+)/', $description, $matches)) {
            echo "  Found wp-image ID: " . $matches[1] . "\n";
        }
    }
    
    echo "\n";
}
?>