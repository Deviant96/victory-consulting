self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', () => {
    clients.claim();
});

self.addEventListener('push', (event) => {
    let data = {};

    if (event.data) {
        data = event.data.json();
    }

    const title = data.title || 'New Notification';
    const options = {
        body: data.body || '',
        data: data.data || {},
        icon: '/favicon.ico',
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    const targetUrl = event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if (client.url === targetUrl && 'focus' in client) {
                    return client.focus();
                }
            }

            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
