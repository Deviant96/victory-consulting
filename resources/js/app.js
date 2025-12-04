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
        }
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
        }
    }));
});

window.Alpine = Alpine;

Alpine.start();
