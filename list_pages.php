<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Page;

$pages = Page::all();
echo "Total pages: " . count($pages) . "\n";
foreach ($pages as $page) {
    echo "- Page ID " . $page->id . ": " . $page->title . "\n";
    echo "  Slug: " . $page->slug . "\n";
    echo "  Published: " . ($page->published ? 'Yes' : 'No') . "\n";
    echo "  HTML: " . (strlen($page->html) > 0 ? 'Yes (' . strlen($page->html) . ' chars)' : 'No') . "\n";
    echo "\n";
}
