import './bootstrap';

import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
    Alpine.data('adminLayout', () => ({
        sidebarOpen: false,
        init() {
            this.syncSidebarWithViewport();
            window.addEventListener('resize', () => this.syncSidebarWithViewport());
            this.$watch('sidebarOpen', (open) => {
                const shouldLock = open && window.innerWidth < 1024;
                document.body.classList.toggle('overflow-hidden', shouldLock);
            });
        },
        syncSidebarWithViewport() {
            this.sidebarOpen = window.innerWidth >= 1024 ? true : this.sidebarOpen;
            if (window.innerWidth >= 1024) {
                document.body.classList.remove('overflow-hidden');
            }
        },
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
        closeSidebar() {
            if (window.innerWidth < 1024) {
                this.sidebarOpen = false;
            }
        },
    }));

    Alpine.data('collapsibleCard', (id) => ({
        id,
        collapsed: false,
        init() {
            const saved = sessionStorage.getItem(`admin-card-${this.id}`);
            this.collapsed = saved === 'collapsed';
        },
        toggle() {
            this.collapsed = !this.collapsed;
            sessionStorage.setItem(`admin-card-${this.id}`, this.collapsed ? 'collapsed' : 'expanded');
        },
    }));

    Alpine.data('frontendSearch', () => ({
        open: false,
        loading: false,
        query: '',
        index: null,
        error: null,

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.ensureIndex();
                this.focusInput();
            }
        },

        openPanel() {
            this.open = true;
            this.ensureIndex();
        },

        close() {
            this.open = false;
        },

        clear() {
            this.query = '';
            this.focusInput();
        },

        focusInput() {
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        },

        async ensureIndex() {
            if (this.index || this.loading) {
                return;
            }

            this.loading = true;
            this.error = null;

            try {
                const response = await fetch('/search');

                if (!response.ok) {
                    throw new Error('Search is unavailable right now.');
                }

                this.index = await response.json();
            } catch (error) {
                console.error(error);
                this.error = 'Unable to load search results. Please try again later.';
            } finally {
                this.loading = false;
            }
        },

        filterCollection(items, term) {
            if (!Array.isArray(items)) {
                return [];
            }

            if (!term) {
                return items.slice(0, 5);
            }

            return items.filter((item) => {
                const haystack = [item.title, item.subtitle, item.type]
                    .filter(Boolean)
                    .map((value) => value.toLowerCase());

                return haystack.some((value) => value.includes(term));
            });
        },

        get filteredResults() {
            if (!this.index) {
                return {
                    services: [],
                    team: [],
                    articles: [],
                    contacts: [],
                };
            }

            const term = this.query.trim().toLowerCase();

            return {
                services: this.filterCollection(this.index.services, term),
                team: this.filterCollection(this.index.team, term),
                articles: this.filterCollection(this.index.articles, term),
                contacts: this.filterCollection(this.index.contacts, term),
            };
        },

        get groupedResults() {
            const results = this.filteredResults;

            return [
                { key: 'services', label: 'Services', items: results.services ?? [] },
                { key: 'team', label: 'Team', items: results.team ?? [] },
                { key: 'articles', label: 'Articles', items: results.articles ?? [] },
                { key: 'contacts', label: 'Contact info', items: results.contacts ?? [] },
            ];
        },

        get hasResults() {
            return this.groupedResults.some((group) => group.items.length > 0);
        },
    }));

    Alpine.data('translationGrid', (config) => ({
        languages: config.languages || [],
        rows: [],
        groups: config.groups || [],
        filters: { search: '', group: 'all' },
        filteredRows: [],
        saving: {},
        lastNotice: '',

        init() {
            this.rows = this.normalizeRows(config.rows);
            this.applyFilters();
        },

        normalizeRows(rows) {
            if (Array.isArray(rows)) {
                return rows;
            }

            if (rows && typeof rows === 'object') {
                return Object.values(rows);
            }

            return [];
        },

        applyFilters() {
            const term = this.filters.search.trim().toLowerCase();

            this.filteredRows = (this.rows || []).filter((row) => {
                const matchesGroup = this.filters.group === 'all' || row.group === this.filters.group;
                const haystack = [row.group, row.key, ...Object.values(row.values || {})]
                    .filter(Boolean)
                    .join(' ')
                    .toLowerCase();
                const matchesSearch = !term || haystack.includes(term);

                return matchesGroup && matchesSearch;
            });
        },

        cellKey(rowId, languageCode) {
            return `${rowId}-${languageCode}`;
        },

        isSaving(rowId, languageCode) {
            return Boolean(this.saving[this.cellKey(rowId, languageCode)]);
        },

        async saveCell(row, languageCode) {
            const key = this.cellKey(row.id, languageCode);
            this.saving[key] = true;

            try {
                const response = await fetch(config.updateUrl.replace('__ID__', row.id), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrf,
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({
                        language_code: languageCode,
                        value: row.values?.[languageCode] ?? '',
                    }),
                });

                if (!response.ok) {
                    const error = await response.json().catch(() => ({}));
                    throw new Error(error.message || 'Unable to save translation right now.');
                }

                const result = await response.json();
                row.preview = result.preview;
                this.lastNotice = `Saved ${row.key} (${languageCode.toUpperCase()}) at ${new Date().toLocaleTimeString()}`;
            } catch (error) {
                console.error(error);
                this.lastNotice = error.message;
            } finally {
                delete this.saving[key];
            }
        },
    }));
});

window.Alpine = Alpine;

Alpine.start();

const setupPageShell = () => {
    const shell = document.querySelector('main');

    if (!shell) return;

    shell.classList.add('page-shell');

    window.requestAnimationFrame(() => {
        shell.classList.add('is-loaded');
    });
};

const applyStaggerDelays = () => {
    document.querySelectorAll('[data-animate-stagger]').forEach((container) => {
        const step = Number(container.dataset.animateStagger) || 120;
        const children = container.querySelectorAll('[data-animate]');

        children.forEach((child, index) => {
            if (!child.dataset.animateDelay && !child.style.getPropertyValue('--a-delay')) {
                child.style.setProperty('--a-delay', `${index * step}ms`);
            }
        });
    });
};

const setupScrollAnimations = () => {
    const animated = Array.from(document.querySelectorAll('[data-animate]'));

    if (!animated.length) {
        return;
    }

    applyStaggerDelays();

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        animated.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.18,
            rootMargin: '0px 0px -5% 0px',
        },
    );

    animated.forEach((el) => {
        const delay = el.dataset.animateDelay;
        if (delay && !el.style.getPropertyValue('--a-delay')) {
            el.style.setProperty('--a-delay', `${delay}ms`);
        }

        observer.observe(el);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    setupPageShell();
    setupScrollAnimations();
});
