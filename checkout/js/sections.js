jQuery(document).ready(function ($) {
    //$(".custom-checkout-page-section").hide();
    $(window).resize(
        debounce(set_up_sections, 500)
    );
    set_up_sections();
    setTimeout(function () {
        set_current_section_height(1);
    }, 1500);

    $(".custom-checkout-page-section-change-button-neighbour").on("click", function (e) {//change section
        e.preventDefault();
        let this_section_number = $(this).data("this-section-number");
        let target_section_number = $(this).data("target-section-number");
        if (this_section_number != target_section_number) {
            change_section(target_section_number, this_section_number - target_section_number);
        }
    });


    $(".custom-checkout-page-section-change-button-any").on("click", function (e) {//change section
        e.preventDefault();

        let current_section_number = get_current_section_number();
        let target_section_number = $(this).data("this-section-number");

        if (current_section_number != target_section_number) {
            change_section(target_section_number, current_section_number - target_section_number);
        }
    });

    $("body").on("swiperight", function () {
        let current_section_number = get_current_section_number();
        let target_section_number = current_section_number - 1;
        change_section(target_section_number, current_section_number - target_section_number);
    });

    $("body").on("swipeleft", function () {
        let current_section_number = get_current_section_number();
        let target_section_number = current_section_number + 1;
        if (4 !== target_section_number) {//dont let user place order by swiping
            change_section(target_section_number, current_section_number - target_section_number);
        }
    });

    $("#ship-to-different-address-checkbox").on("click", function () {
        setTimeout(function () {
            set_current_section_height(2);
        }, 1500);

    });
    $(".showlogin").on("click", function () {
        setTimeout(function () {
            set_current_section_height(1);
        }, 1500);

    });

});

function change_section(target_section_number, direction_distance_multiplier = -1) {
    if (0 == target_section_number) {
        window.location.href = jQuery('#custom-checkout-page-cart-url-container').data("cart-url");
    } else if (4 == target_section_number) {
        jQuery('#place_order').click();
    } else {
        let section_width = jQuery("#custom-checkout-page-sections").width();

        jQuery(".custom-checkout-page-section").each(function () {
            let transformation_value = '+=' + (direction_distance_multiplier * section_width) + 'px';
            jQuery(this).animate({ left: transformation_value });
        });

        set_current_section(target_section_number);
        set_current_section_height(target_section_number);


        //jQuery([document.documentElement, document.body]).animate({
        //scrollTop: jQuery("#custom-checkout-page-"+target_section_number+"-section").offset().top
        //});         
    }
}

function set_up_sections() {
    let section_width = jQuery("#custom-checkout-page-sections").width();
    jQuery(".custom-checkout-page-section").each(function (index) {
        let transformation_value = (index * section_width) + 'px';
        jQuery(this).animate({ left: transformation_value });
    });

    set_current_section(1);
    set_current_section_height(1);
}
function get_current_section_number() {
    return jQuery(".custom-checkout-page-section-change-button-any.current").data("this-section-number")
}
function set_current_section(section_number) {
    jQuery(".custom-checkout-page-section-change-button-any.current>div").removeClass("alt");
    jQuery(".custom-checkout-page-section-change-button-any.current").removeClass("current");
    jQuery("#custom-checkout-page-section-change-button-any-" + section_number + ">div").addClass("alt");
    jQuery("#custom-checkout-page-section-change-button-any-" + section_number).addClass("current");
}
function set_current_section_height(section_number) {
    jQuery("#custom-checkout-page-sections").height(jQuery("#custom-checkout-page-" + section_number + "-section").height());
}
//Underscore.js
function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};