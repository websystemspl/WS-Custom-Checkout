<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$sections = [ [ 'name' => 'cart', 'label' => esc_html__( 'Cart', 'woocommerce' ) ], [ 'name' => 'info', 'label' => esc_html__( 'Information', 'ws-custom-checkout' ) ], [ 'name' => 'shipping', 'label' => esc_html__( 'Shipping', 'woocommerce' ) ], [ 'name' => 'payment', 'label' => esc_html__( 'Payment', 'woocommerce' ) ], [ 'name' => 'complete', 'label' => esc_html__( 'Complete', 'ws-custom-checkout' )] ]; 
$counter_for_preserving_section_names = 1;



do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<span id="custom-checkout-page-cart-url-container" data-cart-url="<?php echo esc_attr(wc_get_cart_url()); ?>"></span>
<div id="custom-checkout-page-section-button-containers-container">
	<div data-this-section-number="0" class="custom-checkout-page-section-button-container custom-checkout-page-section-change-button-any">
		<div class="button custom-checkout-page-section-button-number">1</div>
		<span class="custom-checkout-page-section-button-label"><?php echo esc_html($sections[ 0 ][ 'label' ]) ?></span>
	</div>
	<?php for( $i = 1; $i < count( $sections ) - 1; $i++ ) : ?>
		<div id="custom-checkout-page-section-change-button-any-<?php echo esc_attr($i); ?>" class="custom-checkout-page-section-button-container custom-checkout-page-section-change-button-any" data-this-section-number="<?php echo esc_attr($i);  ?>">
			<div class="button custom-checkout-page-section-button-number"><?php echo esc_attr($i+1);  ?></div>
			<span class="custom-checkout-page-section-button-label"><?php echo esc_html($sections[ $i ][ 'label' ]) ?></span>
		</div>
	<?php endfor; ?>	
	<div class="custom-checkout-page-section-button-container" id="custom-checkout-page-section-complete-button-container">
		<div class="button custom-checkout-page-section-button-number">5</div>
		<span class="custom-checkout-page-section-button-label"><?php echo esc_html($sections[ count( $sections ) - 1 ][ 'label' ]) ?></span>
	</div>
</div>
<div id="custom-checkout-page-form-container">
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<div id="custom-checkout-page-sections">
			<section id="custom-checkout-page-<?php echo esc_attr($counter_for_preserving_section_names); ?>-section" class="custom-checkout-page-section">
				<h2><?php echo esc_html($sections[ $counter_for_preserving_section_names ][ 'label' ]); ?></h2>
				<?php if ( ! is_user_logged_in() && 'no' !== get_option( 'woocommerce_enable_checkout_login_reminder' ) ): //from form-login.php?>
					<div class="woocommerce-form-login-toggle">
						<?php wc_print_notice( apply_filters( 'woocommerce_checkout_login_message', __( 'Returning customer?', 'woocommerce' ) ) . ' <a href="#" class="showlogin">' . __( 'Click here to login', 'woocommerce' ) . '</a>', 'notice' ); ?>
					</div>
				<?php endif;?>
				<div>
					<?php if ( $checkout->get_checkout_fields() ) : ?>

						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

						<div id="customer_details">
							<div>
								<?php do_action( 'woocommerce_checkout_billing' ); ?>
							</div>					
						</div>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>
					<div class="section-change-buttons-container">
						<?php
                        $target_section_number = 0;
                        $section_label = __( 'Cart', 'woocommerce' );
                        $direction = 'previous';
                        $button_inner_html = sprintf(esc_html__( "Go to %s", 'ws-custom-checkout' ), esc_html($section_label));
                        if( 'next' == $direction ) {
                            $button_inner_html .= '&nbsp;&rarr;';
                            $this_section_number = $target_section_number - 1;
                        } else {//previous
                            $button_inner_html = '&larr;&nbsp;' . $button_inner_html;
                            $this_section_number = $target_section_number + 1;
                        }
                        echo '<button class="button custom-checkout-page-section-change-button-neighbour" data-this-section-number="'. esc_attr($this_section_number) . '" data-target-section-number="' . esc_attr($target_section_number) . '">' . esc_attr($button_inner_html) . '</button>';
                        ?>
						<?php
                        $target_section_number = $counter_for_preserving_section_names + 1;
                        $section_label = $sections[ $counter_for_preserving_section_names + 1 ]['label'];
                        $direction = 'next';
                        $button_inner_html = sprintf(esc_html__( "Go to %s", 'ws-custom-checkout' ), esc_html($section_label));
                        if( 'next' == $direction ) {
                            $button_inner_html .= '&nbsp;&rarr;';
                            $this_section_number = $target_section_number - 1;
                        } else {//previous
                            $button_inner_html = '&larr;&nbsp;' . $button_inner_html;
                            $this_section_number = $target_section_number + 1;
                        }
                        echo '<button class="button custom-checkout-page-section-change-button-neighbour" data-this-section-number="'. esc_attr($this_section_number) . '" data-target-section-number="' . esc_attr($target_section_number) . '">' . esc_attr($button_inner_html) . '</button>';
                        ?>
					</div>
				</div>
				<?php $counter_for_preserving_section_names++; ?>
			</section>
			<section id="custom-checkout-page-<?php echo esc_attr($counter_for_preserving_section_names); ?>-section" class="custom-checkout-page-section">
				<h2><?php echo esc_html($sections[ $counter_for_preserving_section_names ][ 'label' ]); ?></h2>
				<div>
					<?php //from <div id="customer_details">?>
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>

					<?php //from review-order.php?>
					<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

						<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

						<?php wc_cart_totals_shipping_html(); ?>

						<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

					<?php endif; ?>

					<div class="section-change-buttons-container">
						<?php
                        $target_section_number = $counter_for_preserving_section_names - 1;
                        $section_label = $sections[ $counter_for_preserving_section_names - 1 ]['label'];
                        $direction = 'previous';
                        $button_inner_html = sprintf(esc_html__( "Go to %s", 'ws-custom-checkout' ), esc_html($section_label));
                        if( 'next' == $direction ) {
                            $button_inner_html .= '&nbsp;&rarr;';
                            $this_section_number = $target_section_number - 1;
                        } else {//previous
                            $button_inner_html = '&larr;&nbsp;' . $button_inner_html;
                            $this_section_number = $target_section_number + 1;
                        }
                        echo '<button class="button custom-checkout-page-section-change-button-neighbour" data-this-section-number="'. esc_attr($this_section_number) . '" data-target-section-number="' . esc_attr($target_section_number) . '">' . esc_attr($button_inner_html) . '</button>';
                        ?>
						<?php
                        $target_section_number = $counter_for_preserving_section_names + 1;
                        $section_label = $sections[ $counter_for_preserving_section_names + 1 ]['label'];
                        $direction = 'next';
                        $button_inner_html = sprintf(esc_html__( "Go to %s", 'ws-custom-checkout' ), esc_html($section_label));
                        if( 'next' == $direction ) {
                            $button_inner_html .= '&nbsp;&rarr;';
                            $this_section_number = $target_section_number - 1;
                        } else {//previous
                            $button_inner_html = '&larr;&nbsp;' . $button_inner_html;
                            $this_section_number = $target_section_number + 1;
                        }
                        echo '<button class="button custom-checkout-page-section-change-button-neighbour" data-this-section-number="'. esc_attr($this_section_number) . '" data-target-section-number="' . esc_attr($target_section_number) . '">' . esc_attr($button_inner_html) . '</button>';
                        ?>
					</div>
				</div>
				<?php $counter_for_preserving_section_names++; ?>
			</section>
			<section id="custom-checkout-page-<?php echo esc_attr($counter_for_preserving_section_names); ?>-section" class="custom-checkout-page-section">
				<h2><?php echo esc_html($sections[ $counter_for_preserving_section_names ][ 'label' ]); ?></h2>
				<div>
					<?php //payment method and buy-button from add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );?>
					<?php woocommerce_checkout_payment(); ?>
					
					<div class="section-change-buttons-container">
						<?php                     
                        $target_section_number = $counter_for_preserving_section_names - 1;
                        $section_label = $sections[ $counter_for_preserving_section_names - 1 ]['label'];
                        $direction = 'previous';
                        $button_inner_html = sprintf(esc_html__( "Go to %s", 'ws-custom-checkout' ), esc_html($section_label));
                        if( 'next' == $direction ) {
                            $button_inner_html .= '&nbsp;&rarr;';
                            $this_section_number = $target_section_number - 1;
                        } else {//previous
                            $button_inner_html = '&larr;&nbsp;' . $button_inner_html;
                            $this_section_number = $target_section_number + 1;
                        }
                        echo '<button class="button custom-checkout-page-section-change-button-neighbour" data-this-section-number="'. esc_attr($this_section_number) . '" data-target-section-number="' . esc_attr($target_section_number) . '">' . esc_attr($button_inner_html) . '</button>';
                        ?>
					</div>
				</div>
			</section>
		</div>

	</form>
	<div id="custom-checkout-page-order-review">
		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

		<?php woocommerce_checkout_coupon_form(); ?>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>
</div>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>