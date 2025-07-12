<?php
/**
 * لوحة التحكم المخصصة لقالب muhtawaa
 * تحتوي على جميع خيارات التخصيص
 */

// منع الوصول المباشر للملف
if (!defined('ABSPATH')) {
    exit;
}

/**
 * إضافة خيارات التخصيص
 */
function muhtawaa_customize_register($wp_customize) {
    
    // إضافة قسم الألوان والتصميم
    $wp_customize->add_section('muhtawaa_colors', array(
        'title'    => __('الألوان والتصميم', 'muhtawaa'),
        'priority' => 30,
    ));
    
    // اللون الأساسي
    $wp_customize->add_setting('muhtawaa_primary_color', array(
        'default'           => '#4A90E2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_primary_color', array(
        'label'    => __('اللون الأساسي', 'muhtawaa'),
        'section'  => 'muhtawaa_colors',
        'settings' => 'muhtawaa_primary_color',
    )));
    
    // لون النص
    $wp_customize->add_setting('muhtawaa_text_color', array(
        'default'           => '#2C3E50',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_text_color', array(
        'label'    => __('لون النص', 'muhtawaa'),
        'section'  => 'muhtawaa_colors',
        'settings' => 'muhtawaa_text_color',
    )));
    
    // لون النص الثانوي
    $wp_customize->add_setting('muhtawaa_text_secondary_color', array(
        'default'           => '#7F8C8D',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_text_secondary_color', array(
        'label'    => __('لون النص الثانوي', 'muhtawaa'),
        'section'  => 'muhtawaa_colors',
        'settings' => 'muhtawaa_text_secondary_color',
    )));
    
    // لون الخلفية الثانوية
    $wp_customize->add_setting('muhtawaa_secondary_bg_color', array(
        'default'           => '#F8F9FA',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_secondary_bg_color', array(
        'label'    => __('لون الخلفية الثانوية', 'muhtawaa'),
        'section'  => 'muhtawaa_colors',
        'settings' => 'muhtawaa_secondary_bg_color',
    )));
    
    // إضافة قسم الخطوط
    $wp_customize->add_section('muhtawaa_typography', array(
        'title'    => __('الخطوط', 'muhtawaa'),
        'priority' => 35,
    ));
    
    // نوع الخط
    $wp_customize->add_setting('muhtawaa_font_family', array(
        'default'           => 'Tajawal',
        'sanitize_callback' => 'muhtawaa_sanitize_font_family',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_font_family', array(
        'label'    => __('نوع الخط', 'muhtawaa'),
        'section'  => 'muhtawaa_typography',
        'type'     => 'select',
        'choices'  => array(
            'Tajawal' => 'Tajawal',
            'Cairo'   => 'Cairo',
            'Almarai' => 'Almarai',
            'Amiri'   => 'Amiri',
            'Noto Sans Arabic' => 'Noto Sans Arabic',
        ),
    ));
    
    // حجم الخط الأساسي
    $wp_customize->add_setting('muhtawaa_font_size_base', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_font_size_base', array(
        'label'       => __('حجم الخط الأساسي (px)', 'muhtawaa'),
        'section'     => 'muhtawaa_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 20,
            'step' => 1,
        ),
    ));
    
    // حجم خط العناوين
    $wp_customize->add_setting('muhtawaa_font_size_heading', array(
        'default'           => '32',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_font_size_heading', array(
        'label'       => __('حجم خط العناوين (px)', 'muhtawaa'),
        'section'     => 'muhtawaa_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 24,
            'max'  => 48,
            'step' => 2,
        ),
    ));

    // حجم خط الجوال
    $wp_customize->add_setting('muhtawaa_mobile_font_size', array(
        'default'           => '17',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('muhtawaa_mobile_font_size', array(
        'label'       => __('حجم خط الجوال (px)', 'muhtawaa'),
        'section'     => 'muhtawaa_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 16,
            'max'  => 22,
            'step' => 1,
        ),
    ));
    
    // إضافة قسم التخطيط
    $wp_customize->add_section('muhtawaa_layout', array(
        'title'    => __('التخطيط', 'muhtawaa'),
        'priority' => 40,
    ));
    
    // عدد أعمدة البطاقات
    $wp_customize->add_setting('muhtawaa_grid_columns', array(
        'default'           => '3',
        'sanitize_callback' => 'muhtawaa_sanitize_grid_columns',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_grid_columns', array(
        'label'    => __('عدد أعمدة البطاقات', 'muhtawaa'),
        'section'  => 'muhtawaa_layout',
        'type'     => 'select',
        'choices'  => array(
            '2' => __('عمودين', 'muhtawaa'),
            '3' => __('ثلاثة أعمدة', 'muhtawaa'),
            '4' => __('أربعة أعمدة', 'muhtawaa'),
        ),
    ));

    // نصف قطر الأزرار
    $wp_customize->add_setting('muhtawaa_button_radius', array(
        'default'           => '8',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('muhtawaa_button_radius', array(
        'label'       => __('نصف قطر الأزرار (px)', 'muhtawaa'),
        'section'     => 'muhtawaa_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 30,
            'step' => 1,
        ),
    ));
    
    // عدد المقالات في الصفحة
    $wp_customize->add_setting('muhtawaa_posts_per_page', array(
        'default'           => '6',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('muhtawaa_posts_per_page', array(
        'label'       => __('عدد المقالات في الصفحة', 'muhtawaa'),
        'section'     => 'muhtawaa_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 3,
            'max'  => 12,
            'step' => 3,
        ),
    ));
    
    // إضافة قسم العناصر المرئية
    $wp_customize->add_section('muhtawaa_display', array(
        'title'    => __('العناصر المرئية', 'muhtawaa'),
        'priority' => 45,
    ));
    
    // إظهار شريط التصنيفات
    $wp_customize->add_setting('muhtawaa_show_categories_bar', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_show_categories_bar', array(
        'label'   => __('إظهار شريط التصنيفات', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));
    
    // إظهار زر الوضع الليلي
    $wp_customize->add_setting('muhtawaa_show_dark_mode_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_show_dark_mode_toggle', array(
        'label'   => __('إظهار زر الوضع الليلي', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));
    
    // إظهار الفوتر
    $wp_customize->add_setting('muhtawaa_show_footer', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_show_footer', array(
        'label'   => __('إظهار الفوتر', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));
    
    // إظهار وقت القراءة
    $wp_customize->add_setting('muhtawaa_show_reading_time', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_show_reading_time', array(
        'label'   => __('إظهار وقت القراءة', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));
    
    // إظهار أزرار المشاركة
    $wp_customize->add_setting('muhtawaa_show_share_buttons', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_show_share_buttons', array(
        'label'   => __('إظهار أزرار المشاركة', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));

    // إظهار زر العودة للأعلى
    $wp_customize->add_setting('muhtawaa_show_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('muhtawaa_show_back_to_top', array(
        'label'   => __('إظهار زر العودة للأعلى', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));
    
    // إظهار زر الاستماع للمقال
    $wp_customize->add_setting('muhtawaa_show_audio_button', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('muhtawaa_show_audio_button', array(
        'label'   => __('إظهار زر الاستماع للمقال', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));

    // إظهار مؤشر تقدم القراءة
    $wp_customize->add_setting('muhtawaa_show_reading_progress', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('muhtawaa_show_reading_progress', array(
        'label'   => __('إظهار مؤشر تقدم القراءة', 'muhtawaa'),
        'section' => 'muhtawaa_display',
        'type'    => 'checkbox',
    ));

    // قسم إعدادات مؤشر القراءة
    $wp_customize->add_section('muhtawaa_progress', array(
        'title'    => __('إعدادات مؤشر القراءة', 'muhtawaa'),
        'priority' => 46,
    ));

    // لون مؤشر التقدم
    $wp_customize->add_setting('muhtawaa_progress_color', array(
        'default'           => '#4A90E2',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_progress_color', array(
        'label'    => __('لون شريط التقدم', 'muhtawaa'),
        'section'  => 'muhtawaa_progress',
        'settings' => 'muhtawaa_progress_color',
    )));

    // ارتفاع شريط التقدم
    $wp_customize->add_setting('muhtawaa_progress_height', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('muhtawaa_progress_height', array(
        'label'       => __('ارتفاع شريط التقدم (px)', 'muhtawaa'),
        'section'     => 'muhtawaa_progress',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 2,
            'max'  => 10,
            'step' => 1,
        ),
    ));

    // قسم إعدادات الصوت
    $wp_customize->add_section('muhtawaa_audio', array(
        'title'    => __('إعدادات زر الاستماع', 'muhtawaa'),
        'priority' => 47,
    ));

    // نوع الصوت
    $wp_customize->add_setting('muhtawaa_audio_voice', array(
        'default'           => 'Arabic Female',
        'sanitize_callback' => 'muhtawaa_sanitize_voice',
    ));

    $wp_customize->add_control('muhtawaa_audio_voice', array(
        'label'   => __('نوع الصوت', 'muhtawaa'),
        'section' => 'muhtawaa_audio',
        'type'    => 'select',
        'choices' => array(
            'Arabic Female' => __('أنثى عربية', 'muhtawaa'),
            'Arabic Male'   => __('ذكر عربي', 'muhtawaa'),
        ),
    ));

    // سرعة الصوت
    $wp_customize->add_setting('muhtawaa_audio_speed', array(
        'default'           => 1,
        'sanitize_callback' => 'muhtawaa_sanitize_float',
    ));

    $wp_customize->add_control('muhtawaa_audio_speed', array(
        'label'       => __('سرعة القراءة', 'muhtawaa'),
        'section'     => 'muhtawaa_audio',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0.5,
            'max'  => 2,
            'step' => 0.1,
        ),
    ));
    // إضافة قسم الفوتر
    $wp_customize->add_section('muhtawaa_footer', array(
        'title'    => __('إعدادات الفوتر', 'muhtawaa'),
        'priority' => 50,
    ));
    
    // وصف الفوتر
    $wp_customize->add_setting('muhtawaa_footer_description', array(
        'default'           => get_bloginfo('name') . ' - ' . get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_footer_description', array(
        'label'   => __('وصف الفوتر', 'muhtawaa'),
        'section' => 'muhtawaa_footer',
        'type'    => 'text',
    ));
    
    // شعار الفوتر
    $wp_customize->add_setting('muhtawaa_footer_tagline', array(
        'default'           => __('نقدم لك المعرفة المفيدة في أقل وقت ممكن', 'muhtawaa'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_footer_tagline', array(
        'label'   => __('شعار الفوتر', 'muhtawaa'),
        'section' => 'muhtawaa_footer',
        'type'    => 'text',
    ));
    
    // نص حقوق النشر
    $wp_customize->add_setting('muhtawaa_copyright_text', array(
        'default'           => sprintf(__('© %s %s - جميع الحقوق محفوظة', 'muhtawaa'), date('Y'), get_bloginfo('name')),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_copyright_text', array(
        'label'   => __('نص حقوق النشر', 'muhtawaa'),
        'section' => 'muhtawaa_footer',
        'type'    => 'text',
    ));
    
    // إظهار رصيد القالب
    $wp_customize->add_setting('muhtawaa_show_theme_credit', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('muhtawaa_show_theme_credit', array(
        'label'   => __('إظهار رصيد القالب', 'muhtawaa'),
        'section' => 'muhtawaa_footer',
        'type'    => 'checkbox',
    ));
    
    // إضافة قسم الوضع الليلي
    $wp_customize->add_section('muhtawaa_dark_mode', array(
        'title'    => __('الوضع الليلي', 'muhtawaa'),
        'priority' => 55,
    ));
    
    // لون خلفية الوضع الليلي
    $wp_customize->add_setting('muhtawaa_dark_bg_color', array(
        'default'           => '#1a1a1a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_dark_bg_color', array(
        'label'    => __('لون خلفية الوضع الليلي', 'muhtawaa'),
        'section'  => 'muhtawaa_dark_mode',
        'settings' => 'muhtawaa_dark_bg_color',
    )));
    
    // لون البطاقات في الوضع الليلي
    $wp_customize->add_setting('muhtawaa_dark_card_bg_color', array(
        'default'           => '#2d2d2d',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_dark_card_bg_color', array(
        'label'    => __('لون البطاقات في الوضع الليلي', 'muhtawaa'),
        'section'  => 'muhtawaa_dark_mode',
        'settings' => 'muhtawaa_dark_card_bg_color',
    )));
    
    // لون النص في الوضع الليلي
    $wp_customize->add_setting('muhtawaa_dark_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_dark_text_color', array(
        'label'    => __('لون النص في الوضع الليلي', 'muhtawaa'),
        'section'  => 'muhtawaa_dark_mode',
        'settings' => 'muhtawaa_dark_text_color',
    )));

    // لون الروابط في الوضع الليلي
    $wp_customize->add_setting('muhtawaa_dark_link_color', array(
        'default'           => '#66b3ff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'muhtawaa_dark_link_color', array(
        'label'    => __('لون الروابط في الوضع الليلي', 'muhtawaa'),
        'section'  => 'muhtawaa_dark_mode',
        'settings' => 'muhtawaa_dark_link_color',
    )));
    
}
add_action('customize_register', 'muhtawaa_customize_register');

/**
 * وظائف التحقق من صحة البيانات
 */
function muhtawaa_sanitize_font_family($input) {
    $valid_fonts = array('Tajawal', 'Cairo', 'Almarai', 'Amiri', 'Noto Sans Arabic');
    return in_array($input, $valid_fonts) ? $input : 'Tajawal';
}

function muhtawaa_sanitize_grid_columns($input) {
    $valid_columns = array('2', '3', '4');
    return in_array($input, $valid_columns) ? $input : '3';
}

function muhtawaa_sanitize_voice($input) {
    $voices = array('Arabic Female', 'Arabic Male');
    return in_array($input, $voices) ? $input : 'Arabic Female';
}

function muhtawaa_sanitize_float($input) {
    return floatval($input);
}

/**
 * إضافة CSS مخصص للمعاينة المباشرة
 */
function muhtawaa_customize_preview_js() {
    wp_enqueue_script('muhtawaa-customizer', MUHTAWAA_THEME_URL . '/js/customizer.js', array('customize-preview'), MUHTAWAA_VERSION, true);
}
add_action('customize_preview_init', 'muhtawaa_customize_preview_js');

/**
 * إضافة CSS مخصص بناءً على إعدادات التخصيص
 */
function muhtawaa_customizer_css() {
    $primary_color = get_theme_mod('muhtawaa_primary_color', '#4A90E2');
    $text_color = get_theme_mod('muhtawaa_text_color', '#2C3E50');
    $text_secondary_color = get_theme_mod('muhtawaa_text_secondary_color', '#7F8C8D');
    $secondary_bg_color = get_theme_mod('muhtawaa_secondary_bg_color', '#F8F9FA');
    $font_family = get_theme_mod('muhtawaa_font_family', 'Tajawal');
    $font_size_base = get_theme_mod('muhtawaa_font_size_base', '16');
    $font_size_heading = get_theme_mod('muhtawaa_font_size_heading', '32');
    $mobile_font_size = get_theme_mod('muhtawaa_mobile_font_size', '17');
    $grid_columns = get_theme_mod('muhtawaa_grid_columns', '3');
    $dark_bg_color = get_theme_mod('muhtawaa_dark_bg_color', '#1a1a1a');
    $dark_card_bg_color = get_theme_mod('muhtawaa_dark_card_bg_color', '#2d2d2d');
    $dark_text_color = get_theme_mod('muhtawaa_dark_text_color', '#ffffff');
    $dark_link_color = get_theme_mod('muhtawaa_dark_link_color', '#66b3ff');
    $button_radius = get_theme_mod('muhtawaa_button_radius', '8');
    $progress_color = get_theme_mod('muhtawaa_progress_color', '#4A90E2');
    $progress_height = get_theme_mod('muhtawaa_progress_height', 4);
    
    // إضافة خط Google Fonts إذا لم يكن Tajawal
    if ($font_family !== 'Tajawal') {
        $font_url = '';
        switch ($font_family) {
            case 'Cairo':
                $font_url = 'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap';
                break;
            case 'Almarai':
                $font_url = 'https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap';
                break;
            case 'Amiri':
                $font_url = 'https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap';
                break;
            case 'Noto Sans Arabic':
                $font_url = 'https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap';
                break;
        }
        
        if ($font_url) {
            echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
            echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
            echo '<link href="' . esc_url($font_url) . '" rel="stylesheet">';
        }
    }
    
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --text-color: <?php echo esc_attr($text_color); ?>;
            --text-secondary: <?php echo esc_attr($text_secondary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_bg_color); ?>;
            --main-font: '<?php echo esc_attr($font_family); ?>', Arial, sans-serif;
            --font-size-base: <?php echo esc_attr($font_size_base); ?>px;
            --font-size-2xl: <?php echo esc_attr($font_size_heading); ?>px;
            --font-size-mobile: <?php echo esc_attr($mobile_font_size); ?>px;
            --dark-bg: <?php echo esc_attr($dark_bg_color); ?>;
            --dark-card-bg: <?php echo esc_attr($dark_card_bg_color); ?>;
            --dark-text: <?php echo esc_attr($dark_text_color); ?>;
            --dark-link-color: <?php echo esc_attr($dark_link_color); ?>;
            --border-radius: <?php echo esc_attr($button_radius); ?>px;
            --progress-color: <?php echo esc_attr($progress_color); ?>;
            --progress-height: <?php echo esc_attr($progress_height); ?>px;
        }
        
        .articles-grid {
            grid-template-columns: repeat(<?php echo esc_attr($grid_columns); ?>, 1fr);
        }
        
        @media (max-width: 768px) {
            .articles-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .articles-grid {
                grid-template-columns: 1fr;
            }
            html {
                font-size: <?php echo esc_attr($mobile_font_size); ?>px;
            }
        }
        
        <?php if (!get_theme_mod('muhtawaa_show_categories_bar', true)) : ?>
        .categories-bar {
            display: none !important;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('muhtawaa_show_dark_mode_toggle', true)) : ?>
        .dark-mode-toggle {
            display: none !important;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('muhtawaa_show_footer', true)) : ?>
        .site-footer {
            display: none !important;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('muhtawaa_show_reading_time', true)) : ?>
        .reading-time {
            display: none !important;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('muhtawaa_show_share_buttons', true)) : ?>
        .share-buttons {
            display: none !important;
        }
        <?php endif; ?>
        <?php if (!get_theme_mod('muhtawaa_show_back_to_top', true)) : ?>
        #back-to-top,
        .back-to-top {
            display: none !important;
        }
        <?php endif; ?>
        <?php if (!get_theme_mod('muhtawaa_show_audio_button', true)) : ?>
        .listen-to-article {
            display: none !important;
        }
        <?php endif; ?>

        <?php if (!get_theme_mod('muhtawaa_show_reading_progress', true)) : ?>
        .reading-progress {
            display: none !important;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'muhtawaa_customizer_css');
?>
