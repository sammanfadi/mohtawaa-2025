<?php
/**
 * Header template for Muhtawaa Theme – v1.0.0 (custom)
 * Includes:
 * - Search bar inside navigation
 * - Dark‑mode toggle
 * - Auto‑hide header on scroll down, show on scroll up / at top
 * - Removed “About” page from fallback menu
 * - Contact page link only if exists
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">

                <!-- Site branding -->
                <div class="site-branding">
                    <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                    <?php endif; ?>

                    <?php
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <p class="site-description"><?php echo $description; ?></p>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <!-- Main navigation -->
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => 'muhtawaa_fallback_menu',
                    ) );
                    ?>

                    <!-- Search form -->
                    <div class="header-search">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <label>
                                <span class="screen-reader-text"><?php _e( 'ابحث عن:', 'muhtawaa' ); ?></span>
                                <input type="search" class="search-field"
                                    placeholder="<?php echo esc_attr__( 'ابحث في الموقع...', 'muhtawaa' ); ?>"
                                    value="<?php echo get_search_query(); ?>" name="s" />
                            </label>
                            <button type="submit" class="search-submit" aria-label="<?php _e( 'بحث', 'muhtawaa' ); ?>">&#128269;</button>
                        </form>
                    </div>

                    <!-- Dark‑mode toggle -->
                    <?php if ( get_theme_mod( 'muhtawaa_show_dark_mode_toggle', true ) ) : ?>
                        <button class="dark-mode-toggle" aria-label="<?php _e( 'تبديل الوضع الليلي', 'muhtawaa' ); ?>">
                            <span class="screen-reader-text"><?php _e( 'تبديل الوضع الليلي', 'muhtawaa' ); ?></span>
                        </button>
                    <?php endif; ?>
                </nav><!-- #site-navigation -->

            </div><!-- .header-content -->
        </div><!-- .container -->
    </header><!-- #masthead -->

    <!-- Categories bar -->
    <?php if ( get_theme_mod( 'muhtawaa_show_categories_bar', true ) && ( is_home() || is_front_page() ) ) : ?>
        <div class="categories-bar">
            <div class="container">
                <ul class="categories-list">
                    <li>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="category-tag <?php echo ( is_home() || is_front_page() ) ? 'active' : ''; ?>">
                            <?php _e( 'جميع المقالات', 'muhtawaa' ); ?>
                        </a>
                    </li>
                    <?php
                    $categories = get_categories( array(
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'number'     => 5,
                        'hide_empty' => true,
                    ) );

                    foreach ( $categories as $category ) :
                        $is_current = is_category( $category->term_id );
                        ?>
                        <li>
                            <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
                               class="category-tag <?php echo $is_current ? 'active' : ''; ?>">
                                #<?php echo esc_html( $category->name ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

<?php
/**
 * Fallback menu (if no WordPress menu is defined)
 */
function muhtawaa_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'الرئيسية', 'muhtawaa' ) . '</a></li>';

    // Only “Contact” page (no About)
    $contact_page = get_page_by_path( 'contact' );
    if ( $contact_page ) {
        echo '<li><a href="' . esc_url( get_permalink( $contact_page->ID ) ) . '">' . __( 'تواصل معنا', 'muhtawaa' ) . '</a></li>';
    }

    echo '</ul>';
}
?>
<!-- Styles moved to css/header.css and script to js/header.js -->

