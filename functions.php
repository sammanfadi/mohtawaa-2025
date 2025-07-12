diff --git a/functions.php b/functions.php
index c4ac86c41ead72210b232157acbf06e8cf6109be..b5d92e990897b766ec04ac1a26b42cbcda08b584 100644
--- a/functions.php
+++ b/functions.php
@@ -1,45 +1,64 @@
 <?php
 /**
  * ملف الوظائف الرئيسي لقالب muhtawaa
  * يحتوي على جميع الوظائف والإعدادات المطلوبة
  */
 
 // منع الوصول المباشر للملف
 if (!defined('ABSPATH')) {
     exit;
 }
 
 // تعريف الثوابت الخاصة بالقالب
 define('MUHTAWAA_THEME_URL', get_template_directory_uri());
 define('MUHTAWAA_VERSION', '1.0.0');
 
 // تضمين ملفات الإعدادات الإضافية
 require_once get_template_directory() . '/inc/customizer.php';
 require_once get_template_directory() . '/inc/theme-options.php';
 require_once get_template_directory() . '/customizer-advanced.php';
 
+// وظائف دعم PWA
+function muhtawaa_pwa_meta() {
+    echo '<link rel="manifest" href="' . esc_url(MUHTAWAA_THEME_URL . '/manifest.json') . '">' . "\n";
+    echo '<meta name="theme-color" content="#4A90E2">' . "\n";
+}
+add_action('wp_head', 'muhtawaa_pwa_meta');
+
+function muhtawaa_pwa_service_worker() {
+    ?>
+    <script>
+    if ('serviceWorker' in navigator) {
+        window.addEventListener('load', function() {
+            navigator.serviceWorker.register('<?php echo esc_url(MUHTAWAA_THEME_URL . '/service-worker.js'); ?>');
+        });
+    }
+    </script>
+    <?php
+}
+add_action('wp_footer', 'muhtawaa_pwa_service_worker');
 // 1. إعدادات القالب
 function muhtawaa_theme_setup() {
     // إضافة دعم الصور المميزة
     add_theme_support('post-thumbnails');
     
     // إضافة دعم للغة RTL
     add_theme_support('rtl');
 
     // تسجيل قائمة التنقل
     register_nav_menus(array(
         'primary' => 'القائمة الرئيسية',
         'footer'  => 'قائمة الفوتر',
     ));
 
     // إضافة دعم لخيارات الخلفية المخصصة
     add_theme_support('custom-background');
 
     // إضافة دعم لElementor
     add_theme_support('elementor');
     
     // تسجيل أحجام الصور المخصصة
     add_image_size('muhtawaa-featured', 400, 250, true);
     add_image_size('muhtawaa-thumbnail', 150, 150, true);
 
     // دعم الشعار المخصص
