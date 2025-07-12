<?php
/**
 * قسم البطل (Hero Section) للصفحة الرئيسية
 */

$hero_title = get_theme_mod('muhtawaa_hero_title', 'مرحباً بك في عالم المحتوى المعرفي');
$hero_subtitle = get_theme_mod('muhtawaa_hero_subtitle', 'اكتشف المعرفة في 90 ثانية - محتوى مفيد وسريع');
$hero_cta_text = get_theme_mod('muhtawaa_hero_cta_text', 'استكشف المقالات');
$hero_cta_link = get_theme_mod('muhtawaa_hero_cta_link', '#articles');
$show_hero = get_theme_mod('muhtawaa_show_hero', true);

if (!$show_hero) return;
?>

<section class="hero-section animate-fade-in-up">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <?php if (get_theme_mod('muhtawaa_hero_background_image')) : ?>
            <img src="<?php echo esc_url(get_theme_mod('muhtawaa_hero_background_image')); ?>" alt="خلفية البطل" class="hero-bg-image">
        <?php endif; ?>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title typewriter"><?php echo esc_html($hero_title); ?></h1>
            <p class="hero-subtitle animate-fade-in-up" style="animation-delay: 0.3s;"><?php echo esc_html($hero_subtitle); ?></p>
            
            <?php if ($hero_cta_text && $hero_cta_link) : ?>
                <div class="hero-actions animate-fade-in-up" style="animation-delay: 0.6s;">
                    <a href="<?php echo esc_url($hero_cta_link); ?>" class="btn btn-primary btn-lg btn-ripple hover-lift">
                        <?php echo esc_html($hero_cta_text); ?>
                        <span class="btn-icon">→</span>
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- إحصائيات سريعة -->
            <div class="hero-stats animate-fade-in-up" style="animation-delay: 0.9s;">
                <div class="stat-item">
                    <span class="stat-number" data-count="<?php echo wp_count_posts()->publish; ?>">0</span>
                    <span class="stat-label">مقال</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="<?php echo count(get_categories()); ?>">0</span>
                    <span class="stat-label">تصنيف</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="<?php echo get_comments(array('count' => true, 'status' => 'approve')); ?>">0</span>
                    <span class="stat-label">تعليق</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- مؤشر التمرير لأسفل -->
    <div class="scroll-indicator animate-bounce">
        <a href="#articles" class="scroll-link">
            <span class="scroll-text">تصفح المقالات</span>
            <span class="scroll-arrow">↓</span>
        </a>
    </div>
</section>

<style>
.hero-section {
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(44, 90, 160, 0.8);
    z-index: 2;
}

.hero-bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 3;
    color: white;
    max-width: 800px;
    margin: 0 auto;
    padding: var(--spacing-xl) 0;
}

.hero-title {
    font-size: clamp(2rem, 5vw, 4rem);
    font-weight: var(--font-weight-bold);
    margin-bottom: var(--spacing-lg);
    font-family: var(--heading-font);
    line-height: 1.2;
}

.hero-subtitle {
    font-size: clamp(1.1rem, 2.5vw, 1.5rem);
    font-weight: var(--font-weight-normal);
    margin-bottom: var(--spacing-2xl);
    opacity: 0.9;
    line-height: 1.6;
}

.hero-actions {
    margin-bottom: var(--spacing-2xl);
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: var(--spacing-xl);
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-xs);
}

.stat-number {
    font-size: var(--font-size-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--accent-color);
}

.stat-label {
    font-size: var(--font-size-sm);
    opacity: 0.8;
    font-weight: var(--font-weight-medium);
}

.scroll-indicator {
    position: absolute;
    bottom: var(--spacing-lg);
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
}

.scroll-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-xs);
    color: white;
    text-decoration: none;
    transition: var(--transition);
}

.scroll-link:hover {
    transform: translateY(-5px);
    color: var(--accent-color);
}

.scroll-text {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
}

.scroll-arrow {
    font-size: var(--font-size-xl);
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 70vh;
    }
    
    .hero-stats {
        gap: var(--spacing-lg);
    }
    
    .stat-number {
        font-size: var(--font-size-2xl);
    }
}
</style>