<section class="space-y-4">
    <div class="flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-4">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section</p>
            <h1 class="text-2xl font-semibold text-gray-900">Client Inquiries</h1>
        </div>
        <a href="{{ route('admin.hub') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Back to Hub</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <aside class="lg:col-span-3">
            <nav class="bg-white border border-gray-200 rounded-2xl shadow-sm p-3 space-y-1">
                <a href="{{ route('admin.bookings.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">All Inquiries</a>
                <a href="{{ route('admin.settings.booking') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.booking') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Notification Settings</a>
                <a href="{{ route('admin.whatsapp-agents.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.whatsapp-agents.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">WhatsApp Agents</a>
            </nav>
        </aside>

        <div class="lg:col-span-9 space-y-6">
            {!! $content !!}
        </div>
    </div>
</section>
