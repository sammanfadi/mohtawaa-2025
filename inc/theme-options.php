<?php
/**
 * صفحة خيارات القالب في لوحة الإدارة
 * تحتوي على إعدادات إضافية للقالب
 */

// منع الوصول المباشر للملف
if (!defined('ABSPATH')) {
    exit;
}

/**
 * إضافة صفحة خيارات القالب
 */
function muhtawaa_add_theme_options_page() {
    add_theme_page(
        __('خيارات قالب muhtawaa', 'muhtawaa'),
        __('خيارات القالب', 'muhtawaa'),
        'manage_options',
        'muhtawaa-theme-options',
        'muhtawaa_theme_options_page'
    );
}
add_action('admin_menu', 'muhtawaa_add_theme_options_page');

/**
 * محتوى صفحة خيارات القالب
 */
function muhtawaa_theme_options_page() {
    // التحقق من الصلاحيات
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // حفظ الإعدادات
    if (isset($_POST['submit']) && wp_verify_nonce($_POST['muhtawaa_nonce'], 'muhtawaa_save_options')) {
        muhtawaa_save_theme_options();
        echo '<div class="notice notice-success"><p>' . __('تم حفظ الإعدادات بنجاح!', 'muhtawaa') . '</p></div>';
    }
    
    // الحصول على الإعدادات الحالية
    $options = get_option('muhtawaa_theme_options', muhtawaa_get_default_options());
    ?>
    
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('muhtawaa_save_options', 'muhtawaa_nonce'); ?>
            
            <table class="form-table">
                
                <!-- إعدادات عامة -->
                <tr>
                    <th scope="row" colspan="2">
                        <h2><?php _e('الإعدادات العامة', 'muhtawaa'); ?></h2>
                    </th>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="enable_lazy_loading"><?php _e('تفعيل التحميل التدريجي للصور', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="enable_lazy_loading" name="enable_lazy_loading" value="1" <?php checked($options['enable_lazy_loading'], 1); ?> />
                        <p class="description"><?php _e('يحسن سرعة تحميل الصفحة', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="enable_smooth_scrolling"><?php _e('تفعيل التمرير السلس', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="enable_smooth_scrolling" name="enable_smooth_scrolling" value="1" <?php checked($options['enable_smooth_scrolling'], 1); ?> />
                        <p class="description"><?php _e('يجعل التمرير أكثر سلاسة', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="enable_back_to_top"><?php _e('إظهار زر العودة للأعلى', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="enable_back_to_top" name="enable_back_to_top" value="1" <?php checked($options['enable_back_to_top'], 1); ?> />
                        <p class="description"><?php _e('يظهر زر للعودة لأعلى الصفحة', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <!-- إعدادات الأداء -->
                <tr>
                    <th scope="row" colspan="2">
                        <h2><?php _e('إعدادات الأداء', 'muhtawaa'); ?></h2>
                    </th>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="minify_css"><?php _e('ضغط ملفات CSS', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="minify_css" name="minify_css" value="1" <?php checked($options['minify_css'], 1); ?> />
                        <p class="description"><?php _e('يقلل حجم ملفات CSS', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="minify_js"><?php _e('ضغط ملفات JavaScript', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="minify_js" name="minify_js" value="1" <?php checked($options['minify_js'], 1); ?> />
                        <p class="description"><?php _e('يقلل حجم ملفات JavaScript', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="remove_query_strings"><?php _e('إزالة معاملات الاستعلام', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="remove_query_strings" name="remove_query_strings" value="1" <?php checked($options['remove_query_strings'], 1); ?> />
                        <p class="description"><?php _e('يحسن التخزين المؤقت', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <!-- إعدادات SEO -->
                <tr>
                    <th scope="row" colspan="2">
                        <h2><?php _e('إعدادات SEO', 'muhtawaa'); ?></h2>
                    </th>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="enable_schema_markup"><?php _e('تفعيل Schema Markup', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="enable_schema_markup" name="enable_schema_markup" value="1" <?php checked($options['enable_schema_markup'], 1); ?> />
                        <p class="description"><?php _e('يحسن ظهور الموقع في نتائج البحث', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="enable_open_graph"><?php _e('تفعيل Open Graph', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="enable_open_graph" name="enable_open_graph" value="1" <?php checked($options['enable_open_graph'], 1); ?> />
                        <p class="description"><?php _e('يحسن مشاركة المحتوى على وسائل التواصل', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="google_analytics_id"><?php _e('معرف Google Analytics', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="google_analytics_id" name="google_analytics_id" value="<?php echo esc_attr($options['google_analytics_id']); ?>" class="regular-text" />
                        <p class="description"><?php _e('مثال: G-XXXXXXXXXX', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <!-- إعدادات المحتوى -->
                <tr>
                    <th scope="row" colspan="2">
                        <h2><?php _e('إعدادات المحتوى', 'muhtawaa'); ?></h2>
                    </th>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="excerpt_length"><?php _e('طول المقتطف (كلمة)', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="number" id="excerpt_length" name="excerpt_length" value="<?php echo esc_attr($options['excerpt_length']); ?>" min="10" max="100" />
                        <p class="description"><?php _e('عدد الكلمات في مقتطف المقال', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="reading_speed"><?php _e('سرعة القراءة (كلمة/دقيقة)', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="number" id="reading_speed" name="reading_speed" value="<?php echo esc_attr($options['reading_speed']); ?>" min="100" max="300" />
                        <p class="description"><?php _e('لحساب وقت القراءة المقدر', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="related_posts_count"><?php _e('عدد المقالات المشابهة', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <input type="number" id="related_posts_count" name="related_posts_count" value="<?php echo esc_attr($options['related_posts_count']); ?>" min="2" max="6" />
                        <p class="description"><?php _e('عدد المقالات المشابهة المعروضة', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <!-- إعدادات التصميم المتقدمة -->
                <tr>
                    <th scope="row" colspan="2">
                        <h2><?php _e('إعدادات التصميم المتقدمة', 'muhtawaa'); ?></h2>
                    </th>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="custom_css"><?php _e('CSS مخصص', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <textarea id="custom_css" name="custom_css" rows="10" cols="50" class="large-text code"><?php echo esc_textarea($options['custom_css']); ?></textarea>
                        <p class="description"><?php _e('أضف CSS مخصص هنا', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="custom_js"><?php _e('JavaScript مخصص', 'muhtawaa'); ?></label>
                    </th>
                    <td>
                        <textarea id="custom_js" name="custom_js" rows="10" cols="50" class="large-text code"><?php echo esc_textarea($options['custom_js']); ?></textarea>
                        <p class="description"><?php _e('أضف JavaScript مخصص هنا (بدون علامات script)', 'muhtawaa'); ?></p>
                    </td>
                </tr>
                
            </table>
            
            <?php submit_button(__('حفظ الإعدادات', 'muhtawaa')); ?>
            
        </form>
        
        <!-- معلومات القالب -->
        <div class="postbox" style="margin-top: 20px;">
            <h3 class="hndle" style="padding: 15px;"><?php _e('معلومات القالب', 'muhtawaa'); ?></h3>
            <div class="inside" style="padding: 15px;">
                <p><strong><?php _e('اسم القالب:', 'muhtawaa'); ?></strong> Muhtawaa Theme</p>
                <p><strong><?php _e('الإصدار:', 'muhtawaa'); ?></strong> <?php echo MUHTAWAA_VERSION; ?></p>
                <p><strong><?php _e('المطور:', 'muhtawaa'); ?></strong> Manus AI</p>
                <p><strong><?php _e('الوصف:', 'muhtawaa'); ?></strong> <?php _e('قالب ووردبريس مخصص للمحتوى المعرفي القصير', 'muhtawaa'); ?></p>
                
                <h4><?php _e('الميزات:', 'muhtawaa'); ?></h4>
                <ul style="list-style: disc; margin-right: 20px;">
                    <li><?php _e('تصميم نظيف ومتجاوب', 'muhtawaa'); ?></li>
                    <li><?php _e('دعم الوضع الليلي', 'muhtawaa'); ?></li>
                    <li><?php _e('نظام فلترة المقالات', 'muhtawaa'); ?></li>
                    <li><?php _e('مؤشر تقدم القراءة', 'muhtawaa'); ?></li>
                    <li><?php _e('تحسين محركات البحث', 'muhtawaa'); ?></li>
                    <li><?php _e('دعم Elementor', 'muhtawaa'); ?></li>
                    <li><?php _e('سرعة تحميل محسنة', 'muhtawaa'); ?></li>
                </ul>
            </div>
        </div>
        
    </div>
    
    <style>
    .form-table th {
        width: 200px;
    }
    .form-table h2 {
        margin: 0;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        color: #23282d;
    }
    .postbox {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 4px;
    }
    .postbox .hndle {
        background: #f6f7f7;
        border-bottom: 1px solid #c3c4c7;
        margin: 0;
    }
    </style>
    
    <?php
}

/**
 * حفظ إعدادات القالب
 */
function muhtawaa_save_theme_options() {
    $options = array();
    
    // الإعدادات العامة
    $options['enable_lazy_loading'] = isset($_POST['enable_lazy_loading']) ? 1 : 0;
    $options['enable_smooth_scrolling'] = isset($_POST['enable_smooth_scrolling']) ? 1 : 0;
    $options['enable_back_to_top'] = isset($_POST['enable_back_to_top']) ? 1 : 0;
    
    // إعدادات الأداء
    $options['minify_css'] = isset($_POST['minify_css']) ? 1 : 0;
    $options['minify_js'] = isset($_POST['minify_js']) ? 1 : 0;
    $options['remove_query_strings'] = isset($_POST['remove_query_strings']) ? 1 : 0;
    
    // إعدادات SEO
    $options['enable_schema_markup'] = isset($_POST['enable_schema_markup']) ? 1 : 0;
    $options['enable_open_graph'] = isset($_POST['enable_open_graph']) ? 1 : 0;
    $options['google_analytics_id'] = sanitize_text_field($_POST['google_analytics_id']);
    
    // إعدادات المحتوى
    $options['excerpt_length'] = absint($_POST['excerpt_length']);
    $options['reading_speed'] = absint($_POST['reading_speed']);
    $options['related_posts_count'] = absint($_POST['related_posts_count']);
    
    // إعدادات التصميم المتقدمة
    $options['custom_css'] = wp_strip_all_tags($_POST['custom_css']);
    $options['custom_js'] = wp_strip_all_tags($_POST['custom_js']);
    
    update_option('muhtawaa_theme_options', $options);
}

/**
 * الحصول على الإعدادات الافتراضية
 */
function muhtawaa_get_default_options() {
    return array(
        'enable_lazy_loading' => 1,
        'enable_smooth_scrolling' => 1,
        'enable_back_to_top' => 1,
        'minify_css' => 0,
        'minify_js' => 0,
        'remove_query_strings' => 1,
        'enable_schema_markup' => 1,
        'enable_open_graph' => 1,
        'google_analytics_id' => '',
        'excerpt_length' => 25,
        'reading_speed' => 200,
        'related_posts_count' => 3,
        'custom_css' => '',
        'custom_js' => '',
    );
}

/**
 * إضافة CSS و JavaScript مخصص
 */
function muhtawaa_add_custom_styles_scripts() {
    $options = get_option('muhtawaa_theme_options', muhtawaa_get_default_options());
    
    // إضافة CSS مخصص
    if (!empty($options['custom_css'])) {
        echo '<style type="text/css">' . $options['custom_css'] . '</style>';
    }
    
    // إضافة JavaScript مخصص
    if (!empty($options['custom_js'])) {
        echo '<script type="text/javascript">' . $options['custom_js'] . '</script>';
    }
    
    // إضافة Google Analytics
    if (!empty($options['google_analytics_id'])) {
        ?>
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($options['google_analytics_id']); ?>"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_attr($options['google_analytics_id']); ?>');
        </script>
        <?php
    }
}
add_action('wp_head', 'muhtawaa_add_custom_styles_scripts');

/**
 * تطبيق إعدادات الأداء
 */
function muhtawaa_apply_performance_settings() {
    $options = get_option('muhtawaa_theme_options', muhtawaa_get_default_options());

    // إزالة معاملات الاستعلام
    if ($options['remove_query_strings']) {
        add_filter('style_loader_src', 'muhtawaa_remove_version_strings');
        add_filter('script_loader_src', 'muhtawaa_remove_version_strings');
    }
}
add_action('init', 'muhtawaa_apply_performance_settings');

/**
 * إزالة متغير ver من روابط الملفات الثابتة
 *
 * @param string $src رابط الملف
 * @return string الرابط بعد إزالة متغير الإصدار
 */
function muhtawaa_remove_version_strings($src) {
    return remove_query_arg('ver', $src);
}

/**
 * تطبيق إعدادات المحتوى
 */
function muhtawaa_apply_content_settings() {
    $options = get_option('muhtawaa_theme_options', muhtawaa_get_default_options());
    
    // تخصيص طول المقتطف
    add_filter('excerpt_length', function($length) use ($options) {
        return $options['excerpt_length'];
    }, 999);
}
add_action('init', 'muhtawaa_apply_content_settings');

?>
