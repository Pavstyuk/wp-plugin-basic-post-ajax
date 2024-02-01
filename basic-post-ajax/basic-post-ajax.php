<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pavstyuk.ru
 * @since             1.0.0
 * @package           Basic_Post_Ajax
 *
 * @wordpress-plugin
 * Plugin Name:       Basic Post Ajax
 * Plugin URI:        https://pavstyuk.ru
 * Description:       Basic Test Plugin
 * Version:           1.0.0
 * Author:            Mikhail
 * Author URI:        https://pavstyuk.ru/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       basic-post-ajax
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BASIC_POST_AJAX_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-basic-post-ajax-activator.php
 */
function activate_basic_post_ajax()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-basic-post-ajax-activator.php';
    Basic_Post_Ajax_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-basic-post-ajax-deactivator.php
 */
function deactivate_basic_post_ajax()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-basic-post-ajax-deactivator.php';
    Basic_Post_Ajax_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_basic_post_ajax');
register_deactivation_hook(__FILE__, 'deactivate_basic_post_ajax');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-basic-post-ajax.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_basic_post_ajax()
{

    $plugin = new Basic_Post_Ajax();
    $plugin->run();
}
run_basic_post_ajax();


function basic_post_ajax_script()
{
    wp_enqueue_script('post-ajax-send', plugin_dir_url(__FILE__) . '/public/js/post-send.js', array(), true);
}
add_action('wp_enqueue_scripts', 'basic_post_ajax_script');

function basic_post_form_shortcode()
{

    $form = '
        <form id="form_to_submit" method="POST" action="#" enctype="multipart/form-data">
    <div class="form-group">
        <label>Заголовок</label>
        <input type="text" id="title" class="form-control required" name="title" placeholder="Заголовок" />
    </div>
    <div class="form-group">
        <label>Содержание</label>
        <input type="text" id="content" class="form-control" name="content" placeholder="Содержание" />
    </div>
    <div class="row">
        <div class="form-group col">
            <label>Изображение объекта</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control required" />
        </div>
        <div class="form-group col">
            <label>Тип объекта</label>
            <select id="realty_type" name="realty_type" class="form-control required">
                <option value=""></option>
                <option value="apartment">Квартира</option>
                <option value="house">Дом</option>
                <option value="office">Офис</option>
                <option value="stock">Склад</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col">
            <label>Город объекта</label>
            <select id="city" name="city" class="form-control required">
                <option value=""></option>
                <option value="138">Барнаул</option>
                <option value="129">Новосибирск</option>
                <option value="132">Омск</option>
                <option value="135">Томск</option>
            </select>
        </div>
        <div class="form-group col">
            <label>Адрес</label>
            <input type="text" id="address" class="form-control required" name="address" />
        </div>
    </div>
    <div class="row">
        <div class="form-group col">
            <label>Площадь объекта</label>
            <input type="number" id="square" class="form-control required" name="square" min="10" step="1" />
        </div>
        <div class="form-group col">
            <label>Жилая площадь</label>
            <input type="number" id="square_live" class="form-control" name="square_live" min="10" step="1" />
        </div>
    </div>
    <div class="row">
        <div class="form-group col">
            <label>Этаж</label>
            <input type="number" id="floor" class="form-control required" name="floor" min="0" step="1" />
        </div>
        <div class="form-group col">
            <label>Стоимость</label>
            <input type="number" id="price" class="form-control required" name="price" min="1000" step="1000" />
        </div>
    </div>
    <div class="form-group">
        <label>Пароль: basic</label>
        <input type="password" id="password" class="form-control required" name="password" />
    </div>' .
        wp_nonce_field("thumbnail", "thumbnail_nonce") .
        '<div class="form-group mt-2">
        <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Отправить" />
    </div>
    </form>';

    return $form;
}

add_shortcode('basic_post_form', 'basic_post_form_shortcode');
