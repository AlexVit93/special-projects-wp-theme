<?php get_header('post'); ?>
<style>
.archive-post {
    padding: 20px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    margin: 20px auto;
    max-width: 800px;
}

.archive-posts .entry-header,
.archive-posts .entry-content,
.archive-posts .entry-footer {
    margin-bottom: 20px;
}

.archive-posts .entry-title {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.archive-posts .entry-meta {
    font-size: 0.9em;
    color: #777;
}

.archive-posts .entry-content {
    line-height: 1.6;
}

.archive-posts .entry-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}
</style>
<main class="archive-post">
    <header class="archive-header">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <div class="archive-description"><?php the_archive_description(); ?></div>
    </header>
    <?php if (have_posts()) : ?>
        <div class="archive-posts">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="entry-meta">
                            <span class="posted-on"><?php echo get_the_date(); ?></span>
                        </div>
                    </header>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">Читать далее</a>
                    </footer>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>Записей не найдено.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
