<?php if ( get_theme_mod( 'muhtawaa_show_footer', true ) ) : ?>
<footer id="colophon" class="site-footer">
    <div class="container">

        <!-- شعار الموقع -->
        <div class="footer-branding">
            <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
                <h2 class="footer-site-title"><?php bloginfo( 'name' ); ?></h2>
            <?php endif; ?>
        </div>

        <!-- وصف الموقع -->
        <div class="footer-description">
            <?php 
            $footer_description = get_theme_mod('muhtawaa_footer_description', get_bloginfo('name') . ' - ' . get_bloginfo('description'));
            echo esc_html($footer_description);
            ?>
        </div>

        <!-- جملة تعريفية -->
        <div class="footer-tagline">
            <?php 
            $footer_tagline = get_theme_mod('muhtawaa_footer_tagline', __('نقدم لك المعرفة المفيدة في أقل وقت ممكن', 'muhtawaa'));
            echo esc_html($footer_tagline);
            ?>
        </div>

        <!-- قائمة روابط الفوتر -->
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer',
            'menu_id'        => 'footer-menu',
            'menu_class'     => 'footer-menu',
            'container'      => 'nav',
        ));
        ?>

        <!-- روابط تواصل سريعة -->
        <ul class="footer-links">
            <li><a href="https://wa.me/966532821336" class="footer-contact whatsapp" target="_blank" rel="noopener">واتساب</a></li>
            <li><a href="mailto:fadi.takkem@gmail.com" class="footer-contact email">البريد الإلكتروني</a></li>
            <li><a href="https://www.facebook.com/FADI.TAKEM" class="footer-social facebook" target="_blank" rel="noopener">فيسبوك</a></li>
        </ul>

        <p class="footer-copy">© <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?> — جميع الحقوق محفوظة.</p>

        <!-- زر العودة للأعلى -->
        <?php if ( get_theme_mod( 'muhtawaa_show_back_to_top', true ) ) : ?>
        <button id="back-to-top" title="العودة للأعلى">↑</button>
        <?php endif; ?>

    </div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
<!-- Styles moved to css/footer.css and script to js/footer.js -->

