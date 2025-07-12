<?php
/**
 * صفحة المقال الفردي لقالب muhtawaa
 * تعرض المقال مع مؤشر التقدم وزر العودة والمقالات المشابهة
 */

get_header();

while ( have_posts() ) :
    the_post();
?>

<main class="main-content">
    <div class="container-narrow">

        <article class="single-article">

            <header class="article-header">

                <!-- زر العودة للرئيسية -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="back-to-home">
                    ⬅️ <?php _e('العودة للرئيسية', 'muhtawaa'); ?>
                </a>

                <!-- تصنيفات المقال -->
                <?php
                $categories = get_the_category();
                if (!empty($categories)) :
                ?>
                <div class="article-categories">
                    <?php foreach ($categories as $category) : ?>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="article-tag">
                        #<?php echo esc_html($category->name); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- عنوان المقال -->
                <h1 class="article-main-title"><?php the_title(); ?></h1>

                <!-- معلومات المقال -->
                <div class="article-info">
                    <span class="reading-time">
                        ⏱️ <?php _e('وقت القراءة:', 'muhtawaa'); ?> <?php echo muhtawaa_reading_time(); ?> <?php _e('دقيقة', 'muhtawaa'); ?>
                    </span>
                    <span class="article-date">
                        📅 <?php echo get_the_date('j F Y'); ?>
                    </span>
                    <?php if (get_the_author()) : ?>
                    <span class="article-author">
                        ✍️ <?php the_author(); ?>
                    </span>
                    <?php endif; ?>
                </div>

            </header>

            <!-- الصورة المميزة -->
            <?php if (has_post_thumbnail()) : ?>
            <div class="article-featured-image">
                <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
            </div>
            <?php endif; ?>

            <!-- محتوى المقال -->
            <div class="article-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('الصفحات:', 'muhtawaa'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

            <!-- زر استمع للمقال -->
<?php if (get_theme_mod('muhtawaa_show_audio_button', true)) : ?>
            <div class="listen-to-article">
                <button id="play-pause-btn" class="listen-btn" data-content="<?php echo esc_attr( wp_strip_all_tags( get_the_content() ) ); ?>">
                    استمع للمقال
                </button>
            </div>
<?php endif; ?>
<!-- الوسوم -->
            <?php
            $tags = get_the_tags();
            if (!empty($tags)) :
            ?>
            <div class="article-tags-section">
                <h3><?php _e('الوسوم:', 'muhtawaa'); ?></h3>
                <div class="article-tags">
                    <?php foreach ($tags as $tag) : ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="article-tag">
                        #<?php echo esc_html($tag->name); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- أزرار المشاركة -->
            <div class="share-buttons">
                <a href="#" class="share-btn" data-action="share">
                    📤 <?php _e('مشاركة', 'muhtawaa'); ?>
                </a>
                <a href="#" class="share-btn" data-action="copy-link">
                    🔗 <?php _e('نسخ الرابط', 'muhtawaa'); ?>
                </a>
                <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="share-btn">
                    📱 <?php _e('واتساب', 'muhtawaa'); ?>
                </a>
                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn">
                    🐦 <?php _e('تويتر', 'muhtawaa'); ?>
                </a>
            </div>

        </article>

        <!-- المقالات المشابهة -->
        <?php muhtawaa_display_related_posts(); ?>

        <!-- التنقل بين المقالات تم تعطيله لإزالة التشوه البصري -->

        <!-- التعليقات -->
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
<!-- Styles moved to css/single.css; reading progress handled in main.js -->

