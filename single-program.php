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
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('program');?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Programs Home
                </a>
                <span class="metabox__main">
                        <?php the_title() ?>
                    </span>
            </p>
        </div>

        <div class="generic-content">
            <?php the_content();?>
        </div>
        <?php

        // custom query
        $relatedProfessors = new WP_Query([
            'posts_per_page' => -1, // get all
            'post_type'      => 'professor',
            'orderby' => 'title',// meta_value
            'order' => 'asc',
            'meta_query' => [
                // events containing this programs' id
                [
                    'key'     => 'related_programs',
                    'compare' => 'LIKE',
                    'value'   => '"' . get_the_ID() . '"'
                ]
            ]
        ]);
        if ($relatedProfessors->have_posts()):
            ?>

            <hr class="section-break">
            <h2 class="headline headline--medium">
                Professors
            </h2>
            <ul class="professor-cards">
            <?php
            while ($relatedProfessors->have_posts()) :
                $relatedProfessors->the_post();
                ?>
                <li class="professor-card__list-item">
                    <a href="<?php the_permalink()?>" class="professor-card">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape')?>" alt="">
                        <span class="professor-card__name">
                            <?php the_title();?>
                        </span>
                    </a>
                </li>
            <?php
            endwhile;
            wp_reset_postdata(); // clean up after yourself...
            ?>
            </ul>
        <?php
        endif;

        $today = date('Ymd');
        // custom query
        $homePageEvents = new WP_Query([
            'posts_per_page' => 2,
            'post_type'      => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',// meta_value
            'order' => 'asc',
            'meta_query' => [
                // hide past events
                [
                    'key'     => 'event_date',
                    'compare' => '>=',
                    'value'   => $today,
                    'type'    => 'numeric'
                ],
                // events containing this programs' id
                [
                    'key'     => 'related_programs',
                    'compare' => 'LIKE',
                    'value'   => '"' . get_the_ID() . '"'
                ]
            ]
        ]);
        if ($homePageEvents->have_posts()):
        ?>

            <hr class="section-break">
            <h2 class="headline headline--medium">
                Upcoming <?php the_title() ?> Events
            </h2>

        <?php
            while ($homePageEvents->have_posts()) :
                $homePageEvents->the_post();
        ?>
                <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink() ?>">
                        <span class="event-summary__month"><?php
                            $eventDate = new DateTime(get_field('event_date'));
                            echo $eventDate->format('M');
                            ?></span>
                    <span class="event-summary__day"><?= $eventDate->format('d');?></span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny">
                        <a href="<?php the_permalink() ?>">
                            <?php the_title(); ?>
                        </a>
                    </h5>
                    <p>
                        <?= wp_trim_words(has_excerpt() ? get_the_excerpt() : get_the_content(),
                            EXCERPT_LENGTH );?>
                        <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a>
                    </p>
                </div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata(); // clean up after yourself...
        endif;
        ?>

    </div>
    <?php
}
get_footer();
?>