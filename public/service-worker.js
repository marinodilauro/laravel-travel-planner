/**
 * L'installazione viene attivata quando la registrazione del service worker ha successo.
 * Dopo l'installazione, il browser tenta di attivare il service worker.
 * Si mettono in cache le risorse statiche che consentono alla PWA di funzionare offline.
 */
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('app-cache').then(cache => {
      return cache.addAll([
        '/',
        '/scss/app.css',
        '/js/app.js',
        '/offline.html'
      ]);
    })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    }).catch(() => {
      return caches.match('/offline.html');
    })
  );
});

