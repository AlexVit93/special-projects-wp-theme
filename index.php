<?php get_header(); ?>

    <!-- Секция о наших преимуществах -->
    <section class="features">
      <h2 class="features__title">Почему стоит обратиться именно к нам?</h2>
      <div class="features__list">
        <?php
        $features_query = new WP_Query(array(
            'post_type' => 'features',
            'posts_per_page' => -1,
        ));

        if($features_query->have_posts()) {
            while($features_query->have_posts()) {
                $features_query->the_post();
                ?>
                <article class="feature">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="feature__icon"/>
                    <h3 class="feature__title"><?php the_title(); ?></h3>
                    <div class="feature__description"><?php the_content(); ?></div>
                </article>
                <?php
            }
            wp_reset_postdata();
        }
        ?>
      </div>
    </section>
    <!-- Секция врачей -->
<section class="doctors">
  <h2 class="doctors__title" id="specialists">Квалифицированные стоматологи</h2>
  <p class="doctors__subtitle">Помогут сохранить и вернуть здоровье вашим зубам</p>
  <div class="doctors__slider swiper">
    <div class="swiper-wrapper">
      <?php
      $args = array(
          'post_type' => 'doctors',
          'posts_per_page' => -1
      );
      $query = new WP_Query($args);
      if ($query->have_posts()) :
          while ($query->have_posts()) : $query->the_post();
              $specialty = get_post_meta(get_the_ID(), 'meta-specialty', true);
              $experience = get_post_meta(get_the_ID(), 'meta-experience', true);
              $description = get_post_meta(get_the_ID(), 'meta-description', true);
              $education = get_post_meta(get_the_ID(), 'meta-education', true);
              $photo = get_the_post_thumbnail_url(get_the_ID(), 'full');
      ?>
      <div class="swiper-slide doctors__thumb" 
           data-name="<?php the_title(); ?>" 
           data-specialty="<?php echo esc_attr($specialty); ?>" 
           data-experience="<?php echo esc_attr($experience); ?>" 
           data-description="<?php echo esc_attr($description); ?>" 
           data-education="<?php echo esc_attr($education); ?>" 
           data-photo="<?php echo esc_url($photo); ?>">
        <img class="doctors__photo" src="<?php echo esc_url($photo); ?>" alt="Фото врача">
        <h3 class="doctors__surname"><?php the_title(); ?></h3>
      </div>
      <?php
          endwhile;
      endif;
      wp_reset_postdata();
      ?>
    </div>
    <div class="swiper-button-next doctors__next"></div>
    <div class="swiper-button-prev doctors__prev"></div>
  </div>

  <div class="doctors__info">
    <div class="doctors__info-photo-container"></div>
    <div class="doctors__info-text-container"></div>
  </div>
</section>

<!-- Секция сервисов клиники -->
<section class="clinic-services">
  <div class="clinic-services__main">
  <?php
    $services_query = new WP_Query(array(
        'post_type' => 'services-main',
        'posts_per_page' => 1,
    ));

    if($services_query->have_posts()) {
        while($services_query->have_posts()) {
            $services_query->the_post();
            ?>
            <div class="clinic-services__text">
                <h2 class="clinic-services__title" id="services"><?php the_title(); ?></h2>
                <div class="clinic-services__description"><?php the_content(); ?></div>
            </div>
            <div class="clinic-services__images">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="Изображение клиники" class="clinic-services__image">
            </div>
            <?php
        }
        wp_reset_postdata();
    }
    ?>
  </div>
    <div class="clinic-services__grid">
    <?php
    $args = array(
        'post_type' => 'clinic_services',
        'posts_per_page' => -1  
    );
    $query = new WP_Query($args);
    if($query->have_posts()) :
        while($query->have_posts()) : $query->the_post();
    ?>
    <details class="clinic-service clinic-service--<?php echo sanitize_title(get_the_title()); ?>">
      <summary class="clinic-service__summary">
        <h3 class="clinic-service__title"><?php the_title(); ?></h3>
        <button class="clinic-service__toggle">+</button>
      </summary>
      <div class="clinic-service__content">
        <div class="clinic-service__info"><?php the_content(); ?></div>
      </div>
    </details>
    <?php
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
  </div>
      <details class="clinic-service clinic-service--dental-treatment" open>
        <summary class="clinic-service__summary">
          <h3 class="clinic-service__title">Лечение зубов и десен</h3>
          <button class="clinic-service__toggle">+</button>
        </summary>
        <div class="clinic-service__content">
          <div class="clinic-service__description">
            <p>Бережное лечение заболеваний пародонта с помощью инновационных методик - терапия, плазмолифтинг. Локальное стимулирование регенарации тканей.</p>
          </div>
          <button class="clinic-service__button"><a href="#specialists" style="text-decoration: none; color:white;">Запись онлайн</a></button>
        </div>
          <div class="clinic-service__images">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/clinic-services/dental-pain.png" alt="Лечение зубов" class="clinic-service__image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/clinic-services/dental-treatment.png" alt="Лечение десен" class="clinic-service__image">
          
        </div>
      </details>
    </section>

<!-- Секция акций и новостей клиники -->
<section class="promotions">
    <h2 class="promotions__title" id="actions">Акции и новости клиники</h2>
    <div class="promotions__items">
        <?php
       $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1, 
            'category_name' => 'news' 
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
            <article class="promotion">
                <h3 class="promotion__title"><?php the_title(); ?></h3>
                <p class="promotion__date"><?php echo get_the_date(); ?></p>
                <p class="promotion__info"><?php the_excerpt(); ?></p>
                <button class="promotion__more__link" data-id="<?php the_ID(); ?>">Узнать больше</button>
            </article>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>Пока нет новостей.</p>';
        endif;
        ?>
    </div>
    <div id="news-modal" class="nsmodal">
    <div class="modal-content-ns">
        <span class="nsclose">&times;</span>
        <div id="modal-body"></div>
    </div>
</div>
</section>

<!-- Секция полезной информации о клинике -->
<section class="articles">
    <h2 class="articles__title" id="blogs">Статьи</h2>
    <div class="articles__items">
        <?php
        $args = array(
            'post_type' => 'page',
            'posts_per_page' => -1,
            'post_status' => 'publish'

        );
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
            <div class="articles__main">
                <div class="article__photo">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('alt' => get_the_title()));
                    } ?>
                </div>
                <article class="article">
                    <h3 class="article__title"><?php the_title(); ?></h3>
                    <p class="article__summary"><?php echo wp_trim_words(get_the_content(), 20, '...'); ?></p>
                    <a href="<?php the_permalink(); ?>" class="article__link" data-id="<?php the_ID(); ?>">Читать</a>
                </article>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>Пока нет статей.</p>';
        endif;
        ?>
    </div>
<div id="page-modal" class="pgmodal">
    <div class="modal-content-page">
        <span class="page-close">&times;</span>
        <div id="page-modal-body"></div>
    </div>
</div>
</section>

<!-- Секция отзывов наших клиентов -->
<section class="testimonials">
  <h2 class="testimonials__title" id="reviews">Отзывы наших клиентов</h2>
  <div class="testimonials__slider slick-slider">
    <?php
    $args = array(
        'post_type' => 'reviews',
        'posts_per_page' => -1  
    );
    $query = new WP_Query($args);
    if($query->have_posts()) :
        while($query->have_posts()) : $query->the_post();
            $avatar_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    ?>
    <div class="slick-slide">
      <div class="testimonial">
        <div class="testimonial__rating">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </div>
        <div class="testimonial__content">
          <img src="<?= $avatar_url ?>" alt="Аватар клиента" class="testimonial__avatar">
          <p class="testimonial__name"><?php the_title(); ?></p>
          <div class="testimonial__text"><?php the_content(); ?></div>
        </div>
      </div>
    </div>
    <?php
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
  </div>
  <div class="testimonials__controls">
    <button class="testimonials__arrow testimonials__arrow--prev" aria-label="Previous testimonial">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/review/arrow_left.png" alt="Предыдущий">
    </button>
    <button class="testimonials__arrow testimonials__arrow--next" aria-label="Next testimonial">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/review/arrow_right.png" alt="Следующий">
    </button>
  </div>
</section>
<!-- Секция блока контактной информации с формой обратной связи и анимацией -->
<section class="contact">
  <h2 class="contact__title" id="contacts">Остались вопросы? Или хотите оставить отзыв?
  Заполните форму обратной связи и мы обязательно ответим!</h2>
  <div class="contact__prompt">
    <div class="contact_anim">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/contacts/anim.gif" alt="Animation" class="contact_anim__image">
    </div>
<form class="contact__form" id="contactForm" method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
    <input type="hidden" name="action" value="submit_feedback">
    <input type="text" id="name" name="name" placeholder="Ваше имя" required>
    <input type="email" id="email" name="email" placeholder="Ваш e-mail" required>
    <textarea id="message" name="message" placeholder="Ваш вопрос или отзыв" required></textarea>
    <div class="contact__form-group">
         <label for="consent_contact" class="contact__consent">
            <input type="checkbox" id="consent_contact" name="consent_contact" required>
            Соглас(ен/на) на обработку персональных данных
        </label>
        <?php echo do_shortcode('[bws_google_captcha]'); ?>
        <button type="submit" class="contact__submit">Задать вопрос</button>
    </div>
</form>

<div id="mathCaptchaModal" class="modal-rec">
    <div class="modal-content-rec">
        <span class="rec-close">&times;</span>
        <p>Решите задачу: <span id="mathQuestion"></span></p>
        <input type="text" id="mathAnswer" placeholder="Ваш ответ">
        <button id="submitMathAnswer">Подтвердить</button>
    </div>
</div>
</div>
  <div class="contact__info">
    <div class="contact__main">
      <h3 class="contact__info-title" id="address">Адрес и контакты</h3>
      <?php
    $contacts_data_query = new WP_Query(array(
        'category_name' => 'contacts-data',
        'posts_per_page' => -1,
    ));

    if($contacts_data_query->have_posts()) {
        while($contacts_data_query->have_posts()) {
            $contacts_data_query->the_post();
            ?>
            <div class="contact__item">
                <?php if (has_post_thumbnail()) { ?>
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <?php } ?>
                <div class="contact__text">
                    <p class="contact__address"><?php the_title(); ?></p>
                    <p class="contact__descr"><?php the_content(); ?></p>
                </div>
            </div>
        <?php
    }
    wp_reset_postdata();
}
?>
</div>
<?php
$map_query = new WP_Query(array(
    'post_type' => 'map',
    'posts_per_page' => 1,
));

if($map_query->have_posts()) {
    while($map_query->have_posts()) {
        $map_query->the_post();
        $map_constructor_code = get_field('map_constructor_code');
        $zoom_level = get_field('zoom_level');
        $map_width = get_field('map_width');
        $map_height = get_field('map_height');
        ?>
        <div class="contact__map">
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A<?php echo $map_constructor_code; ?>&amp;z=<?php echo $zoom_level; ?>&amp;source=constructor" width="<?php echo $map_width; ?>" height="<?php echo $map_height; ?>" frameborder="0" class="contact__map_image" title="Мы на карте"></iframe>
        </div>
        <?php
    }
    wp_reset_postdata();
}
?>


  </div>
</section>


<?php get_footer(); ?>