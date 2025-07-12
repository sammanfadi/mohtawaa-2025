<?php
/**
 * قسم المقالات المميزة
 */

$featured_posts = get_posts(array(
    'meta_key' => '_featured_post',
    'meta_value' => '1',
    'posts_per_page' => 3,
    'post_status' => 'publish'
));

if (empty($featured_posts)) {
    // إذا لم توجد مقالات مميزة، نأخذ آخر 3 مقالات
    $featured_posts = get_posts(array(
        'posts_per_page' => 3,
        'post_status' => 'publish'
    ));
}

if (empty($featured_posts)) return;
?>

<section class="featured-posts-section" id="featured">
    <div class="container">
        <div class="section-header text-center animate-fade-in-up">
            <h2 class="section-title">المقالات المميزة</h2>
            <p class="section-subtitle">اكتشف أهم وأحدث المحتوى المميز</p>
        </div>
        
        <div class="featured-posts-grid">
            <?php foreach ($featured_posts as $index => $post) : 
                setup_postdata($post);
                $delay = $index * 0.2;
            ?>
                <article class="featured-post-card hover-lift animate-fade-in-up" style="animation-delay: <?php echo $delay; ?>s;">
                    <div class="card">
                        <?php if (has_post_thumbnail($post->ID)) : ?>
                            <div class="card-image">
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <?php echo get_the_post_thumbnail($post->ID, 'medium_large', array('alt' => get_the_title($post->ID))); ?>
                                </a>
                                <div class="featured-badge">
                                    <span class="badge badge-warning">مميز</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <div class="post-meta">
                                <?php 
                                $categories = get_the_category($post->ID);
                                if (!empty($categories)) :
                                    $category = $categories[0];
                                ?>
                                    <a href="<?php echo get_category_link($category->term_id); ?>" class="category-link">
                                        #<?php echo $category->name; ?>
                                    </a>
                                <?php endif; ?>
                                
                                <span class="post-date">
                                    <?php echo get_the_date('j F Y', $post->ID); ?>
                                </span>
                            </div>
                            
                            <h3 class="post-title">
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <?php echo get_the_title($post->ID); ?>
                                </a>
                            </h3>
                            
                            <p class="post-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt($post->ID);
                                if (empty($excerpt)) {
                                    $excerpt = wp_trim_words(get_the_content('', false, $post->ID), 20, '...');
                                }
                                echo wp_strip_all_tags($excerpt);
                                ?>
                            </p>
                            
                            <div class="post-footer">
                                <div class="reading-time">
                                    <span class="time-icon">⏱️</span>
                                    <?php echo muhtawaa_reading_time(get_the_content('', false, $post->ID)); ?> دقيقة
                                </div>
                                
                                <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-outline btn-sm">
                                    اقرأ المزيد
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        
        <div class="section-footer text-center animate-fade-in-up" style="animation-delay: 0.8s;">
            <a href="<?php echo home_url('/#articles'); ?>" class="btn btn-primary btn-lg">
                عرض جميع المقالات
            </a>
        </div>
    </div>
</section>

<style>
.featured-posts-section {
    padding: var(--spacing-2xl) 0;
    background: var(--background-secondary);
}

.section-header {
    margin-bottom: var(--spacing-2xl);
}

.section-title {
    font-size: var(--font-size-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--text-color);
    margin-bottom: var(--spacing-md);
    font-family: var(--heading-font);
}

.section-subtitle {
    font-size: var(--font-size-lg);
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}

.featured-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: var(--spacing-xl);
    margin-bottom: var(--spacing-2xl);
}

.featured-post-card {
    position: relative;
}

.featured-badge {
    position: absolute;
    top: var(--spacing-md);
    right: var(--spacing-md);
    z-index: 2;
}

.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--spacing-md);
    font-size: var(--font-size-sm);
}

.category-link {
    background: var(--primary-color);
    color: white;
    padding: var(--spacing-xs) var(--spacing-sm);
    border-radius: var(--border-radius-full);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
    transition: var(--transition);
}

.category-link:hover {
    background: var(--primary-dark);
    transform: scale(1.05);
}

.post-date {
    color: var(--text-secondary);
}

.post-title {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--spacing-md);
    line-height: 1.4;
}

.post-title a {
    color: var(--text-color);
    text-decoration: none;
    transition: var(--transition);
}

.post-title a:hover {
    color: var(--primary-color);
}

.post-excerpt {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: var(--spacing-lg);
}

.post-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.reading-time {
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
    color: var(--text-secondary);
    font-size: var(--font-size-sm);
}

.time-icon {
    font-size: var(--font-size-base);
}

.section-footer {
    margin-top: var(--spacing-xl);
}

@media (max-width: 768px) {
    .featured-posts-grid {
        grid-template-columns: 1fr;
        gap: var(--spacing-lg);
    }
    
    .post-footer {
        flex-direction: column;
        gap: var(--spacing-md);
        align-items: flex-start;
    }
}
</style>