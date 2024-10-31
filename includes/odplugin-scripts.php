<?php
//Add Scripts
function od_add_scripts(){
    // Add Main CSS
    wp_enqueue_style('od-main-style', plugins_url(). '/onedesk/css/style.css');
    // Add Main JS
    wp_enqueue_script('od-main-script', plugins_url(). '/onedesk/js/main.js');

}

add_action('wp_enqueue_scripts', 'od_add_scripts');