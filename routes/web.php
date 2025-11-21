<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleProxyController;
use App\Http\Controllers\AboutProxyController;
use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\TailwindBuilderController;
use App\Http\Controllers\DebugArticleController;
use App\Http\Controllers\SitemapController;

Route::get('/', function () {
    return view('about');
});

// Proxy endpoint to fetch remote about HTML (used to inline external site content without iframe)
Route::get('/about/proxy', [AboutProxyController::class, 'fetch'])->name('about.proxy');

Route::get('/articles', [ArticleProxyController::class, 'index'])->name('articles.index');

// Debug route to check what data is being generated
Route::get('/debug-articles', [DebugArticleController::class, 'debug'])->name('debug.articles');

// Page Builder routes
Route::prefix('page-builder')->group(function () {
    Route::get('/', [PageBuilderController::class, 'index'])->name('page-builder.index');
    Route::post('/save', [PageBuilderController::class, 'save'])->name('page-builder.save');
    Route::get('/load/{id?}', [PageBuilderController::class, 'load'])->name('page-builder.load');
});

// Tailwind Builder routes
Route::prefix('builder')->group(function () {
    Route::get('/tailwind', [TailwindBuilderController::class, 'tailwind'])->name('builder.tailwind');
    Route::get('/react', [TailwindBuilderController::class, 'react'])->name('builder.react');
});

// CMS Integration routes
Route::get('/cms/config', [TailwindBuilderController::class, 'cmsConfig'])->name('cms.config');

// Tailwind compilation route
Route::post('/tailwind/compile', [TailwindBuilderController::class, 'compileTailwind'])->name('tailwind.compile');

// GrapesJS Tailwind plugin
Route::get('/js/grapesjs-tailwind-plugin.js', function () {
    return response()->file(public_path('js/grapesjs-tailwind-plugin.js'), [
        'Content-Type' => 'application/javascript',
    ]);
});

// Search route (for structured data)
Route::get('/search', function () {
    return view('search', ['query' => request()->get('q', '')]);
})->name('search');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

