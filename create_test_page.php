<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Page;

$page = Page::create([
    'title' => 'Test Page ' . date('H:i:s'),
    'slug' => 'test-page-' . time(),
    'html' => '<h1>Test Page</h1><p>This is a test page for GrapesJS editor</p>',
    'css' => 'body { font-family: Arial; color: #333; }',
    'json' => json_encode([]),
    'published' => false
]);

echo "✓ Created page ID: " . $page->id . " (Slug: " . $page->slug . ")\n";
echo "Edit URL: http://127.0.0.1:8000/builder/" . $page->id . "\n";
