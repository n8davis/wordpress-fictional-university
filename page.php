<?php
    // handles single page --- index.php is a fall back page
    get_header();
    while(have_posts()) {
        the_post();
        pageBanner();
?>
        <div class="container container--narrow page-section">


            <?php if ($parentId = wp_get_post_parent_id(get_the_ID())) : // has a parent .... ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?= get_the_permalink($parentId); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Back to <?= get_the_title($parentId); ?>
                    </a>
                    <span class="metabox__main">
                        <?php the_title();?>
                    </span>
                </p>
            </div>
            <?php endif; ?>


            <?php
                $hasChildren = get_pages([
                    'child_of' => get_the_ID()
                ]);
                if ($parentId || $hasChildren) {?>
                <div class="page-links">
                <h2 class="page-links__title">
                    <a href="<?= get_the_permalink($parentId); ?>">
                        <?= get_the_title($parentId); ?>
                    </a>
                </h2>
                <ul class="min-list">

                    <?php
                        if ($parentId) {
                            $id = $parentId;
                        } else {
                            $id = get_the_ID();
                        }
                        // list the child pages
                        wp_list_pages([
                            'title_li' => null,
                            'child_of' => $id,
                            'sort_column' => 'menu_order'
                        ])
                    ?>

                </ul>
            </div>
            <?php }?>

            <div class="generic-content">
                <?php the_content(); ?>
            </div>

        </div>

<?php
    }
    get_footer();
?>