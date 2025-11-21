<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrapesJSTailwindCMSIntegrationTest extends TestCase
{
    /**
     * Test if Tailwind CSS is properly integrated with GrapesJS
     */
    public function test_tailwind_css_integration()
    {
        $response = $this->get('/builder/tailwind');
        
        $response->assertStatus(200);
        $response->assertSee('Tailwind CSS Page Builder');
        $response->assertSee('cdn.tailwindcss.com');
    }

    /**
     * Test if CMS options are properly integrated
     */
    public function test_cms_integration_routes()
    {
        $cmsTypes = ['strapi', 'directus', 'sanity', 'contentful', 'aimeos'];
        
        foreach ($cmsTypes as $cmsType) {
            $response = $this->get("/cms/config?cms={$cmsType}");
            $response->assertStatus(200);
        }
    }

    /**
     * Test if React integration is accessible
     */
    public function test_react_integration_page()
    {
        $response = $this->get('/builder/react');
        // Note: The React integration page might not exist yet - this is to demonstrate the test
        $response->assertStatus(200);
    }

    /**
     * Test Tailwind compiler functionality
     */
    public function test_tailwind_compiler()
    {
        $sampleHtml = '<div class="bg-blue-500 text-white p-4 rounded">Test</div>';
        
        $response = $this->post('/tailwind/compile', [
            'html' => $sampleHtml
        ]);
        
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.classes', ['bg-blue-500', 'text-white', 'p-4', 'rounded']);
        $response->assertJsonPath('data.count', 4);
        // Check that the CSS contains expected rules
        $responseData = $response->json();
        $cssContent = $responseData['data']['css'];
        $this->assertStringContainsString('.bg-blue-500', $cssContent);
        $this->assertStringContainsString('background-color', $cssContent);
    }

    /**
     * Test that all required assets are loaded
     */
    public function test_required_assets_loaded()
    {
        $response = $this->get('/builder/tailwind');
        
        // Check for GrapesJS assets
        $response->assertSee('grapesjs/dist/css/grapes.min.css');
        $response->assertSee('cdn.tailwindcss.com');
        
        // Check for custom plugin
        $response->assertSee('grapesjs-tailwind-plugin.js');
    }

    /**
     * Test GrapesJS plugin functionality
     */
    public function test_grapesjs_tailwind_plugin()
    {
        $response = $this->get('/js/grapesjs-tailwind-plugin.js');
        $response->assertStatus(200);
    }
}