jQuery(document).ready(function(){
    jQuery(".settings-tabs a:first-child").addClass("active");
    jQuery(".settings-tabs > a").on("click", function(){
        jQuery(".settings-tabs > a").removeClass("active");
        jQuery(this).addClass("active");
       let section = jQuery(this).attr("href");
       jQuery("#settings-container form div").each(function(){
        jQuery(this).removeClass("active");
       });
       jQuery(section).addClass("active");
    })
})
