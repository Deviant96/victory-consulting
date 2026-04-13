<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Victory CMS</title>

    <!-- Favicon -->
    @if(settings('branding.favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . settings('branding.favicon')) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">

    @stack('styles')
</head>
<body class="font-sans antialiased admin-shell" x-data="adminLayout()">
    <div class="min-h-screen bg-slate-200">
        @include('admin.partials.header')

        @include('admin.partials.search-modal')

        <main class="py-8">
            <div class="admin-container space-y-6">
                @if (isset($header))
                    <div class="mb-2">
                        <h1 class="text-3xl font-bold text-slate-900">
                            {{ $header }}
                        </h1>
                    </div>
                @endif

                @if (session()->has('success') || session()->has('error'))
                    <div class="space-y-3">
                        @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
                            @if (session($type))
                                <div
                                    x-data="{ show: true }"
                                    x-init="setTimeout(() => show = false, 4000)"
                                    x-show="show"
                                    x-transition.opacity.scale.duration.300ms
                                    class="flex items-start gap-3 bg-{{$color}}-50 border border-{{$color}}-200 text-{{$color}}-800 px-4 py-3 rounded-xl shadow-sm"
                                >
                                    <div class="mt-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="flex-1 text-sm">{{ session($type) }}</p>
                                    <button type="button" @click="show = false" class="text-{{$color}}-700 hover:text-{{$color}}-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @php
                    $sectionLayout = match (true) {
                        request()->routeIs('admin.hub', 'admin.dashboard') => 'admin.layouts.hub-layout',
                        request()->routeIs('admin.overview') => 'admin.layouts.overview-layout',
                        request()->routeIs('admin.email.*') => 'admin.layouts.email-layout',
                        request()->routeIs('admin.bookings.*', 'admin.whatsapp-agents.*', 'admin.newsletter-subscribers.*', 'admin.settings.booking') => 'admin.layouts.inquiries-layout',
                        request()->routeIs('admin.settings.contact', 'admin.settings.social', 'admin.settings.branding', 'admin.settings.hero', 'admin.languages.*', 'admin.translations.*', 'admin.logs.*') => 'admin.layouts.settings-layout',
                        default => 'admin.layouts.website-layout',
                    };

                    $content = trim($__env->yieldContent('content'));
                @endphp

                @include($sectionLayout, ['content' => $content])
            </div>
        </main>
    </div>

    @stack('scripts')
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const storagePrefix = 'admin.tablePrefs.';
            const minWidth = 90;

            const loadState = (storageKey) => {
                try {
                    const saved = localStorage.getItem(storageKey);
                    if (!saved) {
                        return { hidden: {}, widths: {} };
                    }

                    const parsed = JSON.parse(saved);

                    return {
                        hidden: parsed.hidden || {},
                        widths: parsed.widths || {},
                    };
                } catch (error) {
                    return { hidden: {}, widths: {} };
                }
            };

            const initTablePreferences = (table) => {
                const prefsKey = table.dataset.tablePrefsKey;
                const headerRow = table.querySelector('thead tr');

                if (!prefsKey || !headerRow) {
                    return;
                }

                const headers = Array.from(headerRow.children).filter((cell) => cell.tagName === 'TH');

                if (!headers.length) {
                    return;
                }

                const columnCount = headers.length;
                const storageKey = storagePrefix + prefsKey;
                let state = loadState(storageKey);
                const colKeys = headers.map((th, index) => {
                    const key = th.dataset.colKey || 'col-' + index;
                    th.dataset.colKey = key;
                    th.classList.add('relative');
                    if (!th.getAttribute('title')) {
                        th.setAttribute('title', 'Drag right edge to resize this column');
                    }
                    return key;
                });

                let tableContainer = table.parentElement;
                if (!tableContainer.classList.contains('overflow-x-auto')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'overflow-x-auto';
                    tableContainer.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                    tableContainer = wrapper;
                }

                const controls = document.createElement('div');
                controls.className = 'px-6 pt-4 pb-2 flex flex-wrap justify-between items-center gap-2';
                controls.innerHTML = `
                    <p class="text-xs text-slate-500 inline-flex items-center gap-1.5">
                        <span class="text-slate-400">↔</span>
                        Drag column edges to resize
                    </p>
                    <div class="flex items-center gap-2">
                    <div class="relative">
                        <button type="button" class="table-columns-toggle inline-flex items-center px-3 py-1.5 text-xs font-medium border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50">
                            Columns
                        </button>
                        <div class="table-columns-panel hidden absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-lg p-3 z-20 max-h-72 overflow-auto"></div>
                    </div>
                    <button type="button" class="table-columns-reset inline-flex items-center px-3 py-1.5 text-xs font-medium border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50">
                        Reset
                    </button>
                    </div>
                `;
                tableContainer.parentElement.insertBefore(controls, tableContainer);

                const menuToggle = controls.querySelector('.table-columns-toggle');
                const menuPanel = controls.querySelector('.table-columns-panel');
                const resetButton = controls.querySelector('.table-columns-reset');

                const saveState = () => {
                    localStorage.setItem(storageKey, JSON.stringify(state));
                };

                const tableRows = () => {
                    return Array.from(table.querySelectorAll('tr')).filter((row) => row.children.length === columnCount);
                };

                const applyColumnVisibility = (index, hidden) => {
                    tableRows().forEach((row) => {
                        row.children[index].classList.toggle('hidden', hidden);
                    });
                };

                const applyColumnWidth = (index, width) => {
                    const safeWidth = Math.max(minWidth, Math.round(width));
                    tableRows().forEach((row) => {
                        const cell = row.children[index];
                        cell.style.width = safeWidth + 'px';
                        cell.style.minWidth = safeWidth + 'px';
                    });
                };

                const applyState = () => {
                    colKeys.forEach((key, index) => {
                        const hidden = !!state.hidden[key];
                        const width = state.widths[key];

                        applyColumnVisibility(index, hidden);
                        if (typeof width === 'number' && Number.isFinite(width)) {
                            applyColumnWidth(index, width);
                        }
                    });
                };

                const renderColumnMenu = () => {
                    menuPanel.innerHTML = '';

                    colKeys.forEach((key, index) => {
                        const label = (headers[index].innerText || headers[index].textContent || key).trim();
                        const checked = !state.hidden[key];
                        const item = document.createElement('label');
                        item.className = 'flex items-center gap-2 py-1.5 text-xs text-slate-700';
                        item.innerHTML = `
                            <input type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500" ${checked ? 'checked' : ''}>
                            <span>${label || ('Column ' + (index + 1))}</span>
                        `;

                        const input = item.querySelector('input');
                        input.addEventListener('change', function () {
                            const visibleCount = colKeys.filter((k) => !state.hidden[k]).length;

                            if (!this.checked && visibleCount <= 1) {
                                this.checked = true;
                                return;
                            }

                            state.hidden[key] = !this.checked;
                            applyColumnVisibility(index, !this.checked);
                            saveState();
                        });

                        menuPanel.appendChild(item);
                    });
                };

                colKeys.forEach((key, index) => {
                    const handle = document.createElement('span');
                    handle.className = 'absolute top-0 right-0 h-full w-3 cursor-col-resize select-none opacity-60 hover:opacity-100 transition-opacity';
                    handle.style.transform = 'translateX(50%)';
                    handle.setAttribute('role', 'separator');
                    handle.setAttribute('aria-label', 'Resize column');
                    handle.setAttribute('title', 'Drag to resize');
                    handle.innerHTML = '<span class="absolute right-1/2 top-1/2 h-8 -translate-y-1/2 border-r border-slate-300"></span>';

                    handle.addEventListener('mousedown', function (event) {
                        if (state.hidden[key]) {
                            return;
                        }

                        event.preventDefault();
                        const startX = event.clientX;
                        const startWidth = headers[index].getBoundingClientRect().width;

                        const onMouseMove = (moveEvent) => {
                            const nextWidth = startWidth + (moveEvent.clientX - startX);
                            applyColumnWidth(index, nextWidth);
                            handle.classList.add('opacity-100');
                        };

                        const onMouseUp = (upEvent) => {
                            const nextWidth = startWidth + (upEvent.clientX - startX);
                            state.widths[key] = Math.max(minWidth, Math.round(nextWidth));
                            saveState();
                            document.removeEventListener('mousemove', onMouseMove);
                            document.removeEventListener('mouseup', onMouseUp);
                            document.body.style.cursor = '';
                            document.body.style.userSelect = '';
                            handle.classList.remove('opacity-100');
                        };

                        document.body.style.cursor = 'col-resize';
                        document.body.style.userSelect = 'none';
                        document.addEventListener('mousemove', onMouseMove);
                        document.addEventListener('mouseup', onMouseUp);
                    });

                    headers[index].appendChild(handle);
                });

                menuToggle.addEventListener('click', function () {
                    menuPanel.classList.toggle('hidden');
                });

                document.addEventListener('click', function (event) {
                    if (!controls.contains(event.target)) {
                        menuPanel.classList.add('hidden');
                    }
                });

                resetButton.addEventListener('click', function () {
                    state = { hidden: {}, widths: {} };
                    saveState();
                    tableRows().forEach((row) => {
                        Array.from(row.children).forEach((cell) => {
                            cell.classList.remove('hidden');
                            cell.style.width = '';
                            cell.style.minWidth = '';
                        });
                    });
                    renderColumnMenu();
                });

                applyState();
                renderColumnMenu();
            };

            document.querySelectorAll('table[data-table-prefs-key]').forEach(initTablePreferences);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                allowInput: true,
            });
            
            flatpickr(".datetimepicker", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                allowInput: true,
            });
        });
    </script>
</body>
</html>
