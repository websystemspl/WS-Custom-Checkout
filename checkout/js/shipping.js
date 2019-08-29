function getSelectedShippingMethodLabelTextFromCheckedLi() {
    if( 1 == jQuery( '#shipping_method > li').length ) {
        return getSelectedShippingMethodLabelTextFromLi( jQuery( '#shipping_method > li label' ) )
    }

    return getSelectedShippingMethodLabelTextFromLi( jQuery( '#shipping_method > li  [checked]' ).siblings( 'label' ) );
}
function getSelectedShippingMethodLabelTextFromLi( label ) {
    if( label.length ) {
        return label[0].innerHTML;
    } return "";
}
function setSelectedShippingMethodInOrderReviewTable( selectedShippingMethodLabelText ) {
    setTimeout( function( selectedShippingMethodLabelText ) {
        jQuery( "#chosen_shipping_method" ).html(selectedShippingMethodLabelText);
        jQuery('.woocommerce-form-coupon').show();
        jQuery(".wc_payment_methods input").on("click",function() {  
            setTimeout( function() {        
                let current_section_number = get_current_section_number();//this button is being clicked on secion 1 by js
                set_current_section_height( current_section_number ); 
            }, 2500 );//done within a timeaout to avoid being overwritten by woo ajax

        });
    }, 2500, selectedShippingMethodLabelText );//done within a timeaout to avoid being overwritten by woo ajax
}
jQuery( document ).ready(function( $ ) {
    if( $("#shipping_method").length ) {
        setSelectedShippingMethodInOrderReviewTable( getSelectedShippingMethodLabelTextFromCheckedLi() );
        $(document.body).on("update_checkout", function() {       
            setSelectedShippingMethodInOrderReviewTable( getSelectedShippingMethodLabelTextFromCheckedLi() );
        });
        $("#shipping_method > li").on("click", function() {     
            setSelectedShippingMethodInOrderReviewTable( getSelectedShippingMethodLabelTextFromLi( $(this).find( 'label' ) ) );
        });

        $("#woocommerce-form-coupon-button-container>button, #ship-to-different-address-checkbox").on("click", function() {     
            setSelectedShippingMethodInOrderReviewTable( getSelectedShippingMethodLabelTextFromCheckedLi() );    
        });

        $("#billing_country, #shipping_country").on("change", function() {    
            setSelectedShippingMethodInOrderReviewTable( getSelectedShippingMethodLabelTextFromCheckedLi() );
        
        });
    }
});