<section class="space-y-4">
    <div class="flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-4">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section</p>
            <h1 class="text-2xl font-semibold text-gray-900">Email Dashboard</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ config('imap.webmail_url', 'https://mail.titan.email') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 active:scale-95 transition-all duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Open Titan Email
            </a>
            <a href="{{ route('admin.hub') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-700 active:scale-95 transition-all duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Hub
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <aside class="lg:col-span-3">
            <nav class="bg-white border border-gray-200 rounded-2xl shadow-sm p-3 space-y-1">
                <p class="px-3 pt-1 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Folders</p>
                <a href="{{ route('admin.email.inbox') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.email.inbox') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    Inbox
                </a>
                <a href="{{ route('admin.email.sent') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.email.sent') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Sent
                </a>
                <a href="{{ route('admin.email.drafts') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.email.drafts') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Drafts
                </a>

                <div class="border-t border-gray-100 my-2"></div>

                <a href="{{ config('imap.webmail_url', 'https://mail.titan.email') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-blue-600 hover:bg-blue-50 font-medium">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Open Titan Email ↗
                </a>
            </nav>
        </aside>

        <div class="lg:col-span-9 space-y-6">
            {!! $content !!}
        </div>
    </div>
</section>
