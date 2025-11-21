<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TailwindBuilderController extends Controller
{
    /**
     * Display the Tailwind CSS integration page for GrapesJS
     */
    public function tailwind()
    {
        return view('builder.tailwind');
    }

    /**
     * Handle CMS configuration for different CMS types
     */
    public function cmsConfig(Request $request)
    {
        $cmsType = $request->query('cms');
        
        $cmsConfigs = [
            'strapi' => [
                'name' => 'Strapi',
                'apiUrl' => env('STRAPI_API_URL', 'http://localhost:1337/api'),
                'apiKey' => env('STRAPI_API_KEY'),
            ],
            'directus' => [
                'name' => 'Directus',
                'apiUrl' => env('DIRECTUS_API_URL', 'http://localhost:8055'),
                'apiKey' => env('DIRECTUS_API_KEY'),
            ],
            'sanity' => [
                'name' => 'Sanity',
                'projectId' => env('SANITY_PROJECT_ID'),
                'dataset' => env('SANITY_DATASET', 'production'),
            ],
            'contentful' => [
                'name' => 'Contentful',
                'spaceId' => env('CONTENTFUL_SPACE_ID'),
                'accessToken' => env('CONTENTFUL_ACCESS_TOKEN'),
            ],
            'aimeos' => [
                'name' => 'Aimeos',
                'apiUrl' => env('AIMEOS_API_URL', 'http://localhost:8000/admin/jsonadm'),
                'username' => env('AIMEOS_USERNAME'),
                'password' => env('AIMEOS_PASSWORD'),
            ]
        ];

        if (isset($cmsConfigs[$cmsType])) {
            return response()->json($cmsConfigs[$cmsType]);
        }

        return response()->json(['error' => 'CMS type not supported'], 400);
    }

    /**
     * Display the React integration page
     */
    public function react()
    {
        return view('builder.react');
    }

    /**
     * Compile Tailwind CSS from HTML
     */
    public function compileTailwind(Request $request)
    {
        $html = $request->input('html', '');

        // Extract Tailwind classes using regex
        preg_match_all('/class="([^"]*)"/', $html, $matches);
        preg_match_all('/class=\'([^\']*)\'/', $html, $singleQuoteMatches);

        $allMatches = array_merge($matches[1], $singleQuoteMatches[1]);
        $classes = [];

        foreach ($allMatches as $classString) {
            $individualClasses = explode(' ', $classString);
            foreach ($individualClasses as $class) {
                $class = trim($class);
                if (!empty($class)) {
                    $classes[] = $class;
                }
            }
        }

        // Remove duplicate classes
        $uniqueClasses = array_unique($classes);

        // Create a more realistic CSS output by generating basic rules for the classes
        $cssRules = [];
        foreach ($uniqueClasses as $class) {
            // Handle different types of Tailwind classes
            if (strpos($class, 'bg-') === 0) {
                $cssRules[] = ".{$class} { background-color: #e5e7eb; }"; // Example color
            } elseif (strpos($class, 'text-') === 0) {
                $cssRules[] = ".{$class} { color: #1f2937; }"; // Example color
            } elseif (strpos($class, 'p-') === 0) {
                $cssRules[] = ".{$class} { padding: 0.5rem; }"; // Example padding
            } elseif (strpos($class, 'rounded') === 0) {
                $cssRules[] = ".{$class} { border-radius: 0.25rem; }"; // Example border radius
            } else {
                $cssRules[] = ".{$class} { /* Tailwind class: {$class} */ }";
            }
        }
        $cssContent = implode("\n", $cssRules);

        return response()->json([
            'success' => true,
            'data' => [
                'classes' => $uniqueClasses,
                'css' => $cssContent,
                'count' => count($uniqueClasses)
            ]
        ]);
    }

    /**
     * Generate mock CSS for demonstration
     */
    private function getMockCss($classes)
    {
        $css = [];
        foreach ($classes as $class) {
            // This is a simplified mock - in real implementation, use actual Tailwind compiler
            $css[] = ".{$class} { /* CSS rules for {$class} */ }";
        }
        return $css;
    }
}