self.addEventListener('push', (event) => {
    if (!event.data) {
        return;
    }

    let payload = {};

    try {
        payload = event.data.json();
    } catch (error) {
        payload = { title: 'New booking', body: event.data.text() };
    }

    const title = payload.title || 'New booking';
    const options = {
        body: payload.body || 'You have a new consultation request.',
        icon: payload.icon || '/favicon.ico',
        data: payload,
        tag: payload.tag || 'booking',
        actions: [
            { action: 'open', title: 'View details' },
        ],
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = event.notification?.data?.url || '/admin/bookings';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if ('focus' in client) {
                    client.navigate(url);
                    return client.focus();
                }
            }

            if (clients.openWindow) {
                return clients.openWindow(url);
            }

            return null;
        })
    );
});
