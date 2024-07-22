<?php
function novaclinic_enqueue_scripts() {
    // Подключение стилей
    wp_enqueue_style('main', get_stylesheet_uri() );
    wp_enqueue_style('novaclinic-style', get_template_directory_uri() . '/assets/css/style.css', array('main'));
    wp_enqueue_style('responsive-style', get_template_directory_uri() . '/assets/css/responsive.css', array('novaclinic-style'));
    wp_enqueue_style('slicklib-style', get_template_directory_uri() . '/assets/libs/slick.css');
    wp_enqueue_style('slicktheme-style', get_template_directory_uri() . '/assets/libs/slick-theme.css');
    wp_enqueue_style('swiperbundle-style', get_template_directory_uri() . '/assets/libs/swiper-bundle.min.css');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');


    // Подключение скриптов
    wp_deregister_script('jquery'); 
    wp_register_script('jquery', get_template_directory_uri() . '/assets/libs/jquery.min.js', array(), null, true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('docslide', get_template_directory_uri() . '/assets/js/docslide.js', array('jquery'), null, true);
    wp_enqueue_script('modal', get_template_directory_uri() . '/assets/js/modal.js', array('jquery'), null, true);
     wp_enqueue_script('slick-js', get_template_directory_uri() . '/assets/libs/slick.min.js', array('jquery'), null, true);
    wp_enqueue_script('testimonial', get_template_directory_uri() . '/assets/js/testimonial.js', array('jquery', 'slick-js'), null, true);
     wp_enqueue_script('docs-valid', get_template_directory_uri() . '/assets/js/docs-valid.js', array('jquery'), null, true);
    wp_enqueue_script('validate', get_template_directory_uri() . '/assets/js/validate.js', array('jquery'), null, true);
    wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/libs/swiper-bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('ajax-modal', get_template_directory_uri() . '/assets/js/ajax-modal.js', array('jquery'), null, true);
    wp_enqueue_script('page-modal', get_template_directory_uri() . '/assets/js/page-modal.js', array('jquery'), null, true);
    wp_enqueue_script('modal-doc', get_template_directory_uri() . '/assets/js/modal-doc.js', array('jquery'), null, true);
    wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/enterprise.js?render=6LetyAgqAAAAAKao1wU10I_yrjfbscVTMqw8tHkN', array(), null, true);
    wp_localize_script('ajax-modal', 'ajaxurl', admin_url('admin-ajax.php'));
    wp_localize_script('page-modal', 'ajaxurl', admin_url('admin-ajax.php'));
    wp_localize_script('modal-doc', 'ajaxurl', admin_url('admin-ajax.php'));
    
    wp_localize_script('docs-valid', 'ajax_appointment', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('submit_appointment_nonce')
    ));
    
    wp_localize_script('validate', 'ajax_feedback', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('submit_feedback_nonce')
    ));
    
}
add_action('wp_enqueue_scripts', 'novaclinic_enqueue_scripts');

if (!function_exists('novaclinic_enqueue_setup')) {
    function novaclinic_enqueue_setup() {
        add_theme_support('custom-logo', [
            'height'      => 50,
            'width'       => 223,
            'flex-width'  => false,
            'flex-height' => false,
            'header-text' => '',
            'unlink-homepage-logo' => false
        ]);
    }
    add_action('after_setup_theme', 'novaclinic_enqueue_setup');
}

add_filter('get_custom_logo', 'add_custom_logo_class');
function add_custom_logo_class($html) {
    $html = str_replace('custom-logo-link', 'custom-logo-link header__logo', $html);
    return $html;
}

function create_custom_post_types() {
    register_post_type('main', array(
        'labels' => array(
            'name' => __('Главный блок'),
            'singular_name' => __('Главный блок'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'main'),
    ));

    register_post_type('features', array(
        'labels' => array(
            'name' => __('Преимущества'),
            'singular_name' => __('Преимущество'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'features'),
    ));
}
add_action('init', 'create_custom_post_types');



function register_my_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
            'footer-menu' => __( 'Footer Menu' ),
            'footer-menu-2' => __( 'Footer Menu 2' )
        )
    );
}
add_action( 'init', 'register_my_menus' );

add_filter('nav_menu_css_class', 'custom_nav_menu_css_class', 10, 2);
function custom_nav_menu_css_class($classes, $item) {
    if ($item->menu_item_parent == 'header-menu') {
        $classes[] = 'header__nav-item';
    }
    return $classes;
}

add_filter('nav_menu_css_class', 'custom_footer_menu_css_class', 10, 2);
function custom_footer_menu_css_class($classes, $item) {
    if ($item->menu_item_parent == 'footer-menu' || $item->menu_item_parent == 'footer-menu-2') {
        $classes[] = 'footer__link';
    }
    return $classes;
}

function include_modal_form() {
    include get_template_directory() . '/modal-form.php';
}
add_action('wp_footer', 'include_modal_form');


function get_news_content_callback() {
    $post_id = $_POST['post_id'];
    $post = get_post($post_id);
    if ($post) {
        echo '<h1>' . get_the_title($post_id) . '</h1>';
        echo '<p>' . get_the_date('', $post_id) . '</p>';
        echo '<div>' . apply_filters('the_content', $post->post_content) . '</div>';
    }
    wp_die();
}
add_action('wp_ajax_get_news_content', 'get_news_content_callback');
add_action('wp_ajax_nopriv_get_news_content', 'get_news_content_callback');


function get_page_content_callback() {
    $post_id = $_POST['post_id'];
    $post = get_post($post_id);
    if ($post) {
        echo '<h1>' . get_the_title($post_id) . '</h1>';
        echo '<p>' . get_the_date('', $post_id) . '</p>';
        echo '<div>' . apply_filters('the_content', $post->post_content) . '</div>';
    }
    wp_die();
}
add_action('wp_ajax_get_page_content', 'get_page_content_callback');
add_action('wp_ajax_nopriv_get_page_content', 'get_page_content_callback');

add_theme_support( 'post-thumbnails' );

function register_post_types() {
    register_post_type('reviews', [
        'label' => null,
        'labels' => [
            'name' => 'Отзывы',
            'singular_name' => 'Отзыв',
            'add_new' => 'Добавить отзыв',
            'add_new_item' => 'Добавление отзыва',
            'edit_item' => 'Редактирование отзыва',
            'new_item' => 'Новый отзыв',
            'view_item' => 'Ознакомиться с отзывом',
            'search_items' => 'Поиск отзыва',
            'not_found' => 'Не найдено',
            'not_found_in_trash' => 'Не найдено в корзине',
            'parent_item_colon' => '',
            'menu_name' => 'Отзывы',
        ],
        'description' => '',
        'public' => true,
        'show_in_menu' => null,
        'show_in_rest' => null,
        'rest_base' => null,
        'menu_position' => null,
        'menu_icon' => 'dashicons-format-status',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'thumbnail'],
        'taxonomies' => [],
        'has_archive' => false,
        'rewrite' => true,
        'query_var' => true,
    ]);
}
add_action('init', 'register_post_types');

function create_clinic_services_cpt() {
    $labels = array(
        'name' => 'Услуги клиники',
        'singular_name' => 'Услуга клиники',
        'menu_name' => 'Услуги клиники',
        'name_admin_bar' => 'Услуга клиники',
        'add_new' => 'Добавить новую',
        'add_new_item' => 'Добавить новую услугу',
        'new_item' => 'Новая услуга',
        'edit_item' => 'Редактировать услугу',
        'view_item' => 'Просмотр услуги',
        'all_items' => 'Все услуги',
        'search_items' => 'Искать услуги',
        'not_found' => 'Услуги не найдены',
        'not_found_in_trash' => 'Услуги не найдены в корзине'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'clinic-services'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-portfolio',
    );

    register_post_type('clinic_services', $args);
}

add_action('init', 'create_clinic_services_cpt');

function create_doctors_cpt() {
    $labels = array(
        'name' => 'Врачи',
        'singular_name' => 'Врач',
        'menu_name' => 'Врачи',
        'name_admin_bar' => 'Врач',
        'add_new' => 'Добавить нового',
        'add_new_item' => 'Добавить нового врача',
        'new_item' => 'Новый врач',
        'edit_item' => 'Редактировать врача',
        'view_item' => 'Просмотр врача',
        'all_items' => 'Все врачи',
        'search_items' => 'Искать врачей',
        'not_found' => 'Врачи не найдены',
        'not_found_in_trash' => 'Врачи не найдены в корзине'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'doctors'),
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-users',
    );

    register_post_type('doctors', $args);
}

add_action('init', 'create_doctors_cpt');

function add_doctors_metaboxes() {
    add_meta_box(
        'doctors_info',
        'Информация о враче',
        'doctors_metaboxes_callback',
        'doctors',
        'normal',
        'default'
    );
}

add_action('add_meta_boxes', 'add_doctors_metaboxes');

function doctors_metaboxes_callback($post) {
    wp_nonce_field(basename(__FILE__), 'doctors_nonce');
    $doctors_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="meta-specialty" class="doctors-row-title"><?php _e('Специальность', 'doctors-textdomain') ?></label>
        <input type="text" name="meta-specialty" id="meta-specialty" value="<?php if (!empty($doctors_stored_meta['meta-specialty'])) echo esc_attr($doctors_stored_meta['meta-specialty'][0]); ?>" />
    </p>
    <p>
        <label for="meta-experience" class="doctors-row-title"><?php _e('Опыт', 'doctors-textdomain') ?></label>
        <input type="text" name="meta-experience" id="meta-experience" value="<?php if (!empty($doctors_stored_meta['meta-experience'])) echo esc_attr($doctors_stored_meta['meta-experience'][0]); ?>" />
    </p>
    <p>
        <label for="meta-description" class="doctors-row-title"><?php _e('Описание', 'doctors-textdomain') ?></label>
        <textarea name="meta-description" id="meta-description"><?php if (!empty($doctors_stored_meta['meta-description'])) echo esc_textarea($doctors_stored_meta['meta-description'][0]); ?></textarea>
    </p>
    <p>
        <label for="meta-education" class="doctors-row-title"><?php _e('Образование', 'doctors-textdomain') ?></label>
        <input type="text" name="meta-education" id="meta-education" value="<?php if (!empty($doctors_stored_meta['meta-education'])) echo esc_attr($doctors_stored_meta['meta-education'][0]); ?>" />
    </p>
    <?php
}

function save_doctors_meta($post_id) {
    if (!isset($_POST['doctors_nonce']) || !wp_verify_nonce($_POST['doctors_nonce'], basename(__FILE__))) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ('doctors' === $_POST['post_type'] && current_user_can('edit_post', $post_id)) {
        if (isset($_POST['meta-specialty'])) {
            update_post_meta($post_id, 'meta-specialty', sanitize_text_field($_POST['meta-specialty']));
        }
        if (isset($_POST['meta-experience'])) {
            update_post_meta($post_id, 'meta-experience', sanitize_text_field($_POST['meta-experience']));
        }
        if (isset($_POST['meta-description'])) {
            update_post_meta($post_id, 'meta-description', sanitize_textarea_field($_POST['meta-description']));
        }
        if (isset($_POST['meta-education'])) {
            update_post_meta($post_id, 'meta-education', sanitize_text_field($_POST['meta-education']));
        }

        error_log('Meta Specialty: ' . $_POST['meta-specialty']);
        error_log('Meta Experience: ' . $_POST['meta-experience']);
        error_log('Meta Description: ' . $_POST['meta-description']);
        error_log('Meta Education: ' . $_POST['meta-education']);
    }
}



add_action('save_post', 'save_doctors_meta');
function create_appointment_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doc_appointment';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        first_name varchar(50) NOT NULL,
        middle_name varchar(50) DEFAULT '',
        last_name varchar(50) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20) NOT NULL,
        doctor_name varchar(100) NOT NULL,
        appointment_date date NOT NULL,
        appointment_time time NOT NULL,
        message text NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY unique_appointment (first_name, last_name, email, phone, doctor_name, appointment_date, appointment_time),
        INDEX idx_first_name (first_name),
        INDEX idx_last_name (last_name),
        INDEX idx_email (email),
        INDEX idx_phone (phone),
        INDEX idx_doctor_name (doctor_name),
        INDEX idx_appointment_date (appointment_date),
        INDEX idx_appointment_time (appointment_time)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('after_switch_theme', 'create_appointment_table');

function submit_appointment_form() {
    check_ajax_referer('submit_appointment_nonce', 'nonce');

    global $wpdb;
    parse_str($_POST['form_data'], $form_data);

    $table_name = $wpdb->prefix . 'doc_appointment';

    $existing_appointment = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE 
        first_name = %s AND
        last_name = %s AND
        email = %s AND
        phone = %s AND
        doctor_name = %s AND
        appointment_date = %s AND
        appointment_time = %s",
        sanitize_text_field($form_data['first_name']),
        sanitize_text_field($form_data['last_name']),
        sanitize_email($form_data['email']),
        sanitize_text_field($form_data['phone']),
        sanitize_text_field($form_data['doctor_name']),
        sanitize_text_field($form_data['appointment_date']),
        sanitize_text_field($form_data['appointment_time'])
    ));

    if ($existing_appointment > 0) {
        echo 'error: duplicate entry';
    } else {
        $data = array(
            'first_name' => sanitize_text_field($form_data['first_name']),
            'middle_name' => sanitize_text_field($form_data['middle_name']),
            'last_name' => sanitize_text_field($form_data['last_name']),
            'email' => sanitize_email($form_data['email']),
            'phone' => sanitize_text_field($form_data['phone']),
            'doctor_name' => sanitize_text_field($form_data['doctor_name']),
            'appointment_date' => sanitize_text_field($form_data['appointment_date']),
            'appointment_time' => sanitize_text_field($form_data['appointment_time']),
            'message' => sanitize_textarea_field($form_data['message']),
        );

        $format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
        $success = $wpdb->insert($table_name, $data, $format);

        if ($success) {
            $email = $form_data['email'];
            $subject = 'Подтверждение записи к врачу';
            $message = 'Ваша запись была создана. Ожидайте, с вами свяжется менеджер по номеру телефона или электронной почте на тот адрес, который вы указали при отправке сообщения.';
            wp_mail($email, $subject, $message);

            echo 'success';
        } else {
            echo 'error';
        }
    }

    wp_die();
}
add_action('wp_ajax_submit_appointment_form', 'submit_appointment_form');
add_action('wp_ajax_nopriv_submit_appointment_form', 'submit_appointment_form');

function register_appointment_menu_page() {
    add_menu_page(
        __('Doctor Appointments', 'textdomain'),
        __('График приема', 'textdomain'),
        'manage_options',
        'doctor-appointments',
        'doctor_appointments_page',
        'dashicons-calendar-alt',
        6
    );
}
add_action('admin_menu', 'register_appointment_menu_page');

function doctor_appointments_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'doc_appointment';

    $results = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<div class="wrap">';
    echo '<h1>' . __('График приема', 'textdomain') . '</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Имя</th><th>Фамилия</th><th>Email</th><th>Телефон</th><th>Врач</th><th>Дата</th><th>Время</th><th>Сообщение</th></tr></thead>';
    echo '<tbody>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . esc_html($row->id) . '</td>';
        echo '<td>' . esc_html($row->first_name) . '</td>';
        echo '<td>' . esc_html($row->last_name) . '</td>';
        echo '<td>' . esc_html($row->email) . '</td>';
        echo '<td>' . esc_html($row->phone) . '</td>';
        echo '<td>' . esc_html($row->doctor_name) . '</td>';
        echo '<td>' . esc_html($row->appointment_date) . '</td>';
        echo '<td>' . esc_html($row->appointment_time) . '</td>';
        echo '<td>' . esc_html($row->message) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function handle_appointment_form_submission() {
    if (isset($_POST['form_data'])) {
        parse_str($_POST['form_data'], $form_data);

        global $wpdb;
        $table_name = $wpdb->prefix . 'doc_appointment';

        $result = $wpdb->insert(
            $table_name,
            array(
                'first_name' => sanitize_text_field($form_data['first_name']),
                'middle_name' => sanitize_text_field($form_data['middle_name']),
                'last_name' => sanitize_text_field($form_data['last_name']),
                'email' => sanitize_email($form_data['email']),
                'phone' => sanitize_text_field($form_data['phone']),
                'doctor_name' => sanitize_text_field($form_data['doctor_name']),
                'appointment_date' => sanitize_text_field($form_data['appointment_date']),
                'appointment_time' => sanitize_text_field($form_data['appointment_time']),
                'message' => sanitize_textarea_field($form_data['message'])
            )
        );

        if ($result) {
            echo 'success';
        } else {
            if ($wpdb->last_error) {
                echo 'error: ' . $wpdb->last_error;
            } else {
                echo 'error: duplicate entry';
            }
        }
    } else {
        echo 'no data';
    }
    wp_die();
}
add_action('wp_ajax_submit_appointment_form', 'handle_appointment_form_submission');
add_action('wp_ajax_nopriv_submit_appointment_form', 'handle_appointment_form_submission');


function services_custom_post_types() {
register_post_type('services-main', array(
        'labels' => array(
            'name' => __('Услуги'),
            'singular_name' => __('Услуга'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'services-main'),
    ));
}
add_action('init', 'services_custom_post_types');

function create_feedback_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'feedback';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        message text NOT NULL,
        consent tinyint(1) NOT NULL,
        date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id),
        INDEX idx_name (name(50)),
        INDEX idx_email (email),
        INDEX idx_message (message(50)),
        INDEX idx_consent (consent),
        INDEX idx_date (date)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'create_feedback_table');

function save_feedback_to_db() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        global $wpdb;

        $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
        $secret_key = '6LetyAgqAAAAAB0lPj4vL_QNpVu3qXb8mrSMhpkV'; 
        $response = wp_remote_post("https://www.google.com/recaptcha/api/siteverify", [
            'body' => [
                'secret' => $secret_key,
                'response' => $recaptcha_response,
            ]
        ]);
        $response_body = wp_remote_retrieve_body($response);
        $result = json_decode($response_body, true);

        if ($result['success']) {
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $message = sanitize_textarea_field($_POST['message']);
            $consent = isset($_POST['consent']) ? 1 : 0;
            $time = current_time('mysql');

            $wpdb->insert(
                $wpdb->prefix . 'feedback',
                [
                    'name' => $name,
                    'email' => $email,
                    'message' => $message,
                    'consent' => $consent,
                    'date' => $time
                ]
            );

            wp_insert_comment([
                'comment_post_ID' => 0,
                'comment_author' => $name,
                'comment_author_email' => $email,
                'comment_content' => $message,
                'comment_approved' => 1,
            ]);

            echo "<script>alert('Сообщение успешно отправлено!');</script>";
        } else {
            echo "<script>alert('Проверка reCAPTCHA не удалась.');</script>";
        }
    }
}
add_action('admin_post_nopriv_submit_feedback', 'save_feedback_to_db');
add_action('admin_post_submit_feedback', 'save_feedback_to_db');

function handle_submit_feedback() {
    check_ajax_referer('submit_feedback_nonce', 'security');
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);
    $consent = isset($_POST['consent']) ? 1 : 0;

    global $wpdb;
    $table_name = $wpdb->prefix . 'feedback';

    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'consent' => $consent,
            'date' => current_time('mysql')
        )
    );

    if ($wpdb->insert_id) {
        wp_insert_comment(array(
            'comment_post_ID' => 0,
            'comment_author' => $name,
            'comment_author_email' => $email,
            'comment_content' => $message,
            'comment_approved' => 1,
        ));
        wp_send_json_success(array('message' => 'Сообщение было отправлено. Спасибо!'));
    } else {
        wp_send_json_error(array('message' => 'Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз.'));
    }
}
add_action('wp_ajax_submit_feedback', 'handle_submit_feedback');
add_action('wp_ajax_nopriv_submit_feedback', 'handle_submit_feedback');


function rename_comment_menu() {
    global $menu;
    global $submenu;

    $menu[25][0] = 'Обратная связь';
    $submenu['edit-comments.php'][5][0] = 'Обратная связь';
    $submenu['edit-comments.php'][10][0] = 'Добавить новую'; 
}

add_action('admin_menu', 'rename_comment_menu');

function create_map_cpt() {
    $labels = array(
        'name'                  => _x( 'Карты', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Карта', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Карты', 'text_domain' ),
        'name_admin_bar'        => __( 'Карта', 'text_domain' ),
        'archives'              => __( 'Архив карт', 'text_domain' ),
        'attributes'            => __( 'Атрибуты карт', 'text_domain' ),
        'parent_item_colon'     => __( 'Родительская карта:', 'text_domain' ),
        'all_items'             => __( 'Все карты', 'text_domain' ),
        'add_new_item'          => __( 'Добавить новую карту', 'text_domain' ),
        'add_new'               => __( 'Добавить новую', 'text_domain' ),
        'new_item'              => __( 'Новая карта', 'text_domain' ),
        'edit_item'             => __( 'Редактировать карту', 'text_domain' ),
        'update_item'           => __( 'Обновить карту', 'text_domain' ),
        'view_item'             => __( 'Просмотреть карту', 'text_domain' ),
        'view_items'            => __( 'Просмотреть карты', 'text_domain' ),
        'search_items'          => __( 'Искать карты', 'text_domain' ),
        'not_found'             => __( 'Не найдено', 'text_domain' ),
        'not_found_in_trash'    => __( 'Не найдено в корзине', 'text_domain' ),
        'featured_image'        => __( 'Изображение карты', 'text_domain' ),
        'set_featured_image'    => __( 'Установить изображение карты', 'text_domain' ),
        'remove_featured_image' => __( 'Удалить изображение карты', 'text_domain' ),
        'use_featured_image'    => __( 'Использовать как изображение карты', 'text_domain' ),
        'insert_into_item'      => __( 'Вставить в карту', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Загружено для этой карты', 'text_domain' ),
        'items_list'            => __( 'Список карт', 'text_domain' ),
        'items_list_navigation' => __( 'Навигация по списку карт', 'text_domain' ),
        'filter_items_list'     => __( 'Фильтровать список карт', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Карта', 'text_domain' ),
        'description'           => __( 'Карта с настройками', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'map', $args );
}
add_action( 'init', 'create_map_cpt', 0 );


