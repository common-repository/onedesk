<?php
/**
 * Plugin Name: OneDesk
 * Plugin URI: https://wordpress.org/plugins/onedesk
 * Description: Add the OneDesk Widget for easy access to OneDesk from any page on your website
 * Version: 0.1.0
 * Author: OneDesk Software Inc.
 * Author URI: https://www.onedesk.com/
 * Text Domain: onedesk
 * License: GPLv2 or later
 */

 /*

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

 //Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/odplugin-scripts.php');

//Load Class
require_once(plugin_dir_path(__FILE__).'/includes/odplugin-class.php');

//Register Widget
function OD_Plugin_Widget(){
    register_widget('OD_Plugin_Widget');
}
include 'templates/ODSettingsPage.php';
//Hook in function
add_action('widgets_init', 'OD_Plugin_Widget');

$plugin = plugin_basename(__FILE__);

add_filter( "plugin_action_links_$plugin", 'settings_link');
add_filter( "plugin_action_links_$plugin", 'od_website_link');


function settings_link($links) {
    //Settings link from plugin page
    $settings_link = '<a href= "options-general.php?page=odwidget-settings">Settings</a>';
    array_push($links, $settings_link);
    return $links;
}

function od_website_link($links) {
    //OneDesk website link from plugin page
    $od_website_link = '<a href= "https://www.onedesk.com/">OneDesk Website</a>';
    array_push($links, $od_website_link);
    return $links;
}

function add_od_widget_to_wp_footer() {
    $options = get_option( 'od_option_name' );

    echo '<script type="text/javascript" src="https://app.onedesk.com/odWidget/assets/js/od-com-widget.js" 
	org-name="'.$options['org_name'].'" url="https://app.onedesk.com/odWidget"
	origin="'.$options['origin'].'" x="'.$options['x_pos'].'" 
	y="'.$options['y_pos'].'" open-color="'.$options['open_color'].'" 
	close-color="'.$options['close_color'].'" ></script>';
}

add_action('wp_footer', 'add_od_widget_to_wp_footer', 0);