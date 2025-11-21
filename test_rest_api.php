<?php
// Test the REST API directly
$apiUrl = 'https://edu.abjad.eu.org/wp-json/wp/v2/posts?per_page=5&_embed';
$context = stream_context_create([
    'http' => [
        'header' => "User-Agent: Laravel ArticleProxy/1.0\r\n",
        'timeout' => 15
    ]
]);

$response = file_get_contents($apiUrl, false, $context);
if ($response === false) {
    echo "Error: Could not fetch API\n";
    exit(1);
}

$posts = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Error: Could not decode JSON response\n";
    exit(1);
}

echo "API response loaded: " . count($posts) . " posts\n";

foreach (range(0, min(2, count($posts) - 1)) as $i) {
    $post = $posts[$i];
    echo "Post " . ($i+1) . " - Title: " . $post['title']['rendered'] . "\n";
    
    if (isset($post['_embedded']['wp:featuredmedia']) && !empty($post['_embedded']['wp:featuredmedia'])) {
        $featuredMedia = $post['_embedded']['wp:featuredmedia'][0];
        if (isset($featuredMedia['source_url'])) {
            echo "  Featured image: " . $featuredMedia['source_url'] . "\n";
        } elseif (isset($featuredMedia['media_details']['sizes']['full']['source_url'])) {
            echo "  Featured image (full): " . $featuredMedia['media_details']['sizes']['full']['source_url'] . "\n";
        } elseif (isset($featuredMedia['media_details']['sizes']['large']['source_url'])) {
            echo "  Featured image (large): " . $featuredMedia['media_details']['sizes']['large']['source_url'] . "\n";
        } elseif (isset($featuredMedia['media_details']['sizes']['medium']['source_url'])) {
            echo "  Featured image (medium): " . $featuredMedia['media_details']['sizes']['medium']['source_url'] . "\n";
        } else {
            echo "  Featured media found but no source_url available\n";
            echo "  Keys available: " . implode(', ', array_keys($featuredMedia)) . "\n";
        }
    } else {
        echo "  No featured media found\n";
    }
    echo "\n";
}
?>