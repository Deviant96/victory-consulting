<section class="space-y-4">
    <div class="flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-4">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section</p>
            <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
        </div>
        <a href="{{ route('admin.hub') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-700 active:scale-95 transition-all duration-150 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Hub
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <aside class="lg:col-span-3">
            <nav class="bg-white border border-gray-200 rounded-2xl shadow-sm p-3 space-y-1">
                <a href="{{ route('admin.settings.branding') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.branding') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Branding</a>
                <a href="{{ route('admin.settings.contact') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.contact') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Contact Info</a>
                <a href="{{ route('admin.settings.social') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.social') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Social Links</a>
                <a href="{{ route('admin.languages.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.languages.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Languages</a>
                <a href="{{ route('admin.translations.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.translations.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Text Translations</a>
            </nav>
        </aside>

        <div class="lg:col-span-9 space-y-6">
            {!! $content !!}
        </div>
    </div>
</section>
