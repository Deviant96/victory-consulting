<section class="space-y-4">
    <div class="flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-4">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section</p>
            <h1 class="text-2xl font-semibold text-gray-900">Website</h1>
        </div>
        <a href="{{ route('admin.hub') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Back to Hub</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <aside class="lg:col-span-3">
            <nav class="bg-white border border-gray-200 rounded-2xl shadow-sm p-3 space-y-1">
                <div class="px-3 py-2">
                    <div class="flex items-center gap-2 text-sm font-semibold {{ request()->routeIs('admin.pages.*') ? 'text-blue-700' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" id="Common-File-Stack--Streamline-Ultimate" height="20" width="20">
                        <desc>
                            Common File Stack Streamline Icon: https://streamlinehq.com
                        </desc>
                        <g id="Common-File-Stack--Streamline-Ultimate.svg">
                            <path d="M18.17 18.5H8a0.5 0.5 0 0 1 -0.5 -0.5V4.33a1 1 0 0 0 -2 0v14.34a1.83 1.83 0 0 0 1.83 1.83h10.84a1 1 0 0 0 0 -2Z" fill="currentColor" stroke-width="1"></path>
                            <path d="M14.67 22H4.5a0.5 0.5 0 0 1 -0.5 -0.5V7.83a1 1 0 0 0 -2 0v14.34A1.83 1.83 0 0 0 3.83 24h10.84a1 1 0 1 0 0 -2Z" fill="currentColor" stroke-width="1"></path>
                            <path d="m21.48 3.57 -2.86 -3a1.82 1.82 0 0 0 -1.3 -0.57H11a2 2 0 0 0 -2 2v13a2 2 0 0 0 2 2h9.17A1.83 1.83 0 0 0 22 15.17V4.84a1.78 1.78 0 0 0 -0.52 -1.27Z" fill="currentColor" stroke-width="1"></path>
                        </g>
                    </svg>
                        <span>Pages</span>
                    </div>
                    <div class="mt-2 ml-7 space-y-1">
                        <a href="{{ route('admin.pages.home') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.pages.home') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Homepage</a>
                        <a href="{{ route('admin.pages.industry') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.pages.industry') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Industries</a>
                        <a href="{{ route('admin.pages.services') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.pages.services') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Services</a>
                        <a href="{{ route('admin.pages.blog') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.pages.blog') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Blog</a>
                        <a href="{{ route('admin.pages.contact') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.pages.contact') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Contact Us</a>
                    </div>
                </div>

                <div class="px-3 py-2 border-t border-gray-100 mt-2 pt-3">
                    <div class="flex items-center gap-2 text-sm font-semibold {{ request()->routeIs('admin.articles.*', 'admin.services.*', 'admin.business-solutions.*', 'admin.sub-solutions.*', 'admin.faqs.*', 'admin.team.*') ? 'text-blue-700' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" id="Pencil-1--Streamline-Ultimate" height="20" width="20">
                        <desc>
                            Pencil 1 Streamline Icon: https://streamlinehq.com
                        </desc>
                        <g id="Pencil-1--Streamline-Ultimate.svg">
                            <path d="M12.558333333333334 3.3333333333333335a0.4083333333333333 0.4083333333333333 0 0 0 -0.3 -0.125 0.4166666666666667 0.4166666666666667 0 0 0 -0.2916666666666667 0.11666666666666668L2.8666666666666667 12.425a0.4166666666666667 0.4166666666666667 0 0 0 0 0.5916666666666667l4.116666666666667 4.116666666666667a0.42500000000000004 0.42500000000000004 0 0 0 0.3 0.125 0.4083333333333333 0.4083333333333333 0 0 0 0.2916666666666667 -0.125L16.666666666666668 8.041666666666668a0.42500000000000004 0.42500000000000004 0 0 0 0 -0.5916666666666667Z" fill="currentColor" stroke-width="0.8333"></path>
                            <path d="M2.0250000000000004 14.000000000000002a0.42500000000000004 0.42500000000000004 0 0 0 -0.7 0.2L0.06666666666666667 19.425a0.4083333333333333 0.4083333333333333 0 0 0 0.11666666666666668 0.39166666666666666 0.42500000000000004 0.42500000000000004 0 0 0 0.39166666666666666 0.11666666666666668L5.833333333333334 18.675a0.4083333333333333 0.4083333333333333 0 0 0 0.3 -0.2916666666666667 0.43333333333333335 0.43333333333333335 0 0 0 -0.1 -0.4083333333333333Z" fill="currentColor" stroke-width="0.8333"></path>
                            <path d="M19.333333333333332 2.4333333333333336 17.566666666666666 0.6666666666666667a2.1 2.1 0 0 0 -2.95 0l-1.175 1.1833333333333333a0.4 0.4 0 0 0 0 0.5833333333333334l4.125 4.166666666666667a0.4 0.4 0 0 0 0.5833333333333334 0l1.1833333333333333 -1.225a2.0833333333333335 2.0833333333333335 0 0 0 0 -2.9416666666666664Z" fill="currentColor" stroke-width="0.8333"></path>
                        </g>
                    </svg>
                        <span>Content Management</span>
                    </div>
                    <div class="mt-2 ml-7 space-y-1">
                        <a href="{{ route('admin.articles.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.articles.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Blog</a>
                        <a href="{{ route('admin.services.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.services.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Services</a>
                        <a href="{{ route('admin.business-solutions.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.business-solutions.*', 'admin.sub-solutions.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Industries</a>
                        <a href="{{ route('admin.faqs.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.faqs.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">FAQs</a>
                        <a href="{{ route('admin.team.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.team.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Team</a>
                    </div>
                </div>

                <div class="px-3 py-2 border-t border-gray-100 mt-2 pt-3">
                    <a href="{{ route('admin.website.appearance') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.website.appearance') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M12 18.75V21M4.72 4.72l1.59 1.59M17.69 17.69l1.59 1.59M3 12h2.25M18.75 12H21M4.72 19.28l1.59-1.59M17.69 6.31l1.59-1.59M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                        Appearance
                    </a>
                </div>
            </nav>
        </aside>

        <div class="lg:col-span-9 space-y-6">
            {!! $content !!}
        </div>
    </div>
</section>
