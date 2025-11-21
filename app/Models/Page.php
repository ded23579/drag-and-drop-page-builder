<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'html',
        'css',
        'json',
        'published'
    ];

    protected $casts = [
        'published' => 'boolean',
        'json' => 'array',
    ];

    /**
     * Generate a slug from the title
     */
    public function generateSlug($title)
    {
        $slug = str()->slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $this->slug = $slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->generateSlug($page->title);
            }
        });
    }
}