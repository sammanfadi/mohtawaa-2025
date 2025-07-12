<?php
/**
 * دعم Elementor لقالب muhtawaa
 * يحتوي على التحسينات والإعدادات الخاصة بـ Elementor
 */

// منع الوصول المباشر للملف
if (!defined('ABSPATH')) {
    exit;
}

/**
 * إعداد دعم Elementor
 */
function muhtawaa_elementor_init() {
    // التحقق من وجود Elementor
    if (!did_action('elementor/loaded')) {
        return;
    }
    
    // إضافة دعم للعرض الكامل
    add_theme_support('elementor-full-width');
    
    // إضافة دعم للهيدر والفوتر
    add_theme_support('elementor-header-footer');
    
    // تسجيل مواقع القالب
    muhtawaa_register_elementor_locations();
    
    // إضافة أنماط مخصصة لـ Elementor
    add_action('elementor/frontend/after_enqueue_styles', 'muhtawaa_elementor_styles');
    
    // إضافة ودجات مخصصة
    add_action('elementor/widgets/widgets_registered', 'muhtawaa_register_elementor_widgets');
}
add_action('init', 'muhtawaa_elementor_init');

/**
 * تسجيل مواقع القالب في Elementor
 */
function muhtawaa_register_elementor_locations() {
    if (function_exists('elementor_theme_do_location')) {
        // تسجيل موقع الهيدر
        add_action('muhtawaa_header', function() {
            if (!elementor_theme_do_location('header')) {
                get_template_part('template-parts/header');
            }
        });
        
        // تسجيل موقع الفوتر
        add_action('muhtawaa_footer', function() {
            if (!elementor_theme_do_location('footer')) {
                get_template_part('template-parts/footer');
            }
        });
        
        // تسجيل موقع المحتوى الرئيسي
        add_action('muhtawaa_content', function() {
            if (!elementor_theme_do_location('single')) {
                while (have_posts()) {
                    the_post();
                    the_content();
                }
            }
        });
    }
}

/**
 * إضافة أنماط مخصصة لـ Elementor
 */
function muhtawaa_elementor_styles() {
    wp_enqueue_style(
        'muhtawaa-elementor',
        MUHTAWAA_THEME_URL . '/css/elementor.css',
        array(),
        MUHTAWAA_VERSION
    );
}

/**
 * تسجيل ودجات مخصصة لـ Elementor
 */
function muhtawaa_register_elementor_widgets() {
    // تسجيل ودجة المقالات المميزة
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Muhtawaa_Featured_Posts_Widget());
    
    // تسجيل ودجة المقالات الحديثة
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Muhtawaa_Recent_Posts_Widget());
    
    // تسجيل ودجة التصنيفات
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Muhtawaa_Categories_Widget());
}

/**
 * ودجة المقالات المميزة
 */
class Muhtawaa_Featured_Posts_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'muhtawaa-featured-posts';
    }
    
    public function get_title() {
        return __('المقالات المميزة', 'muhtawaa');
    }
    
    public function get_icon() {
        return 'eicon-posts-grid';
    }
    
    public function get_categories() {
        return ['muhtawaa'];
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('المحتوى', 'muhtawaa'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'posts_count',
            [
                'label' => __('عدد المقالات', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 12,
            ]
        );
        
        $this->add_control(
            'columns',
            [
                'label' => __('عدد الأعمدة', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '2' => __('عمودين', 'muhtawaa'),
                    '3' => __('ثلاثة أعمدة', 'muhtawaa'),
                    '4' => __('أربعة أعمدة', 'muhtawaa'),
                ],
            ]
        );
        
        $this->add_control(
            'show_excerpt',
            [
                'label' => __('إظهار المقتطف', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'show_reading_time',
            [
                'label' => __('إظهار وقت القراءة', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_count'],
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_featured_post',
                    'value' => '1',
                    'compare' => '='
                )
            )
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            echo '<div class="muhtawaa-featured-posts columns-' . esc_attr($settings['columns']) . '">';
            
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <article class="featured-post-item">
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('muhtawaa-featured'); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <?php if ($settings['show_reading_time'] === 'yes') : ?>
                        <div class="post-meta">
                            <?php muhtawaa_display_reading_time(); ?>
                        </div>
                        <?php endif; ?>
                        
                        <h3 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <?php if ($settings['show_excerpt'] === 'yes') : ?>
                        <div class="post-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                        </div>
                        <?php endif; ?>
                        
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php _e('اقرأ المزيد', 'muhtawaa'); ?>
                        </a>
                    </div>
                </article>
                <?php
            }
            
            echo '</div>';
            wp_reset_postdata();
        }
    }
}

/**
 * ودجة المقالات الحديثة
 */
class Muhtawaa_Recent_Posts_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'muhtawaa-recent-posts';
    }
    
    public function get_title() {
        return __('المقالات الحديثة', 'muhtawaa');
    }
    
    public function get_icon() {
        return 'eicon-posts-ticker';
    }
    
    public function get_categories() {
        return ['muhtawaa'];
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('المحتوى', 'muhtawaa'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'posts_count',
            [
                'label' => __('عدد المقالات', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 10,
            ]
        );
        
        $this->add_control(
            'show_date',
            [
                'label' => __('إظهار التاريخ', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'show_thumbnail',
            [
                'label' => __('إظهار الصورة المصغرة', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_count'],
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            echo '<div class="muhtawaa-recent-posts">';
            
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <article class="recent-post-item">
                    <?php if ($settings['show_thumbnail'] === 'yes' && has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('muhtawaa-thumbnail'); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <h4 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        
                        <?php if ($settings['show_date'] === 'yes') : ?>
                        <div class="post-date">
                            <?php echo get_the_date(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </article>
                <?php
            }
            
            echo '</div>';
            wp_reset_postdata();
        }
    }
}

/**
 * ودجة التصنيفات
 */
class Muhtawaa_Categories_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'muhtawaa-categories';
    }
    
    public function get_title() {
        return __('تصنيفات المقالات', 'muhtawaa');
    }
    
    public function get_icon() {
        return 'eicon-archive-title';
    }
    
    public function get_categories() {
        return ['muhtawaa'];
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('المحتوى', 'muhtawaa'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'categories_count',
            [
                'label' => __('عدد التصنيفات', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 12,
            ]
        );
        
        $this->add_control(
            'show_count',
            [
                'label' => __('إظهار عدد المقالات', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'layout',
            [
                'label' => __('التخطيط', 'muhtawaa'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => __('شبكة', 'muhtawaa'),
                    'list' => __('قائمة', 'muhtawaa'),
                    'tags' => __('وسوم', 'muhtawaa'),
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $categories = get_categories(array(
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => $settings['categories_count'],
            'hide_empty' => true
        ));
        
        if (!empty($categories)) {
            echo '<div class="muhtawaa-categories layout-' . esc_attr($settings['layout']) . '">';
            
            foreach ($categories as $category) {
                ?>
                <div class="category-item">
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-link">
                        <span class="category-name"><?php echo esc_html($category->name); ?></span>
                        <?php if ($settings['show_count'] === 'yes') : ?>
                        <span class="category-count">(<?php echo $category->count; ?>)</span>
                        <?php endif; ?>
                    </a>
                </div>
                <?php
            }
            
            echo '</div>';
        }
    }
}

/**
 * إضافة فئة ودجات مخصصة
 */
function muhtawaa_add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'muhtawaa',
        [
            'title' => __('قالب Muhtawaa', 'muhtawaa'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'muhtawaa_add_elementor_widget_categories');

/**
 * إنشاء ملف CSS خاص بـ Elementor
 */
function muhtawaa_create_elementor_css() {
    $css_content = '
/* أنماط Elementor المخصصة لقالب muhtawaa */

.muhtawaa-featured-posts {
    display: grid;
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-xl);
}

.muhtawaa-featured-posts.columns-2 {
    grid-template-columns: repeat(2, 1fr);
}

.muhtawaa-featured-posts.columns-3 {
    grid-template-columns: repeat(3, 1fr);
}

.muhtawaa-featured-posts.columns-4 {
    grid-template-columns: repeat(4, 1fr);
}

.featured-post-item {
    background-color: var(--background-color);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    transition: var(--transition);
}

.featured-post-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--box-shadow-hover);
}

.featured-post-item .post-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.featured-post-item .post-content {
    padding: var(--spacing-lg);
}

.featured-post-item .post-title {
    font-size: var(--font-size-lg);
    margin-bottom: var(--spacing-sm);
}

.featured-post-item .post-title a {
    color: var(--text-color);
    text-decoration: none;
}

.featured-post-item .post-title a:hover {
    color: var(--primary-color);
}

.muhtawaa-recent-posts {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.recent-post-item {
    display: flex;
    gap: var(--spacing-md);
    padding: var(--spacing-md);
    background-color: var(--secondary-color);
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.recent-post-item:hover {
    background-color: var(--primary-color);
    color: white;
}

.recent-post-item .post-thumbnail {
    flex-shrink: 0;
}

.recent-post-item .post-thumbnail img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: var(--border-radius);
}

.recent-post-item .post-title {
    font-size: var(--font-size-base);
    margin-bottom: var(--spacing-xs);
}

.recent-post-item .post-title a {
    color: inherit;
    text-decoration: none;
}

.muhtawaa-categories.layout-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: var(--spacing-md);
}

.muhtawaa-categories.layout-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-sm);
}

.muhtawaa-categories.layout-tags {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
}

.category-item .category-link {
    display: block;
    padding: var(--spacing-sm) var(--spacing-md);
    background-color: var(--secondary-color);
    color: var(--text-color);
    text-decoration: none;
    border-radius: var(--border-radius);
    transition: var(--transition);
    text-align: center;
}

.muhtawaa-categories.layout-tags .category-link {
    display: inline-block;
    padding: var(--spacing-xs) var(--spacing-md);
    border-radius: 25px;
    font-size: 14px;
}

.category-item .category-link:hover {
    background-color: var(--primary-color);
    color: white;
}

.category-count {
    opacity: 0.7;
    font-size: 0.9em;
}

/* تحسينات للأجهزة المحمولة */
@media (max-width: 768px) {
    .muhtawaa-featured-posts.columns-3,
    .muhtawaa-featured-posts.columns-4 {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .muhtawaa-categories.layout-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .muhtawaa-featured-posts {
        grid-template-columns: 1fr;
    }
    
    .muhtawaa-categories.layout-grid {
        grid-template-columns: 1fr;
    }
    
    .recent-post-item {
        flex-direction: column;
        text-align: center;
    }
}
';
    
    $css_file = MUHTAWAA_THEME_DIR . '/css/elementor.css';
    file_put_contents($css_file, $css_content);
}

// إنشاء ملف CSS عند تفعيل القالب
add_action('after_switch_theme', 'muhtawaa_create_elementor_css');

?>
