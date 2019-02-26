<?php

if(!class_exists('DASH_GEOLOCATION_PLUGIN_SETTINGS'))
{
	class DASH_GEOLOCATION_PLUGIN_SETTINGS
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// register actions
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('admin_menu', array(&$this, 'add_menu'));

		} // END public function __construct
	
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
					// register your plugin's settings
					register_setting('dash_geolocation_settings-group', 'dash_geolocation_mode');
        	register_setting('dash_geolocation_settings-group', 'dash_geolocation_locations');

						// add your settings section
        	add_settings_section(
        	    'dash_geolocation_settings-section',
        	    'Dash Geolocation Settings',
        	    array(&$this, 'settings_section_callback'),
        	    'dash_geolocation_settings'
        	);

        	// add your setting's fields

					add_settings_field(
					'dash_geolocation_settings-dash_geolocation_mode',
					'Test Mode',
					array(&$this, 'settings_field_input_mode'),
					'dash_geolocation_settings',
					'dash_geolocation_settings-section',
					array(
							'field' => 'dash_geolocation_mode'
					)
					);

            add_settings_field(
                'dash_geolocation_settings-dash_geolocation_locations',
                'Check Country',
                array(&$this, 'settings_field_input_countries'),
                'dash_geolocation_settings',
                'dash_geolocation_settings-section',
                array(
                    'field' => 'dash_geolocation_locations'
                )
            );

          // Possibly do additional admin_init tasks
          
          add_action( 'admin_enqueue_scripts', array(&$this, 'load_custom_wp_admin_style' ));
          
        } // END public static function activate
				
				public function load_custom_wp_admin_style()
				{
				  wp_enqueue_style('dash-geolocation', 
				  	plugin_dir_url(__FILE__) . "css/dash-geolocation-admin.css" ,
				  	array(), 
				  	'1.0.0', 
				  	'all'
				  );
				}
				public function settings_section_callback()
				{
						// Think of this as help text for the section.
						echo 'These settings do things for the Dash: Geolocation.';
				}

				public function settings_field_input_mode($args)
        {
					$field = $args['field'];
					// Get the value of this setting
					$value = get_option($field);
					?>
						<input type="checkbox"
							name="<?php echo $field; ?>"
							value="true"
							<?php checked('true', $value); ?>>
							Toggle test mode <br>
							<em>on test mode on, add this '?country=XX' to the url XX for isocode of country you want to test. eg AU for Australia NZ for New Zealand.</em>
					<?php
				}

        public function settings_field_input_countries($args)
        {
					$locale_data = array(
					    'AF' => 'Afghanistan',
					    'AX' => 'Aland Islands',
					    'AL' => 'Albania',
					    'DZ' => 'Algeria',
					    'AS' => 'American Samoa',
					    'AD' => 'Andorra',
					    'AO' => 'Angola',
					    'AI' => 'Anguilla',
					    'AQ' => 'Antarctica',
					    'AG' => 'Antigua and Barbuda',
					    'AR' => 'Argentina',
					    'AM' => 'Armenia',
					    'AW' => 'Aruba',
					    'AU' => 'Australia',
					    'AT' => 'Austria',
					    'AZ' => 'Azerbaijan',
					    'BS' => 'Bahamas',
					    'BH' => 'Bahrain',
					    'BD' => 'Bangladesh',
					    'BB' => 'Barbados',
					    'BY' => 'Belarus',
					    'BE' => 'Belgium',
					    'BZ' => 'Belize',
					    'BJ' => 'Benin',
					    'BM' => 'Bermuda',
					    'BT' => 'Bhutan',
					    'BO' => 'Bolivia',
					    'BQ' => 'Bonaire, Saint Eustatius and Saba',
					    'BA' => 'Bosnia and Herzegovina',
					    'BW' => 'Botswana',
					    'BV' => 'Bouvet Island',
					    'BR' => 'Brazil',
					    'IO' => 'British Indian Ocean Territory',
					    'VG' => 'British Virgin Islands',
					    'BN' => 'Brunei',
					    'BG' => 'Bulgaria',
					    'BF' => 'Burkina Faso',
					    'BI' => 'Burundi',
					    'KH' => 'Cambodia',
					    'CM' => 'Cameroon',
					    'CA' => 'Canada',
					    'CV' => 'Cape Verde',
					    'KY' => 'Cayman Islands',
					    'CF' => 'Central African Republic',
					    'TD' => 'Chad',
					    'CL' => 'Chile',
					    'CN' => 'China',
					    'CX' => 'Christmas Island',
					    'CC' => 'Cocos Islands',
					    'CO' => 'Colombia',
					    'KM' => 'Comoros',
					    'CK' => 'Cook Islands',
					    'CR' => 'Costa Rica',
					    'HR' => 'Croatia',
					    'CU' => 'Cuba',
					    'CW' => 'Curacao',
					    'CY' => 'Cyprus',
					    'CZ' => 'Czech Republic',
					    'CD' => 'Democratic Republic of the Congo',
					    'DK' => 'Denmark',
					    'DJ' => 'Djibouti',
					    'DM' => 'Dominica',
					    'DO' => 'Dominican Republic',
					    'TL' => 'East Timor',
					    'EC' => 'Ecuador',
					    'EG' => 'Egypt',
					    'SV' => 'El Salvador',
					    'GQ' => 'Equatorial Guinea',
					    'ER' => 'Eritrea',
					    'EE' => 'Estonia',
					    'ET' => 'Ethiopia',
					    'FK' => 'Falkland Islands',
					    'FO' => 'Faroe Islands',
					    'FJ' => 'Fiji',
					    'FI' => 'Finland',
					    'FR' => 'France',
					    'GF' => 'French Guiana',
					    'PF' => 'French Polynesia',
					    'TF' => 'French Southern Territories',
					    'GA' => 'Gabon',
					    'GM' => 'Gambia',
					    'GE' => 'Georgia',
					    'DE' => 'Germany',
					    'GH' => 'Ghana',
					    'GI' => 'Gibraltar',
					    'GR' => 'Greece',
					    'GL' => 'Greenland',
					    'GD' => 'Grenada',
					    'GP' => 'Guadeloupe',
					    'GU' => 'Guam',
					    'GT' => 'Guatemala',
					    'GG' => 'Guernsey',
					    'GN' => 'Guinea',
					    'GW' => 'Guinea-Bissau',
					    'GY' => 'Guyana',
					    'HT' => 'Haiti',
					    'HM' => 'Heard Island and McDonald Islands',
					    'HN' => 'Honduras',
					    'HK' => 'Hong Kong',
					    'HU' => 'Hungary',
					    'IS' => 'Iceland',
					    'IN' => 'India',
					    'ID' => 'Indonesia',
					    'IR' => 'Iran',
					    'IQ' => 'Iraq',
					    'IE' => 'Ireland',
					    'IM' => 'Isle of Man',
					    'IL' => 'Israel',
					    'IT' => 'Italy',
					    'CI' => 'Ivory Coast',
					    'JM' => 'Jamaica',
					    'JP' => 'Japan',
					    'JE' => 'Jersey',
					    'JO' => 'Jordan',
					    'KZ' => 'Kazakhstan',
					    'KE' => 'Kenya',
					    'KI' => 'Kiribati',
					    'XK' => 'Kosovo',
					    'KW' => 'Kuwait',
					    'KG' => 'Kyrgyzstan',
					    'LA' => 'Laos',
					    'LV' => 'Latvia',
					    'LB' => 'Lebanon',
					    'LS' => 'Lesotho',
					    'LR' => 'Liberia',
					    'LY' => 'Libya',
					    'LI' => 'Liechtenstein',
					    'LT' => 'Lithuania',
					    'LU' => 'Luxembourg',
					    'MO' => 'Macao',
					    'MK' => 'Macedonia',
					    'MG' => 'Madagascar',
					    'MW' => 'Malawi',
					    'MY' => 'Malaysia',
					    'MV' => 'Maldives',
					    'ML' => 'Mali',
					    'MT' => 'Malta',
					    'MH' => 'Marshall Islands',
					    'MQ' => 'Martinique',
					    'MR' => 'Mauritania',
					    'MU' => 'Mauritius',
					    'YT' => 'Mayotte',
					    'MX' => 'Mexico',
					    'FM' => 'Micronesia',
					    'MD' => 'Moldova',
					    'MC' => 'Monaco',
					    'MN' => 'Mongolia',
					    'ME' => 'Montenegro',
					    'MS' => 'Montserrat',
					    'MA' => 'Morocco',
					    'MZ' => 'Mozambique',
					    'MM' => 'Myanmar',
					    'NA' => 'Namibia',
					    'NR' => 'Nauru',
					    'NP' => 'Nepal',
					    'NL' => 'Netherlands',
					    'NC' => 'New Caledonia',
					    'NZ' => 'New Zealand',
					    'NI' => 'Nicaragua',
					    'NE' => 'Niger',
					    'NG' => 'Nigeria',
					    'NU' => 'Niue',
					    'NF' => 'Norfolk Island',
					    'KP' => 'North Korea',
					    'MP' => 'Northern Mariana Islands',
					    'NO' => 'Norway',
					    'OM' => 'Oman',
					    'PK' => 'Pakistan',
					    'PW' => 'Palau',
					    'PS' => 'Palestinian Territory',
					    'PA' => 'Panama',
					    'PG' => 'Papua New Guinea',
					    'PY' => 'Paraguay',
					    'PE' => 'Peru',
					    'PH' => 'Philippines',
					    'PN' => 'Pitcairn',
					    'PL' => 'Poland',
					    'PT' => 'Portugal',
					    'PR' => 'Puerto Rico',
					    'QA' => 'Qatar',
					    'CG' => 'Republic of the Congo',
					    'RE' => 'Reunion',
					    'RO' => 'Romania',
					    'RU' => 'Russia',
					    'RW' => 'Rwanda',
					    'BL' => 'Saint Barthelemy',
					    'SH' => 'Saint Helena',
					    'KN' => 'Saint Kitts and Nevis',
					    'LC' => 'Saint Lucia',
					    'MF' => 'Saint Martin',
					    'PM' => 'Saint Pierre and Miquelon',
					    'VC' => 'Saint Vincent and the Grenadines',
					    'WS' => 'Samoa',
					    'SM' => 'San Marino',
					    'ST' => 'Sao Tome and Principe',
					    'SA' => 'Saudi Arabia',
					    'SN' => 'Senegal',
					    'RS' => 'Serbia',
					    'SC' => 'Seychelles',
					    'SL' => 'Sierra Leone',
					    'SG' => 'Singapore',
					    'SX' => 'Sint Maarten',
					    'SK' => 'Slovakia',
					    'SI' => 'Slovenia',
					    'SB' => 'Solomon Islands',
					    'SO' => 'Somalia',
					    'ZA' => 'South Africa',
					    'GS' => 'South Georgia and the South Sandwich Islands',
					    'KR' => 'South Korea',
					    'SS' => 'South Sudan',
					    'ES' => 'Spain',
					    'LK' => 'Sri Lanka',
					    'SD' => 'Sudan',
					    'SR' => 'Suriname',
					    'SJ' => 'Svalbard and Jan Mayen',
					    'SZ' => 'Swaziland',
					    'SE' => 'Sweden',
					    'CH' => 'Switzerland',
					    'SY' => 'Syria',
					    'TW' => 'Taiwan',
					    'TJ' => 'Tajikistan',
					    'TZ' => 'Tanzania',
					    'TH' => 'Thailand',
					    'TG' => 'Togo',
					    'TK' => 'Tokelau',
					    'TO' => 'Tonga',
					    'TT' => 'Trinidad and Tobago',
					    'TN' => 'Tunisia',
					    'TR' => 'Turkey',
					    'TM' => 'Turkmenistan',
					    'TC' => 'Turks and Caicos Islands',
					    'TV' => 'Tuvalu',
					    'VI' => 'U.S. Virgin Islands',
					    'UG' => 'Uganda',
					    'UA' => 'Ukraine',
					    'AE' => 'United Arab Emirates',
					    'GB' => 'United Kingdom',
					    'US' => 'United States',
					    'UM' => 'United States Minor Outlying Islands',
					    'UY' => 'Uruguay',
					    'UZ' => 'Uzbekistan',
					    'VU' => 'Vanuatu',
					    'VA' => 'Vatican',
					    'VE' => 'Venezuela',
					    'VN' => 'Vietnam',
					    'WF' => 'Wallis and Futuna',
					    'EH' => 'Western Sahara',
					    'YE' => 'Yemen',
					    'ZM' => 'Zambia',
					    'ZW' => 'Zimbabwe'
					);
            // Get the field name from the $args array
						$field = $args['field'];
            // Get the value of this setting
            $saved_value = get_option($field);
						// echo '<pre>';
						// print_r($saved_value);
						echo '<ul class="list-countries">';
						foreach ($locale_data as $key => $value) { ?>
							<li><input type="checkbox"
							  name="<?php echo $field; ?>[<?php echo $key ?>]"
						    value="<?php echo $value; ?>"
						    <?php if (array_key_exists($key, $saved_value)) echo 'checked'; ?>>
						    <?php echo $value; ?></li>
						<?php }
						echo '</ul>';
        } // END public function settings_field_input_text($args)

        /**
         * add a menu
         */
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'Dash Geolocation Settings',
        	    'Dash Geolocation',
        	    'manage_options',
        	    'dash_geolocation_settings',
        	    array(&$this, 'plugin_settings_page')
        	);
        } // END public function add_menu()

        /**
         * Menu Callback
         */
        public function plugin_settings_page()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}

        	// Render the settings template
        	include(sprintf("%s/tpl/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class DASH_GEOLOCATION_PLUGIN_SETTINGS
} // END if(!class_exists('DASH_GEOLOCATION_PLUGIN_SETTINGS'))
