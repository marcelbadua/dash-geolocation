<?php

# DEV NOTES
# https://themefoundation.com/custom-widget-options/

use GeoIp2\Database\Reader;

if (!class_exists('DASH_GEOLOCATION_PLUGIN_CONSTRUCT')) {
	class DASH_GEOLOCATION_PLUGIN_CONSTRUCT
	{

		/**
		* The Constructor
		*/
		public function __construct()
		{
			// register actions
			add_action('init', array(&$this, 'init'));
		} // END public function __construct()

		public function init()
		{
			add_filter('in_widget_form', array(&$this, 'add_local_widget_option'), 10, 3 );
			add_filter( 'widget_update_callback', array(&$this, 'save_local_widget_option'), 10, 2 );
			add_filter( 'dynamic_sidebar_params', array(&$this, 'prefix_menu_description_control' ));
			add_action( 'wp_footer', array(&$this,'append_locale_to_url'), 10, 2 );

		}// END public function init()
		
		public function append_locale_to_url() {
	   	$local = get_country() ;
	   	if(!get_option('dash_geolocation_mode')) {
	   		echo sprintf('<script>var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?country=%s";window.history.pushState({path:newurl},"",newurl);</script>', $local['isoCode'] );	
	   	}
    }

		public function add_local_widget_option( $widget, $return, $instance ) {
			$localization = isset( $instance['localization'] ) ? $instance['localization'] : '';
			$selected_locations = get_option('dash_geolocation_locations');

      echo '<label for="' . esc_attr( $widget->get_field_id( 'localization' ) ) . '">' . esc_attr_e( 'Localization:', 'text_domain' ). '</label><br>';
      echo '<select class="widefat" id="' . esc_attr( $widget->get_field_id( 'localization' ) ) . '" name="' . esc_attr( $widget->get_field_name( 'localization' ) ) . '">';
      foreach ($selected_locations as $key => $value) { ?>
        <option
          value="<?php echo $key; ?>"
          <?php selected(esc_attr( $localization ),$key); ?>>
          <?php echo $value; ?>
        </option>
      <?php }
      echo '<option value="GEN"' . selected(esc_attr( $localization ), 'GEN'). '>Show in locations not selected</option>';
      echo '<option value=""' . selected(esc_attr( $localization ), ''). '>Show by Default</option>';
      echo '</select>';
     }

    public function save_local_widget_option( $instance, $new_instance ) {
			return $new_instance;
		}

		public function prefix_menu_description_control( $params ) {
			
      $options = [];
			
      if (isset($_GET['country'])) {
    		$locale = $_GET['country'];
			}
			
			$selected_locations = get_option('dash_geolocation_locations');
			$widget_type = preg_replace ( '/-[0-9]*$/' , '',  $params[0]['widget_id']);

			try {
				$options = $this->get_sidebar_widget_options($params[0]['id'], $widget_type, $params[1]['number']);
			} catch (Exception $e) {}
			
      if ($options['localization']) {
        if ( array_key_exists( $locale, $selected_locations )) {
          if ( $options['localization'] != $locale  ) {
            $params[0] = array_replace($params[0],array('before_widget' => str_replace('class=', 'style="display: none;" class=', $params[0]['before_widget'])));
          }
        } else {
          if ( $options['localization'] != "GEN"  ) {
            $params[0] = array_replace($params[0],array('before_widget' => str_replace('class=', 'style="display: none;" class=', $params[0]['before_widget'])));
          }
        }
      }

			return $params;
		}

		/**
		 * https://www.flynsarmy.com/2015/06/retrieving-wordpress-sidebar-widget-options/
		 *
		 * Find a given widget in a given sidebar and return its settings.
		 *
		 * Example usage:
		 * $options = [];
		 * try {
		 *    $options = get_sidebar_widget_options('sidebar-1', 'recent-comments');
		 * } catch (Exception $e) {}
		 *
		 * @param $sidebar_id    The ID of the sidebar. Defined in your register_sidebar() call
		 * @param $widget_type   Widget type specified in register_sidebar()
		 * @return array         Saved options
		 * @throws Exception     "Widget not found in sidebar" or "Widget has no saved options"
		 */
		public function get_sidebar_widget_options($sidebar_id, $widget_type, $widget_number)
		{
		    // Grab the list of sidebars and their widgets
		    $sidebars = wp_get_sidebars_widgets();
		    // Just grab the widgets for our sidebar
		    $widgets = $sidebars[$sidebar_id];

		    // Get the ID of our widget in this sidebar
		    $widget_id = 0;
		    foreach ( $widgets as $widget_details )
		    {
		        // $widget_details is of the format $widget_type-$id - we just want the id part
		        if ( preg_match("/^{$widget_type}\-(?P<id>\d+)$/", $widget_details, $matches) )
		        {
		            $widget_id = $matches['id'];
		            break;
		        }
		    }

		    // If we didn't find the given widget in the given sidebar, throw an error
		    if ( !$widget_id )
		        throw new Exception("Widget not found in sidebar");

		    // Grab the options of each instance of our $widget_type from the DB
		    $options = get_option('widget_' . $widget_type);
				

					
		    // Ensure there are settings to return
		    if ( !isset($options[$widget_id]) )
		        throw new Exception("Widget has no saved options");
	
		        //echo $widget_id;
		    $widget_options = $options[$widget_number];
		    // Grab the settings
		//    $widget_options = $options[$widget_id];

		    return $widget_options;
		}


	}// END class DASH_GEOLOCATION_PLUGIN_CONSTRUCT
} // END if(!class_exists('DASH_GEOLOCATION_PLUGIN_CONSTRUCT'))
