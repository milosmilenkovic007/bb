<?php
/**
 * ACF customizations
 *
 * @package Webnorth
 * @subpackage LE34
 */

/**
 * Registration of "wp modules" command.
 *
 * @param  array $args CLI console arguments.
 * @param  array $params CLI console parameters.
 * @throws Exception When script encounters an error.
 * @return void
 */
function cli_command_modules( $args = array(), $params = array() ) {

	try {

		$action = $args[0] ?? false;

		switch ( $action ) :

			case 'generate':
				$theme_directory = get_stylesheet_directory();

				$module_id    = trim( $args[1] ?? '' );
				$module_title = isset( $params['title'] ) && $params['title'] ? $params['title'] : $module_id;

				if ( ! $module_id ) :

					if ( ! $module_title ) :

						$error_message = 'Module title wasn\'t specified';

						throw new Exception( $error_message );

						else :

							$module_id = sanitize_title( $module_title );

						endif;

					endif;

				$module_dir = sprintf(
					'%1$s/%2$s',
					THEME_MODULES_DIR,
					$module_id
				);

				if ( file_exists( $module_dir ) ) :

					$error_message = sprintf(
						'Module directory already exists. %1$s',
						$module_dir
					);

					throw new Exception( $error_message );

				endif;

				$module_class = sprintf( 'module-%1$s', $module_id );

				// create module's directory.
				mkdir( $module_dir, 0777 );

				WP_CLI::log(
					sprintf(
						'Created module dir: %1$s',
						str_replace( $theme_directory, '', $module_dir )
					)
				);

				$module_acf_dir = sprintf( '%1$s/acf-json', $module_dir );

				// create module's acf-json directory.
				mkdir( $module_acf_dir, 0777 );

				WP_CLI::log(
					sprintf(
						'Created module\'s acf-json dir: %1$s',
						str_replace( $theme_directory, '', $module_acf_dir )
					)
				);

				// create acf-json file.
				$module_acf_group_title = sprintf( 'Module: %1$s', $module_title );
				$module_acf_group_key   = sprintf( 'group_%1$s', $module_id );

				$module_acf_file = sprintf(
					'%1$s/%2$s.json',
					$module_acf_dir,
					$module_acf_group_key
				);

				$acf_group_json = array(
					'key'                   => $module_acf_group_key,
					'title'                 => $module_acf_group_title,
					'fields'                => array(
						array(
							'key'               => uniqid( 'field_' ),
							'label'             => 'Content',
							'name'              => '',
							'aria-label'        => '',
							'type'              => 'tab',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'placement'         => 'top',
							'endpoint'          => 0,
						),
						array(
							'key'               => uniqid( 'field_' ),
							'label'             => '',
							'name'              => '',
							'aria-label'        => '',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'maxlength'         => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
						),
						array(
							'key'               => uniqid( 'field_' ),
							'label'             => 'Settings',
							'name'              => '',
							'aria-label'        => '',
							'type'              => 'tab',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'placement'         => 'top',
							'endpoint'          => 0,
						),
						array(
							'key'               => uniqid( 'field_' ),
							'label'             => '',
							'name'              => '',
							'aria-label'        => '',
							'type'              => 'clone',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'clone'             => array(
								MODULE_SETTINGS_FIELD_GROUP_KEY,
							),
							'display'           => 'seamless',
							'layout'            => 'block',
							'prefix_label'      => 0,
							'prefix_name'       => 0,
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'flexible_content',
								'operator' => '==',
								'value'    => DEFAULT_FLEXIBLE_CONTENT_FIELD_KEY,
							),
						),
					),
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => true,
					'description'           => '',
					'show_in_rest'          => 0,
					'modified'              => time(),
				);

				$json_code = json_encode( $acf_group_json, JSON_PRETTY_PRINT );

				$handle = fopen( $module_acf_file, 'w+' );
				fwrite( $handle, $json_code );
				fclose( $handle );

				chmod( $module_acf_file, 0777 );

				WP_CLI::log(
					sprintf(
						'Created module\'s acf-json file: %1$s',
						str_replace( $theme_directory, '', $module_acf_file )
					)
				);

				// replacements for the blueprints.
				$replacements = array(
					'_module_id_'    => str_replace( '-', '_', $module_id ),
					'_module_name_'  => str_replace( '_', '-', $module_id ),
					'_module_title_' => $module_title,
				);

				// generate module file.
				$module_file = sprintf( '%1$s/module.php', $module_dir );

				// get blueprint and replace placeholders.
				$module_function_content = strtr(
					get_blueprint( 'module_function' ),
					$replacements
				);

				$handle = fopen( $module_file, 'w + ' );
				fwrite( $handle, $module_function_content );
				fclose( $handle );

				chmod( $module_file, 0777 );

				WP_CLI::log(
					sprintf(
						'Created module\'s function file: %1$s',
						str_replace( $theme_directory, '', $module_file )
					)
				);

				// generate module template file.
				$module_template_file = sprintf( '%1$s/%2$s.php', THEME_MODULES_TEMPLATE_DIR, $module_id );

				// get blueprint and replace placeholders.
				$module_template_content = strtr(
					get_blueprint( 'module_template_part' ),
					$replacements
				);

				$handle = fopen( $module_template_file, 'w+' );
				fwrite( $handle, $module_template_content );
				fclose( $handle );

				chmod( $module_template_file, 0777 );

				WP_CLI::log(
					sprintf(
						'Created module\'s template file: %1$s',
						str_replace( $theme_directory, '', $module_template_file )
					)
				);

				WP_CLI::log(
					sprintf(
						'Automatically synced "%1$s" field group.',
						$module_acf_group_title
					)
				);

				auto_sync_acf_field_group( $module_acf_group_key );

				WP_CLI::success( sprintf( 'Successfully generated "%1$s"', $module_title ) );

				break;

			default:
				$error_message = sprintf(
					'Invalid action: %1$s',
					$action
				);

				throw new Exception( $error_message );

				endswitch;

	} catch ( Exception $e ) {

		WP_CLI::error( $e->getMessage() );
	}
}

/**
 * Registers "wp modules" CLI command.
 *
 * @return void
 */
function register_custom_cli_commands() {
	WP_CLI::add_command( 'modules', 'cli_command_modules' );
}

add_action( 'cli_init', 'register_custom_cli_commands' );
