<section class="space-y-6">
    <div class="flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-4">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section</p>
            <h1 class="text-2xl font-semibold text-gray-900">Overview</h1>
        </div>
        <a href="{{ route('admin.hub') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Back to Hub</a>
    </div>

    {!! $content !!}
</section>
