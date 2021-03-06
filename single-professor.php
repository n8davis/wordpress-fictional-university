<?php
/**
 * Special file for custom post types
 * single.php will handle post types
 * however single-{custom_post_type}.php will
 * handle my custom posts
 */
get_header();
while(have_posts()) {
    the_post();
    pageBanner();
    ?>

    <div class="container container--narrow page-section">

        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('professor');?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Professors Home
                </a>
                <span class="metabox__main">
                        <?php the_title() ?>
                    </span>
            </p>
        </div>

        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail('professorPortrait');?></div>
                <div class="two-thirds"><?php the_content();?></div>
            </div>
        </div>

        <!-- Related Programs -->
        <?php $relatedPrograms = get_field('related_programs');?>
        <?php if (! empty($relatedPrograms)) : ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">
                Subject(s) Taught
            </h2>
            <ul class="link-list min-list">
                <?php foreach ($relatedPrograms as $relatedProgram): ?>
                    <li>
                        <a href="<?= get_the_permalink($relatedProgram)?>" >
                            <?= get_the_title($relatedProgram);?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php endif; ?>
    </div>
    <?php
}
get_footer();
?>