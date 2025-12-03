const vapidPublicKeyMeta = document.querySelector('meta[name="vapid-public-key"]');

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

async function registerServiceWorker() {
    if (!('serviceWorker' in navigator)) {
        return null;
    }

    return navigator.serviceWorker.register('/service-worker.js');
}

async function requestNotificationPermission() {
    if (!('Notification' in window)) {
        return 'denied';
    }

    const permission = await Notification.requestPermission();
    return permission;
}

async function subscribeUserToPush(registration) {
    if (!registration?.pushManager || !vapidPublicKeyMeta?.content) {
        return null;
    }

    return registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(vapidPublicKeyMeta.content),
    });
}

async function sendSubscriptionToServer(subscription) {
    if (!subscription) {
        return;
    }

    await window.axios.post('/push-subscriptions', subscription.toJSON());
}

async function ensureSubscription() {
    try {
        const registration = await registerServiceWorker();
        const permission = await requestNotificationPermission();

        if (permission !== 'granted') {
            return;
        }

        const subscription = await subscribeUserToPush(registration);
        await sendSubscriptionToServer(subscription);
    } catch (error) {
        console.error('Unable to register push notifications', error);
    }
}

window.bookingNotifications = {
    init() {
        const form = document.getElementById('booking-contact-form');

        if (form) {
            form.addEventListener('submit', () => {
                ensureSubscription();
            });
        }

        ensureSubscription();
    },
};
