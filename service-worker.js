self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('app-cache').then(cache => {
      return cache.addAll([
        '/',
        '/assets/css/plugins/all.min.css',
        '/assets/css/plugins/flaticon.css',
        '/assets/css/style.css',
        // Add other URLs or paths to cache
      ]);
    })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
