<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    /**
     * Display the page builder interface.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pagebuilder.index');
    }

    /**
     * Save page content from the page builder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'title' => 'nullable|string|max:255',
        ]);

        // For now, we'll just return a success response
        // In a real application, you'd save the content to a database

        return response()->json([
            'success' => true,
            'message' => 'Page saved successfully'
        ]);
    }

    /**
     * Load existing page content.
     *
     * @param  string|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function load($id = null)
    {
        // For now, return empty content
        // In a real application, you'd load content from a database

        return response()->json([
            'content' => '',
            'title' => 'New Page'
        ]);
    }
}
