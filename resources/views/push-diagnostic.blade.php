<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Push Notification Diagnostic</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .test { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background-color: #d4edda; border-color: #c3e6cb; }
        .error { background-color: #f8d7da; border-color: #f5c6cb; }
        .info { background-color: #d1ecf1; border-color: #bee5eb; }
        button { padding: 10px 20px; margin: 10px 5px 10px 0; cursor: pointer; }
        pre { background-color: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
        code { font-family: monospace; }
    </style>
</head>
<body>
    <h1>🔔 Push Notification Diagnostic Tool</h1>
    
    <div class="test info">
        <h3>Environment Check</h3>
        <div id="env-check">Running checks...</div>
    </div>

    <div class="test info">
        <h3>Browser Compatibility</h3>
        <div id="browser-check">Running checks...</div>
    </div>

    <div class="test info">
        <h3>VAPID Configuration</h3>
        <div id="vapid-check">
            <p><strong>Public Key:</strong> <code>{{ config('webpush.vapid.public_key') }}</code></p>
            <p><strong>Subject:</strong> <code>{{ config('webpush.vapid.subject') }}</code></p>
        </div>
    </div>

    <div class="test">
        <h3>Test Steps</h3>
        <button id="btn-sw">1. Register Service Worker</button>
        <button id="btn-permission">2. Request Permission</button>
        <button id="btn-subscribe">3. Subscribe to Push</button>
        <button id="btn-unsubscribe">4. Unsubscribe</button>
        <div id="test-results"></div>
    </div>

    <div class="test">
        <h3>Detailed Logs</h3>
        <pre id="logs"></pre>
    </div>

    <div class="test info">
        <h3>❌ If You Get "AbortError: Registration failed - push service error"</h3>
        <p>This error means the browser's push service (FCM/Mozilla Push) rejected the subscription. Try these fixes:</p>
        <ol>
            <li><strong>Check Third-Party Cookies:</strong> In Chrome/Edge, go to Settings → Privacy → Cookies → Allow third-party cookies (or at least add an exception for this site)</li>
            <li><strong>Not in Incognito/Private Mode:</strong> Push notifications don't work reliably in private browsing</li>
            <li><strong>Clear Browser Data:</strong>
                <ul>
                    <li>Press F12 → Application → Clear Storage → Clear site data</li>
                    <li>Close and restart the browser completely</li>
                </ul>
            </li>
            <li><strong>Try a Different Browser:</strong> Firefox, Opera, or another Chromium-based browser</li>
            <li><strong>Network/Firewall:</strong> Corporate networks may block FCM endpoints (fcm.googleapis.com)</li>
            <li><strong>VPN/Proxy:</strong> Some VPNs block push services - try disabling temporarily</li>
            <li><strong>Browser Extension Conflicts:</strong> Disable ad blockers and privacy extensions temporarily</li>
        </ol>
        <p><strong>Alternative:</strong> Use email notifications instead of push notifications (they don't have these browser restrictions)</p>
    </div>

    <script>
        const vapidPublicKey = @json(config('webpush.vapid.public_key'));
        const logs = document.getElementById('logs');
        let registration = null;
        let subscription = null;

        function log(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const prefix = type === 'error' ? '❌' : type === 'success' ? '✅' : 'ℹ️';
            logs.textContent += `[${timestamp}] ${prefix} ${message}\n`;
            console.log(message);
            logs.scrollTop = logs.scrollHeight;
        }

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

        // Environment checks
        document.getElementById('env-check').innerHTML = `
            <p>✅ <strong>Protocol:</strong> ${window.location.protocol}</p>
            <p>${window.location.protocol === 'https:' ? '✅' : '❌'} <strong>HTTPS Required:</strong> ${window.location.protocol === 'https:' ? 'Yes' : 'No (REQUIRED!)'}</p>
            <p>✅ <strong>Origin:</strong> ${window.location.origin}</p>
        `;

        // Browser compatibility
        const hasServiceWorker = 'serviceWorker' in navigator;
        const hasPushManager = 'PushManager' in window;
        const hasNotification = 'Notification' in window;
        
        // Detect browser
        const isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
        const isEdge = /Edg/.test(navigator.userAgent);
        const isSamsung = /SamsungBrowser/.test(navigator.userAgent);
        const isFirefox = /Firefox/.test(navigator.userAgent);
        
        let browserWarning = '';
        if (isChrome && !isEdge) {
            browserWarning = '<p style="color: #856404; background-color: #fff3cd; padding: 10px; border-radius: 5px; margin-top: 10px;"><strong>⚠️ Chrome FCM Issue:</strong> If you get "AbortError: push service error", try using <strong>Microsoft Edge</strong> or <strong>Firefox</strong> instead. Edge works perfectly!</p>';
        } else if (isEdge || isSamsung) {
            browserWarning = '<p style="color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-top: 10px;"><strong>✅ Great Choice!</strong> This browser works well with push notifications.</p>';
        }

        document.getElementById('browser-check').innerHTML = `
            <p>${hasServiceWorker ? '✅' : '❌'} Service Worker API</p>
            <p>${hasPushManager ? '✅' : '❌'} Push Manager API</p>
            <p>${hasNotification ? '✅' : '❌'} Notification API</p>
            <p><strong>Browser:</strong> ${navigator.userAgent}</p>
            ${browserWarning}
        `;

        // Test 1: Register Service Worker
        document.getElementById('btn-sw').addEventListener('click', async () => {
            try {
                log('Registering service worker...');
                registration = await navigator.serviceWorker.register('{{ asset('service-worker.js') }}', {
                    scope: '{{ url('/') }}/'
                });
                log(`Service worker registered successfully!`, 'success');
                log(`Scope: ${registration.scope}`);
                log(`State: ${registration.active ? registration.active.state : 'installing'}`);
                
                await registration.update();
                await navigator.serviceWorker.ready;
                log('Service worker is ready', 'success');
            } catch (error) {
                log(`Service worker registration failed: ${error.message}`, 'error');
                console.error(error);
            }
        });

        // Test 2: Request Permission
        document.getElementById('btn-permission').addEventListener('click', async () => {
            try {
                log('Requesting notification permission...');
                const permission = await Notification.requestPermission();
                log(`Permission result: ${permission}`, permission === 'granted' ? 'success' : 'error');
            } catch (error) {
                log(`Permission request failed: ${error.message}`, 'error');
                console.error(error);
            }
        });

        // Test 3: Subscribe
        document.getElementById('btn-subscribe').addEventListener('click', async () => {
            try {
                if (!registration) {
                    log('Please register service worker first!', 'error');
                    return;
                }

                log('Converting VAPID key...');
                log(`VAPID key length: ${vapidPublicKey.length} chars`);
                const applicationServerKey = urlBase64ToUint8Array(vapidPublicKey);
                log(`Application server key: ${applicationServerKey.length} bytes`);

                // Check for existing subscription
                const existing = await registration.pushManager.getSubscription();
                if (existing) {
                    log('Found existing subscription, unsubscribing first...');
                    await existing.unsubscribe();
                    log('Unsubscribed from old subscription', 'success');
                }

                log('Creating new push subscription...');
                
                // Wait a bit for service worker to fully activate
                await new Promise(resolve => setTimeout(resolve, 500));
                
                subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: applicationServerKey
                });
                
                log('✅ Push subscription created successfully!', 'success');
                log(`Endpoint: ${subscription.endpoint.substring(0, 50)}...`);
                log('Subscription object:', 'success');
                console.log('Full subscription:', JSON.stringify(subscription, null, 2));
                
                document.getElementById('test-results').innerHTML = `
                    <div class="test success">
                        <h4>✅ Subscription Successful!</h4>
                        <p><strong>Endpoint:</strong> ${subscription.endpoint}</p>
                        <p><strong>Keys:</strong> Present (check console for details)</p>
                    </div>
                `;
            } catch (error) {
                log(`❌ Subscription failed: ${error.name}: ${error.message}`, 'error');
                console.error('Full error:', error);
                document.getElementById('test-results').innerHTML = `
                    <div class="test error">
                        <h4>❌ Subscription Failed</h4>
                        <p><strong>Error:</strong> ${error.name}</p>
                        <p><strong>Message:</strong> ${error.message}</p>
                        <p><strong>Check console for details</strong></p>
                    </div>
                `;
            }
        });

        // Test 4: Unsubscribe
        document.getElementById('btn-unsubscribe').addEventListener('click', async () => {
            try {
                if (!subscription) {
                    const existing = await registration.pushManager.getSubscription();
                    if (existing) {
                        await existing.unsubscribe();
                        log('Unsubscribed successfully', 'success');
                    } else {
                        log('No active subscription found', 'error');
                    }
                } else {
                    await subscription.unsubscribe();
                    subscription = null;
                    log('Unsubscribed successfully', 'success');
                }
            } catch (error) {
                log(`Unsubscribe failed: ${error.message}`, 'error');
                console.error(error);
            }
        });

        log('Diagnostic tool loaded. Click buttons above to test each step.');
    </script>
</body>
</html>
