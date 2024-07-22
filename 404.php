<?php get_header('post'); ?>
<style>
    .error-404 {
    text-align: center;
    padding: 50px;
}

.error-404 .page-header {
    margin-bottom: 30px;
}

.error-404 .page-title {
    font-size: 36px;
    color: #333;
}

.error-404 .page-content {
    font-size: 18px;
    color: #666;
}

.error-404 .page-content a {
    color: #0073aa;
    text-decoration: none;
}

.error-404 .page-content a:hover {
    color: #005177;
    text-decoration: underline;
}

</style>
<main class="site-main" role="main">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php _e('404 - Страница не найдена', 'novaclinik_theme'); ?></h1>
        </header>

        <div class="page-content">
            <p><?php _e('К сожалению, страница, которую вы ищете, не существует. Возможно, она была удалена или перенесена на другой адрес.', 'novaclinik_theme'); ?></p>
            <p><a href="<?php echo home_url(); ?>"><?php _e('Вернуться на главную', 'novaclinik_theme'); ?></a></p>
        </div>
    </section>
</main>

<?php get_footer(); ?>
