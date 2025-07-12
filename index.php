<?php
/**
 * الصفحة الرئيسية لقالب muhtawaa
 * تعرض المقالات في شكل بطاقات مع نظام الفلترة
 */

get_header(); ?>

<main class="main-content">
    <div class="container">
        
        <?php
        // عرض نظام الفلترة إذا كان هناك أكثر من 6 مقالات
        $post_count = wp_count_posts()->publish;
        if ($post_count >= 6) :
        ?>
        <div class="filter-section">
            <h2 class="filter-title"><?php _e('فرز حسب:', 'muhtawaa'); ?></h2>
            <div class="filter-buttons">
                <button class="filter-btn active" data-category="all">
                    <?php _e('جميع المقالات', 'muhtawaa'); ?>
                </button>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order'   => 'DESC',
                    'number'  => 5
                ));
                
                foreach ($categories as $category) :
                ?>
                <button class="filter-btn" data-category="<?php echo esc_attr($category->slug); ?>">
                    <?php echo esc_html($category->name); ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
        
        <div class="articles-grid" id="articles-grid">
            <?php
            while (have_posts()) :
                the_post();
                
                // الحصول على تصنيفات المقال
                $categories = get_the_category();
                $category_slugs = array();
                foreach ($categories as $category) {
                    $category_slugs[] = $category->slug;
                }
                $data_categories = implode(' ', $category_slugs);
            ?>
            
            <article class="article-card" data-categories="<?php echo esc_attr($data_categories); ?>">
                
                <?php if (has_post_thumbnail()) : ?>
                <div class="article-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('muhtawaa-featured', array('alt' => get_the_title())); ?>
                    </a>
                </div>
                <?php endif; ?>
                
                <div class="article-meta">
                    <?php muhtawaa_display_reading_time(); ?>
                    <span class="article-date">
                        📅 <?php echo get_the_date('j F Y'); ?>
                    </span>
                </div>
                
                <h2 class="article-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                
                <?php if (!empty($categories)) : ?>
                <div class="article-tags">
                    <?php foreach ($categories as $category) : ?>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="article-tag">
                        #<?php echo esc_html($category->name); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <div class="article-excerpt">
                    <?php
                    $excerpt = get_the_excerpt();
                    if (empty($excerpt)) {
                        $excerpt = wp_trim_words(get_the_content(), 25, '...');
                    }
                    echo esc_html($excerpt);
                    ?>
                </div>
                
                <a href="<?php the_permalink(); ?>" class="read-more-btn">
                    <?php _e('اقرأ الآن', 'muhtawaa'); ?>
                </a>
                
            </article>
            
            <?php endwhile; ?>
        </div>
        
        <?php
        // عرض التنقل بين الصفحات
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('السابق', 'muhtawaa'),
            'next_text' => __('التالي', 'muhtawaa'),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('صفحة', 'muhtawaa') . ' </span>',
        ));
        ?>
        
        <?php else : ?>
        
        <div class="no-posts">
            <h2><?php _e('لا توجد مقالات', 'muhtawaa'); ?></h2>
            <p><?php _e('عذراً، لا توجد مقالات متاحة حالياً.', 'muhtawaa'); ?></p>
            
            <?php if (current_user_can('publish_posts')) : ?>
            <p>
                <a href="<?php echo esc_url(admin_url('post-new.php')); ?>" class="read-more-btn">
                    <?php _e('إضافة مقال جديد', 'muhtawaa'); ?>
                </a>
            </p>
            <?php endif; ?>
        </div>
        
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
<!-- Script moved to main.js -->
