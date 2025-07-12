<?php
if ( post_password_required() ) {
    return;
}
?>
<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            printf(
                _nx('تعليق واحد على "%2$s"', '%1$s تعليق على "%2$s"', get_comments_number(), 'التعليقات', 'muhtawaa'),
                number_format_i18n( get_comments_number() ),
                get_the_title()
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 48,
            ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>
    <?php endif; ?>

    <?php if ( comments_open() ) : ?>
        <div class="comment-form-wrapper">
            <?php
            comment_form(array(
                'title_reply'        => __('اترك تعليق', 'muhtawaa'),
                'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
                'title_reply_after'  => '</h2>',
                'comment_notes_after' => '',
            ));
            ?>
        </div>
    <?php endif; ?>
</div>
