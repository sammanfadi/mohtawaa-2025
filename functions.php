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
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // دعم HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // دعم تخصيص الخلفية
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ));
}
add_action('after_setup_theme', 'muhtawaa_theme_setup');

// 2. إضافة ملفات CSS و JS
function muhtawaa_enqueue_assets() {
    // تحميل CSS المخصص
    wp_enqueue_style('muhtawaa-style', get_stylesheet_uri());

    // تحميل CSS للوضع الليلي
    wp_enqueue_style('muhtawaa-dark-mode', MUHTAWAA_THEME_URL . '/css/dark-mode.css', array('muhtawaa-style'), MUHTAWAA_VERSION);

    // تحميل CSS للتجاوب
    wp_enqueue_style('muhtawaa-responsive', MUHTAWAA_THEME_URL . '/css/responsive.css', array('muhtawaa-style'), MUHTAWAA_VERSION);

    // تحميل ملفات CSS الاحترافية الجديدة
    wp_enqueue_style('muhtawaa-animations', MUHTAWAA_THEME_URL . '/css/animations.css', array('muhtawaa-style'), MUHTAWAA_VERSION);
    wp_enqueue_style('muhtawaa-components', MUHTAWAA_THEME_URL . '/css/components.css', array('muhtawaa-style'), MUHTAWAA_VERSION);

    // ملفات الستايل والسكريبت المنقولة من القوالب
    wp_enqueue_style('muhtawaa-header', MUHTAWAA_THEME_URL . '/css/header.css', array('muhtawaa-style'), MUHTAWAA_VERSION);
    wp_enqueue_style('muhtawaa-footer', MUHTAWAA_THEME_URL . '/css/footer.css', array('muhtawaa-style'), MUHTAWAA_VERSION);
    wp_enqueue_script('muhtawaa-header', MUHTAWAA_THEME_URL . '/js/header.js', array(), MUHTAWAA_VERSION, true);
    wp_enqueue_script('muhtawaa-footer', MUHTAWAA_THEME_URL . '/js/footer.js', array(), MUHTAWAA_VERSION, true);
    if (is_single()) {
        wp_enqueue_style('muhtawaa-single', MUHTAWAA_THEME_URL . '/css/single.css', array('muhtawaa-style'), MUHTAWAA_VERSION);
    }

    // تحميل ملف JavaScript الرئيسي
    $script_deps = array();
    // تم دمج أكواد الوضع الليلي في main.js، لذا لا حاجة لملف منفصل
    if (get_theme_mod('muhtawaa_show_audio_button', true)) {
        wp_enqueue_script('muhtawaa-tts', 'https://code.responsivevoice.org/responsivevoice.js', array(), null, true);
        $script_deps[] = 'muhtawaa-tts';
    }
    wp_enqueue_script('muhtawaa-main', MUHTAWAA_THEME_URL . '/js/main.js', $script_deps, MUHTAWAA_VERSION, true);
    wp_enqueue_script('muhtawaa-advanced', MUHTAWAA_THEME_URL . '/js/advanced-features.js', array('muhtawaa-main'), MUHTAWAA_VERSION, true);
    
    // تمرير متغيرات PHP إلى JavaScript
    wp_localize_script('muhtawaa-main', 'muhtawaa_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('muhtawaa_nonce'),
        'strings'  => array(
            'loading'    => __('جاري التحميل...', 'muhtawaa'),
            'error'      => __('حدث خطأ، يرجى المحاولة مرة أخرى', 'muhtawaa'),
            'copied'     => __('تم نسخ الرابط بنجاح!', 'muhtawaa'),
            'share'      => __('مشاركة', 'muhtawaa'),
        )
    ));
    wp_localize_script('muhtawaa-main', 'muhtawaa_settings', array(
        'showReadingProgress' => get_theme_mod('muhtawaa_show_reading_progress', true),
        'showAudioButton'     => get_theme_mod('muhtawaa_show_audio_button', true),
        'audioVoice'          => get_theme_mod('muhtawaa_audio_voice', 'Arabic Female'),
        'audioSpeed'          => floatval(get_theme_mod('muhtawaa_audio_speed', 1)),
    ));
    // تحميل ملف التعليقات إذا لزم الأمر
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // تحميل خط Tajawal من Google Fonts
    wp_enqueue_style('muhtawaa-fonts', 'https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap', false);
}
add_action('wp_enqueue_scripts', 'muhtawaa_enqueue_assets');

// 3. إضافة فلاتر لتحسين SEO
function muhtawaa_seo_meta_tags() {
    if (is_single()) {
        echo '<meta name="description" content="' . get_the_excerpt() . '">';
        $tags = get_the_tags();
        if ($tags) {
            $tags_array = array();
            foreach ($tags as $tag) {
                $tags_array[] = $tag->name; // الحصول على أسماء الوسوم فقط
            }
            $tags_string = implode(', ', $tags_array); // دمج الوسوم في سلسلة نصية مفصولة بفواصل
            echo '<meta name="keywords" content="' . esc_attr($tags_string) . '">';
        }
    }
}
add_action('wp_head', 'muhtawaa_seo_meta_tags');

// 4. تحسين العناوين
function muhtawaa_title_filter($title) {
    if (is_home()) {
        $title .= ' | مرحباً بكم في محتوى';
    }
    return $title;
}
add_filter('wp_title', 'muhtawaa_title_filter');

// 5. إضافة وظائف جافا سكربت مخصصة
function muhtawaa_custom_js() {
    echo "<script type='text/javascript'>
        // كود جافا سكربت مخصص
        console.log('Welcome to Muhtawaa!');
    </script>";
}
add_action('wp_footer', 'muhtawaa_custom_js');

// 6. تحسين الأداء: تحميل مخصص للصور
function muhtawaa_lazy_load_images($content) {
    $content = preg_replace('/<img(.*?)src=/', '<img$1data-src=', $content);
    return $content;
}
add_filter('the_content', 'muhtawaa_lazy_load_images');

// 7. إضافة فلاتر لتحسين تجربة المستخدم
function muhtawaa_user_experience_filter() {
    // إضافة تخصيصات مثل الوضع الليلي
    add_filter('the_content', 'add_social_share_buttons');
}

// 8. الفلاتر للتخصيص
function add_social_share_buttons($content) {
    if (is_single()) {
        $content .= '<div class="social-share">شارك المقال:</div>';
        $content .= '<button>مشاركة على فيسبوك</button>';
    }
    return $content;
}

// 9. إضافة الدعم لـ Elementor
function muhtawaa_elementor_support() {
    // تسجيل مواقع Elementor
    add_theme_support('elementor');
    add_theme_support('elementor-full-width');
    add_theme_support('elementor-header-footer');
}
add_action('after_setup_theme', 'muhtawaa_elementor_support');

// 10. تخصيص استعلام المقالات الرئيسي
function muhtawaa_modify_main_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_home()) {
            $query->set('posts_per_page', get_theme_mod('muhtawaa_posts_per_page', 6));
        }
    }
}
add_action('pre_get_posts', 'muhtawaa_modify_main_query');

// 11. إضافة AJAX للفلترة
function muhtawaa_filter_posts() {
    if (!wp_verify_nonce($_POST['nonce'], 'muhtawaa_nonce')) {
        wp_die(__('خطأ في الأمان', 'muhtawaa'));
    }
    
    $category = sanitize_text_field($_POST['category']);
    $paged = intval($_POST['paged']);
    
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => get_theme_mod('muhtawaa_posts_per_page', 6),
        'paged'          => $paged
    );
    
    if ($category && $category !== 'all') {
        $args['category_name'] = $category;
    }
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'card');
        }
    } else {
        echo '<p class="no-posts">' . __('لا توجد مقالات في هذا التصنيف', 'muhtawaa') . '</p>';
    }
    
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_muhtawaa_filter_posts', 'muhtawaa_filter_posts');
add_action('wp_ajax_nopriv_muhtawaa_filter_posts', 'muhtawaa_filter_posts');

// 12. إضافة meta tags للمقالات
function muhtawaa_add_meta_tags() {
    if (is_single()) {
        global $post;
        
        $description = wp_trim_words(strip_tags($post->post_content), 25, '...');
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        
        if ($image) {
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
        }
        
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
        
        if ($image) {
            echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'muhtawaa_add_meta_tags');

// إضافة Schema Markup للمقالات
function muhtawaa_schema_markup() {
    if (is_single()) {
        global $post;
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        $logo = '';
        if (has_custom_logo()) {
            $logo_id = get_theme_mod('custom_logo');
            $logo_src = wp_get_attachment_image_src($logo_id, 'full');
            if ($logo_src) {
                $logo = $logo_src[0];
            }
        }
        $schema = array(
            '@context' => 'https://schema.org',
            '@type'    => 'Article',
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id'   => get_permalink(),
            ),
            'headline'       => get_the_title(),
            'image'          => $image ? $image : '',
            'datePublished'  => get_the_date('c'),
            'dateModified'   => get_the_modified_date('c'),
            'author'         => array(
                '@type' => 'Person',
                'name'  => get_the_author(),
            ),
            'publisher'      => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo('name'),
                'logo'  => array(
                    '@type' => 'ImageObject',
                    'url'   => $logo,
                ),
            ),
            'description'    => wp_trim_words(strip_tags($post->post_content), 25, '...'),
        );

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }
}
add_action('wp_head', 'muhtawaa_schema_markup');

// دالة وقت القراءة وعرضه
function muhtawaa_reading_time($content = '') {
    if (empty($content)) {
        $content = get_the_content();
    }
    
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 كلمة في الدقيقة
    
    if ($reading_time < 1) {
        $reading_time = 1;
    }
    
    return $reading_time;
}

function muhtawaa_display_reading_time() {
    $reading_time = muhtawaa_reading_time();
    $seconds = $reading_time * 60;
    
    if ($seconds < 60) {
        echo '<span class="reading-time">⏱️ ' . $seconds . ' ' . __('ثانية', 'muhtawaa') . '</span>';
    } else {
        $minutes = ceil($seconds / 60);
        echo '<span class="reading-time">⏱️ ' . $minutes . ' ' . __('دقيقة', 'muhtawaa') . '</span>';
    }
}

// 13. دالة المقالات المشابهة
function muhtawaa_get_related_posts($post_id = null, $limit = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return array();
    }
    
    $args = array(
        'category__in'   => $categories,
        'post__not_in'   => array($post_id),
        'posts_per_page' => $limit,
        'orderby'        => 'rand',
        'post_status'    => 'publish'
    );
    
    return get_posts($args);
}

function muhtawaa_display_related_posts() {
    $related_posts = muhtawaa_get_related_posts();
    
    if (empty($related_posts)) {
        return;
    }
    
    echo '<div class="related-articles">';
    echo '<h3>' . __('مقالات ذات صلة', 'muhtawaa') . '</h3>';
    echo '<div class="related-grid">';
    
    foreach ($related_posts as $post) {
        setup_postdata($post);
        $categories = get_the_category($post->ID);
        $first_category = !empty($categories) ? $categories[0] : null;
        
        echo '<div class="related-card">';
        echo '<h4><a href="' . get_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a></h4>';
        if ($first_category) {
            echo '<span class="article-tag">#' . $first_category->name . '</span>';
        }
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
    
    wp_reset_postdata();
}
?>
