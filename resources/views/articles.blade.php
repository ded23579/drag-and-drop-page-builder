@extends('layouts.app')

@section('title', 'Articles')
@section('description', 'Browse our collection of articles on various topics. Stay updated with the latest content and insights.')
@section('keywords', 'articles, blog, content, news, information')

@section('content')
    <style>
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            padding: 20px;
        }
        .article-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            transition: all 0.3s ease;
            height: auto;
            min-height: 140px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }
        .article-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
            z-index: -1;
            border-radius: 12px;
        }
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
        }
        .article-content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .article-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 16px 0;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
            transition: color 0.2s;
        }
        .article-card:hover .article-title {
            color: #3b82f6;
        }
        .article-link {
            display: inline-block;
            padding: 10px 16px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            align-self: flex-start;
            border: none;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }
        .article-link:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.4);
            color: #fff;
        }
        .article-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }
        .article-card:hover::after {
            transform: scaleX(1);
        }
    </style>

    @if (count($items) === 0)
        <div style="padding:20px;text-align:center;color:#6b7280">
            <p>No articles found. The remote site may not expose an RSS feed or our parser needs tuning.</p>
        </div>
    @else
        <div style="margin-bottom:12px;color:#6b7280">
            Found <strong>{{ count($items) }}</strong> articles
        </div>
        <div class="articles-grid">
            @foreach ($items as $it)
                <div class="article-card">
                    <div class="article-content">
                        <p class="article-title">{{ $it['title'] }}</p>
                        @if (!empty($it['link']))
                            <a href="{{ $it['link'] }}" target="_blank" class="article-link">Read More →</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
