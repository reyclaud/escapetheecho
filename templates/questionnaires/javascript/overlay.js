jQuery(document).ready(function(){
    page = {
        overlay: function () {
            if ($("#overlay-bg").length < 1) {     
                $("body").append("<div id=\"overlay-bg\" />");
                $("body").append("<div id=\"overlay-content-wrap\" />");
                $("#overlay-content-wrap").append("<div id=\"overlay-content-inner-wrap\" />");
                $("#overlay-content-inner-wrap").html($(".rsform-block.rsform-block-briefingpopup .formBody").html());
                $("#overlay-content-inner-wrap").prepend("<div class=\"close-overlay\" onclick=\"questionnaire.closeOverlay();\">[x]</div>");
            }
        }
    };
    
    
    jQuery(".signoff-links a").click(function(event){
        event.preventDefault();
        
        page.overlay();
    });
});


