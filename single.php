<?php get_header('post'); ?>
<style>
.single-post {
    padding: 20px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    margin: 20px auto;
    max-width: 800px;
}

.single-post .entry-header,
.single-post .entry-content,
.single-post .entry-footer {
    margin-bottom: 20px;
}

.single-post .entry-title {
    font-size: 2em;
    margin-bottom: 10px;
}

.single-post .entry-meta {
    font-size: 0.9em;
    color: #777;
}

.single-post .entry-content {
    line-height: 1.6;
}

.single-post .entry-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

</style>

<main class="single-post">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                    </div>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                <footer class="entry-footer">
                    <span class="cat-links"><?php echo get_the_category_list(', '); ?></span>
                    <span class="tags-links"><?php echo get_the_tag_list('', ', '); ?></span>
                </footer>
            </article>
    <?php
        endwhile;
    else :
        echo '<p>Записей не найдено.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>
