<!-- Секция подвала сайта и ссылок на разделы сайта -->
<div class="prefooter__top-line"></div>
<footer class="footer">
  <div class="footer__cont">
  <div class="footer__column">
    <span class="footer__logo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/header/logo.png" alt="Логотип"></span>
    <span class="footer__motto">Ваша улыбка - наша гордость!</span>
  </div>
  <div class="footer__column">
    <span class="footer__title">О нас</span>
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'footer-menu',
            'container' => false,
            'menu_class' => 'footer__column',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 1,
        )
    );
    ?>
  </div>
  <div class="footer__column">
    <span class="footer__title">Информация</span>
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'footer-menu-2',
            'container' => false,
            'menu_class' => 'footer__column',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 1,
        )
    );
    ?>
    </div>
  <div class="footer__column">
    <span class="footer__title">Связаться с нами</span>
    <a href="tel:+3752569043" class="footer__link"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sm-icons/phone.png" alt="phone" class="footer__link--phone">+375 (25) 690 43 43</a>
    <a href="mailto:nova_klinik.dental@gmail.com" class="footer__link"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sm-icons/letter.png" alt="mail" class="footer__link--mail">nova_klinik.dental@gmail.com</a>
    <span class="footer__title--contact-us">Присоединяйтесь к нам</span>
    <div class="footer__socials">
      <a href="https://vk.com/" class="footer__social-link icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sm-icons/vk.png" alt="vk"></a>
      <a href="https://www.facebook.com/?locale=ru_RU" class="footer__social-link icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sm-icons/fb.png" alt="fb"></a>
      <a href="https://www.instagram.com/" class="footer__social-link icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sm-icons/inst.png" alt="instagram"></a>
    </div>
    </div>
    <button id="backToTop" class="back-to-top" onclick="window.scrollTo(0,0);"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/sm-icons/ArrowUp.png" alt="Up"></button>
    <div class="footer__bottom-line">
        <p><?php echo date('Y '); echo get_bloginfo('name'); ?>. Все права защищены</p>
    </div>
    </div>
  </footer>  
<?php wp_footer(); ?>
<script>
  window.addEventListener('scroll', function() {
    var footer = document.querySelector('.footer');
    var backToTop = document.getElementById('backToTop');
    
    var footerTop = footer.offsetTop;
    var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollPosition + window.innerHeight > footerTop) {
        backToTop.style.display = 'block';
    } else {
        backToTop.style.display = 'none';
    }
});

</script>
  </body>
</html>