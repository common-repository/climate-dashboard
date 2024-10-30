<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.climatelevels.org/plugin
 * @since             1.0.0
 * @package           Climate_Dashboard
 *
 * @wordpress-plugin
 * Plugin Name:       Climate Dashboard
 * Plugin URI:        https://www.climatelevels.org/plugin
 * Description:       Insert CO2 and other Climate Change related timegraphs 
anywhere on your wordpress website proving that levels keep rising at ever higher speeds.
 * Version:           1.0.0
 * Author:            2 Degrees Institute
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       climate-dashboard
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CLIMATE_DASHBOARD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-climate-dashboard-activator.php
 */
function activate_climate_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-climate-dashboard-activator.php';
	Climate_Dashboard_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-climate-dashboard-deactivator.php
 */
function deactivate_climate_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-climate-dashboard-deactivator.php';
	Climate_Dashboard_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_climate_dashboard' );
register_deactivation_hook( __FILE__, 'deactivate_climate_dashboard' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-climate-dashboard.php';



/**
 * adding shortcode timegraphs,
 *
 */
function timegraphs( $atts = '' ) {
    $value = shortcode_atts( array(
        'type' => 'CO2',
        'addtemp' => 250,
        'fromyear' => 1970,
    ), $atts );
// if ($value["fromyear"] < 1970 ){ $value["fromyear"]=1970; }
// Register the script
// wp_register_script('gaugeanim',plugin_dir_url(__FILE__) . 'js/climate.js', array('highcharts','highchartsmore','jquery'));
// Localize the script with new data
// wp_localize_script('gaugeanim','object_dash',$value);
// Enqueued script with localized data.
// wp_enqueue_script('gaugeanim');

// Things that you want to do. 

switch ($value["type"]) {
   case 'CO2':
         $message = '<div id="co2-widget-container"></div><script type="text/javascript" src="https://www.climatelevels.org/graphs/js/co2.php?theme=default&pid=2degreesinstitute"></script>';
         break;
   case 'temp':
         $message = '<div id="temperature-widget-container"></div><script type="text/javascript" src="https://www.climatelevels.org/graphs/js/temperature.php?theme=default&pid=2degreesinstitute"></script>';
         break;
   case 'methane':
         $message = '<div id="ch4-widget-container"></div><script type="text/javascript" src="https://www.climatelevels.org/graphs/js/ch4.php?theme=default&pid=2degreesinstitute"></script>';
         break;
case 'O2':
         $message = '<div id="o2-widget-container"></div><script type="text/javascript" src="https://www.climatelevels.org/graphs/js/o2.php?theme=default&pid=2degreesinstitute"></script>';
         break;
case 'sealevel':
         $message = '<div id="sealevels-widget-container"></div><script type="text/javascript" src="https://www.climatelevels.org/graphs/js/sealevels.php?theme=default&pid=2degreesinstitute"></script>';
         break;
case 'NOX':
         $message = '<div id="n2o-widget-container"></div><script type="text/javascript" src="https://www.climatelevels.org/graphs/js/n2o.php?theme=default&pid=2degreesinstitute"></script>';
         break;
}
 
// Output needs to be return
return $message;

}

// register shortcode
add_shortcode('TG', 'timegraphs'); 




/**
 * adding custom dashboard widget,
 *
 */
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
  
function my_custom_dashboard_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'Climate Change Dashboard', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {

echo do_shortcode( '[TG type = CO2]' );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_climate_dashboard() {

	$plugin = new Climate_Dashboard();
	$plugin->run();

}
run_climate_dashboard();
