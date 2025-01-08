<?php
/**
 * Core file.
 * Resist deletion.
 *
 * @package Teachable
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enrollment count.
 *
 * @param string $id The id for the product.
 * @param string $classes Custom classes.
 * @param string $styles Styles css inline styles.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_product_enrollment_count',
	function ( $id, $classes = '', $styles = '' ) {
		if ( ! $id ) {
			do_action( 'teachable_frontend_error' );
			return;
		}

		$product_data = teachable_data( $id );

		if ( null === $product_data ) {
			do_action( 'teachable_frontend_error' );
			return;
		}

		if ( ! isset( $product_data['enrollment_count'] ) ) {
			$product_data['enrollment_count'] = 0;
		}

		Teachable\teachable_buy_button_assets();

		$classes = apply_filters( 'teachable_product_enrollment_count_classes', $classes );
		$styles  = apply_filters( 'teachable_product_enrollment_count_styles', $styles );
		$data    = apply_filters( 'teachable_buy_button_data_' . $id, $product_data );

		ob_start();

		if ( isset( $data['enrollment_count'] ) && null !== $data['enrollment_count'] ) {
			echo '<p class="teachable-enrollment-count ' . esc_attr( $classes ) . '" style="' . esc_html( $styles ) . '"> <span class="teachable-enrollment-count-icon"><svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block"><path d="M0.833008 13.667V11.271C0.833008 10.785 0.958008 10.3473 1.20801 9.95801C1.45801 9.56934 1.78467 9.27768 2.18801 9.08301C3.02134 8.66634 3.89601 8.35401 4.81201 8.14601C5.72934 7.93734 6.64601 7.83301 7.56201 7.83301C8.47934 7.83301 9.39601 7.94068 10.312 8.15601C11.2293 8.37134 12.1047 8.68034 12.938 9.08301C13.3407 9.27768 13.667 9.56934 13.917 9.95801C14.167 10.3473 14.292 10.785 14.292 11.271V13.667H0.833008ZM7.56201 6.97901C6.61801 6.97901 5.82667 6.65968 5.18801 6.02101C4.54867 5.38168 4.22901 4.59001 4.22901 3.64601C4.22901 2.70134 4.54867 1.90968 5.18801 1.27101C5.82667 0.631678 6.61801 0.312012 7.56201 0.312012C8.50667 0.312012 9.29867 0.631678 9.93801 1.27101C10.5767 1.90968 10.896 2.70134 10.896 3.64601C10.896 4.59001 10.5767 5.38168 9.93801 6.02101C9.29867 6.65968 8.50667 6.97901 7.56201 6.97901ZM15.896 3.64601C15.896 4.59001 15.5767 5.38168 14.938 6.02101C14.2987 6.65968 13.5067 6.97901 12.562 6.97901C12.4093 6.97901 12.1977 6.95834 11.927 6.91701C11.6563 6.87501 11.4447 6.83334 11.292 6.79201C11.6527 6.34734 11.9337 5.85768 12.135 5.32301C12.337 4.78834 12.438 4.22934 12.438 3.64601C12.438 3.07668 12.337 2.52468 12.135 1.99001C11.9337 1.45534 11.6527 0.965678 11.292 0.521012C11.5 0.451678 11.7153 0.399678 11.938 0.365012C12.16 0.329678 12.368 0.312012 12.562 0.312012C13.5067 0.312012 14.2987 0.631678 14.938 1.27101C15.5767 1.90968 15.896 2.70134 15.896 3.64601ZM15.917 13.667V11.083C15.917 10.5277 15.7607 9.96168 15.448 9.38501C15.1353 8.80901 14.6667 8.31968 14.042 7.91701C14.778 8.00034 15.4513 8.14268 16.062 8.34401C16.6733 8.54534 17.2567 8.79168 17.812 9.08301C18.326 9.36101 18.6803 9.67368 18.875 10.021C19.0697 10.3683 19.167 10.785 19.167 11.271V13.667H15.917Z" fill="currentColor" /></svg></span> <span class="teachable-enrollment-count-number">' . wp_kses( $data['enrollment_count'], Teachable\teachable_wp_kses() ) . '</span> <span class="teachable-enrollment-count-details">' . esc_html__( 'students enrolled', 'teachable' ) . '</span> </p>';
		} else {
			do_action( 'teachable_frontend_error' );
			return;
		}

		$content = ob_get_clean();

		echo wp_kses( $content, Teachable\teachable_wp_kses() );
	},
	10,
	3
);
