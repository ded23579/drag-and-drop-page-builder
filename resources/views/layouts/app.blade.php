<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Meta Description -->
    <meta name="description" content="@yield('description', config('app.description', 'Default description for your Laravel application'))">

    <!-- Meta Keywords -->
    <meta name="keywords" content="@yield('keywords', config('app.keywords', 'laravel, php, web development'))">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'Laravel'))">
    <meta property="og:description" content="@yield('description', config('app.description', 'Default description for your Laravel application'))">
    <meta property="og:image" content="@yield('og_image', asset('images/default-image.WebP'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', config('app.name', 'Laravel'))">
    <meta property="twitter:description" content="@yield('description', config('app.description', 'Default description for your Laravel application'))">
    <meta property="twitter:image" content="@yield('og_image', asset('images/default-image.WebP'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="icon" type="image/webp" href="{{ asset('images/default-image.WebP') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { width: 100%; height: 100%; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            overflow: hidden;
        }
        
        .layout {
            display: flex;
            width: 100%;
            height: 100vh;
        }
        
        /* Sidebar - Fixed */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            padding: 20px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        }
        
        .sidebar h3 {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .sidebar a {
            display: block;
            color: #e0e0e0;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 6px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(4px);
        }
        
        .sidebar a.active {
            background: #3b82f6;
            color: #fff;
            border-left: 3px solid #60a5fa;
            font-weight: 600;
        }
        
        .sidebar .ad-sidebar-top,
        .sidebar .ad-sidebar-bottom {
            padding: 0;
            background: rgba(255,255,255,0.05);
            border: 1px dashed rgba(255,255,255,0.2);
            border-radius: 6px;
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            text-align: center;
            margin: 15px 0;
        }

        #ad-container-sidebar,
        #ad-container-top,
        #ad-container-bottom {
            width: 100%;
            height: 100%;
        }

        /* Main Content - Scrollable */
        .content {
            margin-left: 220px;
            width: calc(100% - 220px);
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f5f5;
        }
        
        .content-header {
            background: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            flex-shrink: 0;
        }
        
        .content-header strong {
            font-size: 18px;
            color: #1a1a2e;
        }
        
        .content-main {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px;
        }
        
        .content-main::-webkit-scrollbar {
            width: 8px;
        }
        
        .content-main::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .content-main::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }
        
        .content-main::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
        
        /* Ad Banners */
        .ad-banner {
            width: 100%;
            max-width: 728px;
            padding: 15px;
            margin: 15px auto;
            background: #f0f0f0;
            border: 2px dashed #ccc;
            border-radius: 8px;
            text-align: center;
            color: #888;
            font-size: 12px;
            font-weight: 600;
            box-sizing: border-box;
        }
        
        /* Top Actions */
        .top-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: space-between;
        }
        
        .top-actions button {
            padding: 10px 20px;
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .top-actions button:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }
        
        .top-actions button:active {
            transform: translateY(0);
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f0f0f0;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
    </style>
    @stack('head')
</head>
<body>
    <div class="layout">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <h3>📱 Menu</h3>
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">🏠 About</a>
            <a href="{{ route('articles.index') }}" class="{{ request()->is('articles*') ? 'active' : '' }}">📰 Articles</a>
            <a href="{{ route('page-builder.index') }}" class="{{ request()->is('page-builder*') ? 'active' : '' }}">🎨 Page Builder</a>

            <!-- AD 300x250 -->
            <div class="ad-sidebar-top" id="sidebar-ad">
                <div id="ad-container-sidebar">
                    <script type="text/javascript">
                    atOptions = {
                    'key' : 'f0b7960e86f7aac1f68b1bf9ded91e9d',
                    'format' : 'iframe',
                    'height' : 250,
                    'width' : 300,
                    'params' : {}
                    };
                    </script>
                    <script type="text/javascript" src="//intermediategillsevent.com/f0b7960e86f7aac1f68b1bf9ded91e9d/invoke.js"></script>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="content">
            <!-- Header with Title and Actions -->
            <div class="content-header">
                <div class="top-actions">
                    <div><strong>@yield('title', 'Page')</strong></div>
                    @yield('header-actions')
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="content-main">
                <!-- Top Ad Banner -->
                <div class="ad-banner" id="top-ad-banner">
                    <div id="ad-container-top">
                        <script type="text/javascript">
                        atOptions = {
                        'key' : '6d31c8a2fb25ec112b9cc104aff6751a',
                        'format' : 'iframe',
                        'height' : 90,
                        'width' : 728,
                        'params' : {}
                        };
                        </script>
                        <script type="text/javascript" src="//intermediategillsevent.com/6d31c8a2fb25ec112b9cc104aff6751a/invoke.js"></script>
                    </div>
                </div>

                @yield('content')

                <!-- Bottom Ad Banner -->
                <div class="ad-banner" style="margin-top: 30px;" id="bottom-ad-banner">
                    <div id="ad-container-bottom">
                        <script type="text/javascript">
                        atOptions = {
                        'key' : '6d31c8a2fb25ec112b9cc104aff6751a',
                        'format' : 'iframe',
                        'height' : 90,
                        'width' : 728,
                        'params' : {}
                        };
                        </script>
                        <script type="text/javascript" src="//intermediategillsevent.com/6d31c8a2fb25ec112b9cc104aff6751a/invoke.js"></script>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
    <!-- Ad Refresh Script -->
    <script>
        function refreshAds() {
            // Reload ad containers by re-executing their content
            // Sidebar ad
            var sidebarAdContainer = document.getElementById('ad-container-sidebar');
            if(sidebarAdContainer) {
                // Create a temporary container to hold the original content
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = `<script type="text/javascript">
                atOptions = {
                'key' : 'f0b7960e86f7aac1f68b1bf9ded91e9d',
                'format' : 'iframe',
                'height' : 250,
                'width' : 300,
                'params' : {}
                };
                <\/script>
                <script type="text/javascript" src="//intermediategillsevent.com/f0b7960e86f7aac1f68b1bf9ded91e9d/invoke.js"><\/script>`;

                // Replace the content and re-execute scripts
                sidebarAdContainer.innerHTML = '';
                sidebarAdContainer.appendChild(tempDiv);

                // Execute scripts in the new content
                var scripts = tempDiv.querySelectorAll('script');
                scripts.forEach(function(script) {
                    var newScript = document.createElement('script');
                    newScript.type = 'text/javascript';
                    if(script.src) {
                        newScript.src = script.src;
                    } else {
                        newScript.textContent = script.textContent;
                    }
                    sidebarAdContainer.appendChild(newScript);
                });
            }

            // Top ad
            var topAdContainer = document.getElementById('ad-container-top');
            if(topAdContainer) {
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = `<script type="text/javascript">
                atOptions = {
                'key' : '6d31c8a2fb25ec112b9cc104aff6751a',
                'format' : 'iframe',
                'height' : 90,
                'width' : 728,
                'params' : {}
                };
                <\/script>
                <script type="text/javascript" src="//intermediategillsevent.com/6d31c8a2fb25ec112b9cc104aff6751a/invoke.js"><\/script>`;

                topAdContainer.innerHTML = '';
                topAdContainer.appendChild(tempDiv);

                var scripts = tempDiv.querySelectorAll('script');
                scripts.forEach(function(script) {
                    var newScript = document.createElement('script');
                    newScript.type = 'text/javascript';
                    if(script.src) {
                        newScript.src = script.src;
                    } else {
                        newScript.textContent = script.textContent;
                    }
                    topAdContainer.appendChild(newScript);
                });
            }

            // Bottom ad
            var bottomAdContainer = document.getElementById('ad-container-bottom');
            if(bottomAdContainer) {
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = `<script type="text/javascript">
                atOptions = {
                'key' : '6d31c8a2fb25ec112b9cc104aff6751a',
                'format' : 'iframe',
                'height' : 90,
                'width' : 728,
                'params' : {}
                };
                <\/script>
                <script type="text/javascript" src="//intermediategillsevent.com/6d31c8a2fb25ec112b9cc104aff6751a/invoke.js"><\/script>`;

                bottomAdContainer.innerHTML = '';
                bottomAdContainer.appendChild(tempDiv);

                var scripts = tempDiv.querySelectorAll('script');
                scripts.forEach(function(script) {
                    var newScript = document.createElement('script');
                    newScript.type = 'text/javascript';
                    if(script.src) {
                        newScript.src = script.src;
                    } else {
                        newScript.textContent = script.textContent;
                    }
                    bottomAdContainer.appendChild(newScript);
                });
            }
        }

        // Set interval to refresh ads every 5 seconds
        setInterval(refreshAds, 5000);
    </script>
</body>
</html>
