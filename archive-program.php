<?php
// handles blog --- index.php is a fall back page
get_header();
pageBanner([
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone. Have a look around!'
])
?>
<div class="container container--narrow page-section">
    <ul class="min-list link-list">
    <?php

    while(have_posts()){
        the_post();
        ?>
        <li>
            <a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
            </a>
        </li>
        <?php
    }
    echo paginate_links();
    ?>
    </ul>
</div>

<?php
get_footer();
?>
