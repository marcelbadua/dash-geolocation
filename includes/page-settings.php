<?php
/**
 * Adds page details for lacalization
 *
 * @package _dash
 */
if (!class_exists('PAGE_LOCALIZATION_SETTINGS')) {
    class PAGE_LOCALIZATION_SETTINGS
    {

        private $_meta = array('page_localization');

        function __construct()
        {

            add_action('init', array(
                &$this,
                'init'
            ));

            add_action('admin_init', array(
                &$this,
                'admin_init'
            ));

        }

        public function init()
        {
            add_action('save_post', array(
                &$this,
                'save_post'
            ));

            add_action("template_redirect", array(
                &$this,
                'localization_redirect'
            ));

        }

        /**
         * Save the metaboxes for this custom post type
         */
        public function save_post($post_id)
        {
            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we dont want to do anything
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (isset($_POST['post_type']) && $_POST['post_type'] == 'page' && current_user_can('edit_post', $post_id)) {
                foreach ($this->_meta as $field_name) {
                    // Update the post's meta field
                    update_post_meta($post_id, $field_name, $_POST[$field_name]);
                }
            } else {
                return;
            } // if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
        } // END public function save_post($post_id)
        public function admin_init()
        {
            // Add metaboxes
            add_action('add_meta_boxes', array(
                &$this,
                'add_meta_boxes'
            ));

        }

        /**
         * hook into WP's add_meta_boxes action hook
         */
        public function add_meta_boxes()
        {
            // Add this metabox to every selected post
            add_meta_box('page-localization', __('Localization Settings', 'text_domain'), array(
                &$this,
                'add_inner_meta_boxes'
            ), array(
                'page'
            ), 'side');
        } // END public function add_meta_boxes()
        /**
         * called off of the add meta box
         */
        public function add_inner_meta_boxes($post)
        {
            $temp = @get_post_meta($post->ID, 'page_localization', true);
            $page_localization = isset($temp) ? $temp : '';
            $selected_locations = get_option('dash_geolocation_locations');
            $selected_locations['GEN'] = 'Show in locations not selected';
            $selected_locations[''] = 'Show by Default';
            echo '<label for="page_localization">' . esc_attr_e('Localization:', 'text_domain') . '</label><br>';
            echo '<select class="widefat" id="page_localization" name="page_localization">';
            foreach ($selected_locations as $key => $value) {
				echo '<option value="' . $key . '"' . selected(esc_attr($page_localization), $key) . '>' . $value . '</option>';
            }
            echo '</select>';

        } // END public function add_inner_meta_boxes($post)

        public function localization_redirect()
        {
            global $wp_query;
            global $post;
						
// 			$get_country = get_country() ;
// 			$locale = $get_country['isoCode'];

            if (isset($_GET['country'])) {
    		    $locale = $_GET['country'];
			}
			
			$page_selected_localization = @get_post_meta($post->ID, 'page_localization', true);
			$selected_locations = get_option('dash_geolocation_locations');
						
            if ( $page_selected_localization ) {
			        if ( array_key_exists( $locale, $selected_locations )) {
			          if ( $page_selected_localization != $locale  ) {
			            $return_template = sprintf("%1s/../tpl/redirect.php", dirname(__FILE__));
			            $this->do_theme_redirect($return_template);
			          }
			        } else {
			        	if ( $page_selected_localization != "GEN"  ) {
			            $return_template = sprintf("%1s/../tpl/redirect.php", dirname(__FILE__));
			          	$this->do_theme_redirect($return_template);
			          }
			        }
			      } 
        }

        public function do_theme_redirect($url)
        {
            global $post, $wp_query;
            if (have_posts()) {
                include $url;
                die();
            } else {
                $wp_query->is_404 = true;
            }
        }

    }
}
// class PAGE_LOCALIZATION_SETTINGS
