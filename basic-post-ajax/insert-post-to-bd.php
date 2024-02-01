<?php

$title = $_POST['title'];
$content = $_POST['content'];
$realty_type_slug = $_POST['realty_type'];
$city = $_POST['city'];
$address = $_POST['address'];
$square = $_POST['square'];
$square_live = $_POST['square_live'];
$floor = $_POST['floor'];
$price = $_POST['price'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

// Сollect data of new realty
$post_data = array(
    'post_type' => 'realty',
    'post_author' => 1,
    'post_title' => $title,
    'post_content' => $content,
    'post_status' => 'publish',
    'comment_status' => 'closed',
    'ping_status' => 'closed',
    'post_parent' => $city,
);

// Post data of new realty
$post_id = wp_insert_post(wp_slash($post_data));

// Collect data and insert in Custom Fields by post ID with CFS API
$field_data = array('object_address' => $address, 'object_square' => $square, 'object_square_live' => $square_live, 'object_floor' => $floor, 'object_price' => $price);
$post_data = array('ID' => $post_id);
CFS()->save($field_data, $post_data);

// Set custom taxonomy for posted object
// $termObj  = get_term_by('id', $realty_type_id, 'realty_type');
wp_set_object_terms($post_id, array($realty_type_slug), 'realty_type');


// Works with Image
if (isset($_POST['thumbnail_nonce']) && wp_verify_nonce($_POST['thumbnail_nonce'], 'thumbnail')) {

    // Эти файлы должны быть подключены в лицевой части (фронт-энде).
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Позволим WordPress перехватить загрузку.
    // не забываем указать атрибут name поля input - 'my_image_upload'
    $attachment_id = media_handle_upload('thumbnail', $post_id);

    if (is_wp_error($attachment_id)) {
        echo "Ошибка загрузки медиафайла.";
    } else {
        update_post_meta($post_id, '_thumbnail_id', $attachment_id);
    }
} else {
    echo "Проверка не пройдена. Невозможно загрузить файл.";
}


if ($post_id && $attachment_id) {
    echo $post_id . ', ' . $attachment_id;
} else {
    echo "Ошибка";
}
