<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <?php if ( has_site_icon() ) : ?>
        <link rel="icon" href="<?php echo esc_url( get_site_icon_url() ); ?>" sizes="32x32" />
        <link rel="icon" href="<?php echo esc_url( get_site_icon_url() ); ?>" sizes="192x192" />
        <link rel="apple-touch-icon" href="<?php echo esc_url( get_site_icon_url() ); ?>" />
        <meta name="msapplication-TileImage" content="<?php echo esc_url( get_site_icon_url() ); ?>" />
    <?php else : ?>
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/header/favicon.ico" type="image/x-icon" />
    <?php endif; ?>

    <?php wp_head(); ?>
   
  </head>
  <body>
    <!-- Блок всплывающего окна при нажатии по кнопке -->
    <div id="myModal" class="modal">
      <div class="modal-content">
        <p>Для получения дополнительной информации позвоните по номеру +375(25) 690 43 43 в рабочее время.</p>
        <button class="modal-ok-button">OK, Все понятно! 👍</button>
      </div>
    </div>

    <!-- Шапка сайта -->
    <header class="header">
      <section class="header__top">
        <div class="header__brand">
<a href="<?php echo home_url(); ?>" class="custom-logo-link header__logo">
        <?php
        if ( has_custom_logo() ) {
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

            if ( has_custom_logo() ) {
                echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="custom-logo header__logo">';
            }
        }
        ?>
    </a>
        </div>
        <div class="header__contact">
          <div class="header__contact-item">
            <img
              src="<?php echo get_template_directory_uri(); ?>/assets/img/header/dental_icon.png"
              alt=""
              class="header__contact-icon"
            />
            Стоматологическая </br> клиника в Гомеле
          </div>
          <div class="header__contact-item">
            <img
              src="<?php echo get_template_directory_uri(); ?>/assets/img/header/place_icon.png"
              alt=""
              class="header__contact-icon"
            />
            Лепешинского ул., 3 Гомель </br> С 10.00 до 20.00
          </div>
          <div class="header__contact-item">
            <img
              src="<?php echo get_template_directory_uri(); ?>/assets/img/header/mobile_icon.png"
              alt=""
              class="header__contact-icon"
            />
            +375(29) 690 43 43<br />
            Звоните по любым вопросам
          </div>
        </div>
      </section>
      <section class="header__menu">
        <nav class="header__nav">
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'header-menu',
            'container' => false,
            'menu_class' => 'header__nav',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 1,
        )
    );
    ?>
</nav>
        <button class="header__appointment-button "><a href="#specialists" style="text-decoration: none; color:white;">Запись онлайн</a></button>
      </section>
      <section class="header__main">
          <?php
    $main_query = new WP_Query(array(
        'post_type' => 'main',
        'posts_per_page' => 1,
    ));

    if($main_query->have_posts()) {
        while($main_query->have_posts()) {
            $main_query->the_post();
            ?>
            <div class="header__title-container">
                <h1 class="header__title"><?php the_title(); ?></h1>
                <div class="header__description"><?php the_content(); ?></div>
                <a href="#" class="header__learn-more open-modal-button">Узнать больше</a>
            </div>
            <div class="header__image-container">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="tooth_photo" class="header__scene-image"/>
            </div>
            <?php
        }
        wp_reset_postdata();
    }
    ?>
      </section>
    </header>

