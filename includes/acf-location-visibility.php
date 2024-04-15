<?php
/**
 * ACF Visibility Location class
 *
 * Use this for field groups that shouldn't have any locations selected, because they are to be cloned.
 *
 * @package Bollsvenskan
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

if ( ! class_exists( 'ACF_Location_Visibility' ) ) :

	/**
	 * Adds new ACF Field Group location
	 */
	final class ACF_Location_Visibility extends ACF_Location {

		/**
		 * Initialization of ACF Location
		 *
		 * @return void
		 */
		public function initialize() {
			$this->name        = 'visibility';
			$this->label       = __( 'Visibility', 'acf' );
			$this->category    = 'Bollsvenskan';
			$this->object_type = '';
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

			return 'visible' === $rule['value'];
		}

		/**
		 * Return options for select dropdown when this location is selected.
		 *
		 * @param  array $rule Currently selected rule.
		 * @return array Array of options to present to user.
		 */
		public function get_values( $rule ): array {

			$values = array(
				'hidden'  => __( 'Hidden', 'bollsvenskan' ),
				'visible' => __( 'Visible', 'bollsvenskan' ),
			);

			return $values;
		}
	}

	acf_register_location_type( 'ACF_Location_Visibility' );

endif;
