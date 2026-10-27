/**
 * Hakajobs Theme Service Worker (PWA Deprecated Cleanup)
 * 
 * Unregisters any previously registered PWA service worker and purges legacy caches.
 */
self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key.indexOf('hakajobs-pwa') !== -1) {
                        return caches.delete(key);
                    }
                })
            );
        }).then(() => {
            return self.registration.unregister();
        }).then(() => {
            return self.clients.claim();
        })
    );
});
