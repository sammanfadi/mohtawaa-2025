<?php
/**
 * إعدادات المخصص المتقدمة للقالب الاحترافي
 */

function muhtawaa_advanced_customizer($wp_customize) {
    
    // قسم إعدادات Hero Section
    $wp_customize->add_section('muhtawaa_hero_section', array(
        'title'    => __('إعدادات البطل الرئيسي', 'muhtawaa'),
        'priority' => 25,
    ));

    // إظهار قسم البطل
    $wp_customize->add_setting('muhtawaa_show_hero', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('muhtawaa_show_hero', array(
        'label'    => __('إظهار قسم البطل', 'muhtawaa'),
        'section'  => 'muhtawaa_hero_section',
        'type'     => 'checkbox',
    ));

    // عنوان البطل
    $wp_customize->add_setting('muhtawaa_hero_title', array(
        'default'           => 'مرحباً بك في عالم المحتوى المعرفي',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('muhtawaa_hero_title', array(
        'label'    => __('عنوان البطل', 'muhtawaa'),
        'section'  => 'muhtawaa_hero_section',
        'type'     => 'text',
    ));

    // عنوان فرعي للبطل
    $wp_customize->add_setting('muhtawaa_hero_subtitle', array(
        'default'           => 'اكتشف المعرفة في 90 ثانية - محتوى مفيد وسريع',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('muhtawaa_hero_subtitle', array(
        'label'    => __('العنوان الفرعي', 'muhtawaa'),
        'section'  => 'muhtawaa_hero_section',
        'type'     => 'textarea',
    ));

    // نص زر الدعوة للعمل
    $wp_customize->add_setting('muhtawaa_hero_cta_text', array(
        'default'           => 'استكشف المقالات',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('muhtawaa_hero_cta_text', array(
        'label'    => __('نص زر الدعوة للعمل', 'muhtawaa'),
        'section'  => 'muhtawaa_hero_section',
        'type'     => 'text',
    ));

    // رابط زر الدعوة للعمل
    $wp_customize->add_setting('muhtawaa_hero_cta_link', array(
        'default'           => '#articles',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('muhtawaa_hero_cta_link', array(
        'label'    => __('رابط زر الدعوة للعمل', 'muhtawaa'),
        'section'  => 'muhtawaa_hero_section',
        'type'     => 'url',
    ));

    // صورة خلفية البطل
    $wp_customize->add_setting('muhtawaa_hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'muhtawaa_hero_background_image', array(
        'label'    => __('صورة خلفية البطل', 'muhtawaa'),
        'section'  => 'muhtawaa_hero_section',
        'settings' => 'muhtawaa_hero_background_image',
    )));

    // قسم إعدادات الألوان المتقدمة
    $wp_customize->add_section('muhtawaa_advanced_colors', array(
        'title'    => __('الألوان المتقدمة', 'muhtawaa'),
        'priority' => 30,
    ));

    // اللون الأساسي
    $wp_customize->add_setting('muhtawaa_primary_color', array(
        'default'           => '#2c5aa0',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_primary_color', array(
        'label'    => __('اللون الأساسي', 'muhtawaa'),
        'section'  => 'muhtawaa_advanced_colors',
        'settings' => 'muhtawaa_primary_color',
    )));

    // لون التمييز
    $wp_customize->add_setting('muhtawaa_accent_color', array(
        'default'           => '#ffd700',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_accent_color', array(
        'label'    => __('لون التمييز', 'muhtawaa'),
        'section'  => 'muhtawaa_advanced_colors',
        'settings' => 'muhtawaa_accent_color',
    )));

    // قسم إعدادات الخطوط
    $wp_customize->add_section('muhtawaa_typography', array(
        'title'    => __('إعدادات الخطوط', 'muhtawaa'),
        'priority' => 35,
    ));

    // حجم الخط الأساسي
    $wp_customize->add_setting('muhtawaa_base_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('muhtawaa_base_font_size', array(
        'label'       => __('حجم الخط الأساسي (px)', 'muhtawaa'),
        'section'     => 'muhtawaa_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // خط العناوين
    $wp_customize->add_setting('muhtawaa_heading_font', array(
        'default'           => 'Cairo',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('muhtawaa_heading_font', array(
        'label'   => __('خط العناوين', 'muhtawaa'),
        'section' => 'muhtawaa_typography',
        'type'    => 'select',
        'choices' => array(
            'Cairo'     => 'Cairo',
            'Tajawal'   => 'Tajawal',
            'Amiri'     => 'Amiri',
            'Almarai'   => 'Almarai',
            'Scheherazade' => 'Scheherazade',
        ),
    ));

    // قسم إعدادات الأداء
    $wp_customize->add_section('muhtawaa_performance', array(
        'title'    => __('إعدادات الأداء', 'muhtawaa'),
        'priority' => 40,
    ));

    // تحميل الصور التدريجي
    $wp_customize->add_setting('muhtawaa_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('muhtawaa_lazy_loading', array(
        'label'    => __('تفعيل التحميل التدريجي للصور', 'muhtawaa'),
        'section'  => 'muhtawaa_performance',
        'type'     => 'checkbox',
    ));

    // ضغط CSS
    $wp_customize->add_setting('muhtawaa_minify_css', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('muhtawaa_minify_css', array(
        'label'    => __('ضغط ملفات CSS', 'muhtawaa'),
        'section'  => 'muhtawaa_performance',
        'type'     => 'checkbox',
    ));

    // قسم وسائل التواصل الاجتماعي
    $wp_customize->add_section('muhtawaa_social_media', array(
        'title'    => __('وسائل التواصل الاجتماعي', 'muhtawaa'),
        'priority' => 45,
    ));

    $social_platforms = array(
        'facebook'  => 'فيسبوك',
        'twitter'   => 'تويتر', 
        'instagram' => 'إنستغرام',
        'youtube'   => 'يوتيوب',
        'linkedin'  => 'لينكد إن',
        'telegram'  => 'تلغرام',
        'whatsapp'  => 'واتساب',
    );

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting("muhtawaa_social_{$platform}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("muhtawaa_social_{$platform}", array(
            'label'    => sprintf(__('رابط %s', 'muhtawaa'), $label),
            'section'  => 'muhtawaa_social_media',
            'type'     => 'url',
        ));
    }

    // قسم إعدادات SEO المتقدمة
    $wp_customize->add_section('muhtawaa_advanced_seo', array(
        'title'    => __('إعدادات SEO المتقدمة', 'muhtawaa'),
        'priority' => 50,
    ));

    // Google Analytics
    $wp_customize->add_setting('muhtawaa_google_analytics', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('muhtawaa_google_analytics', array(
        'label'       => __('معرف Google Analytics', 'muhtawaa'),
        'section'     => 'muhtawaa_advanced_seo',
        'type'        => 'text',
        'description' => __('أدخل معرف Google Analytics (مثل: GA_MEASUREMENT_ID)', 'muhtawaa'),
    ));

    // Meta Description الافتراضي
    $wp_customize->add_setting('muhtawaa_default_meta_description', array(
        'default'           => get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('muhtawaa_default_meta_description', array(
        'label'    => __('وصف Meta الافتراضي', 'muhtawaa'),
        'section'  => 'muhtawaa_advanced_seo',
        'type'     => 'textarea',
    ));
}

add_action('customize_register', 'muhtawaa_advanced_customizer');

/**
 * إضافة CSS مخصص بناءً على إعدادات المخصص المتقدمة
 */
function muhtawaa_advanced_customizer_css() {
    $primary_color = get_theme_mod('muhtawaa_primary_color', '#2c5aa0');
    $accent_color = get_theme_mod('muhtawaa_accent_color', '#ffd700');
    $base_font_size = get_theme_mod('muhtawaa_base_font_size', '16');
    $heading_font = get_theme_mod('muhtawaa_heading_font', 'Cairo');
    
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --accent-color: <?php echo esc_attr($accent_color); ?>;
            --font-size-base: <?php echo esc_attr($base_font_size); ?>px;
            --heading-font: "<?php echo esc_attr($heading_font); ?>", Arial, sans-serif;
        }
        
        <?php if (get_theme_mod('muhtawaa_heading_font', 'Cairo') !== 'Cairo') : ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $heading_font)); ?>:wght@300;400;500;600;700;800&display=swap');
        <?php endif; ?>
        
        body {
            font-size: var(--font-size-base);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--heading-font);
        }
    </style>
    <?php
}
add_action('wp_head', 'muhtawaa_advanced_customizer_css', 11);

/**
 * إضافة Google Analytics
 */
function muhtawaa_add_google_analytics() {
    $ga_id = get_theme_mod('muhtawaa_google_analytics');
    
    if (!empty($ga_id)) {
        ?>
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_attr($ga_id); ?>');
        </script>
        <?php
    }
}
add_action('wp_head', 'muhtawaa_add_google_analytics', 12);