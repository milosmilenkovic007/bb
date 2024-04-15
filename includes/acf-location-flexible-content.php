<?php
/**
 * includes/acf-location-flexible-content.php
 * ACF Flexible Content Location class
 *
 * @package bollsvenskan
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

if ( ! class_exists( 'ACF_Location_Flexible_Content' ) ) :

	/**
	 * Adds new ACF Field Group location
	 */
	final class ACF_Location_Flexible_Content extends ACF_Location {

		/**
		 * Initialization of ACF Location
		 *
		 * @return void
		 */
		public function initialize() {
			$this->name        = 'flexible_content';
			$this->label       = __( 'Flexible Content', 'acf' );
			$this->category    = 'Bollsvenskan';
			$this->object_type = 'block';
		}

		/**
		 * Returns an array of operators for this location.
		 *
		 * @date    9/4/20
		 * @since   5.9.0
		 *
		 * @param   array $rule A location rule.
		 * @return  array
		 */
		public static function get_operators( $rule ) {
			return array(
				'==' => __( 'is equal to', 'acf' ),
			);
		}

		/**
		 * Matches the provided rule against the screen args returning a bool result.
		 *
		 * @date    9/4/20
		 * @since   5.9.0
		 *
		 * @param   array $rule The location rule.
		 * @param   array $screen The screen args.
		 * @param   array $field_group The field group settings.
		 * @return  bool
		 */
		public function match( $rule, $screen, $field_group ) {

			global $current_flexible_content_field;

			if ( ! $current_flexible_content_field ) :
				return false;
			endif;

			return 'all' === $rule['value'] || $rule['value'] === $current_flexible_content_field;
		}

		/**
		 * Return options for select dropdown when this location is selected.
		 *
		 * @param  array $rule Currently selected rule, disregard here since it is checked only on page load or location change ( not when operator changes ).
		 * @return array Array of options to present to user.
		 */
		public function get_values( $rule ): array {

			$values = array(
				'all' => __( 'All', 'bollsvenskan' ),
			);

			$raw_groups = array();

			foreach ( acf_get_field_groups() as $field_group ) :

				$fields = acf_get_fields( $field_group['key'] );

				$raw_group_fields = array();

				foreach ( $fields as $field ) :
					if ( 'flexible_content' === $field['type'] ) :

						$raw_group_fields[] = array(
							'key'   => $field['key'],
							'label' => $field['label'],
						);

					endif;
				endforeach;

				if ( ! empty( $raw_group_fields ) ) :
					usort(
						$raw_group_fields,
						function ( $a, $b ) {
							return strnatcasecmp( $a['label'], $b['label'] );
						}
					);

					$fields = array();

					foreach ( $raw_group_fields as $raw_group_field ) :
						$fields[ $raw_group_field['key'] ] = $raw_group_field['label'];
					endforeach;

					$raw_groups[] = array(
						'label'  => $field_group['title'],
						'fields' => $fields,
					);

				endif;

			endforeach;

			usort(
				$raw_groups,
				function ( $a, $b ) {
					return strnatcasecmp( $a['label'], $b['label'] );
				}
			);

			foreach ( $raw_groups as $raw_group ) :
				$values[ $raw_group['label'] ] = $raw_group['fields'];
			endforeach;

			return $values;
		}
	}

	acf_register_location_type( 'ACF_Location_Flexible_Content' );

endif;
