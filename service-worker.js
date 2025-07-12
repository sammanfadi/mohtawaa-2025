diff --git a//dev/null b/service-worker.js
index 0000000000000000000000000000000000000000..f4aa0d5cfb87e1b6d14708dbf2b639e5ce586751 100644
--- a//dev/null
+++ b/service-worker.js
@@ -0,0 +1,30 @@
+const CACHE_NAME = 'muhtawaa-cache-v1';
+const OFFLINE_URLS = [
+  '/',
+  '/index.php',
+  '/style.css',
+];
+
+self.addEventListener('install', event => {
+  event.waitUntil(
+    caches.open(CACHE_NAME).then(cache => cache.addAll(OFFLINE_URLS))
+  );
+  self.skipWaiting();
+});
+
+self.addEventListener('activate', event => {
+  event.waitUntil(
+    caches.keys().then(keys => Promise.all(
+      keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
+    ))
+  );
+  self.clients.claim();
+});
+
+self.addEventListener('fetch', event => {
+  event.respondWith(
+    caches.match(event.request).then(response => {
+      return response || fetch(event.request);
+    })
+  );
+});
