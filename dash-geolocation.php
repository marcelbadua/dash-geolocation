<?php

/*
Plugin Name: DASH: Geolocation
Plugin URI:
Description: Geolocation solution for widget and Post
Version: 1.0
Author: Marcel Badua
Author URI: http://marcelbadua.com/
License: GPL2
*/

/*
Copyright 2017  Marcel Badua  (email : marcel.badua@ballistix.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once( sprintf("%s/vendor/autoload.php", dirname(__FILE__)) );

if (!class_exists('DASH_GEOLOCATION_PLUGIN')) {

    class DASH_GEOLOCATION_PLUGIN
    {

        /**
         * Construct the plugin object
         */
        public function __construct() {
            
            require_once(sprintf("%s/functions.php", dirname(__FILE__)));
            
            // Initialize Settings
            require_once(sprintf("%s/settings.php", dirname(__FILE__)));
            $DASH_GEOLOCATION_PLUGIN_SETTINGS = new DASH_GEOLOCATION_PLUGIN_SETTINGS();

            require_once( sprintf("%s/includes/construct.php", dirname(__FILE__)) );
            $DASH_GEOLOCATION_PLUGIN_CONSTRUCT = new DASH_GEOLOCATION_PLUGIN_CONSTRUCT();
            
            require_once( sprintf("%s/includes/page-settings.php", dirname(__FILE__)) );
            $PAGE_LOCALIZATION_SETTINGS = new PAGE_LOCALIZATION_SETTINGS();


        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate() {
            // Do nothing
        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate() {
            // Do nothing
        }// END public static function deactivate

    } // END class DASH_GEOLOCATION_PLUGIN
} // END if(!class_exists('DASH_GEOLOCATION_PLUGIN'))

if (class_exists('DASH_GEOLOCATION_PLUGIN')) {
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('DASH_GEOLOCATION_PLUGIN','activate'));
    register_deactivation_hook(__FILE__, array( 'DASH_GEOLOCATION_PLUGIN', 'deactivate'));
    // instantiate the plugin class
    $DASH_GEOLOCATION_PLUGIN = new DASH_GEOLOCATION_PLUGIN();
}
