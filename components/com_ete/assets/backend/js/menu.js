jQuery(document).ready(function () {
    menu = {
        init: function () {

        },
        countLinkReviews: function () {
            jQuery.ajax({
                url: "",
                data: {
                    task: 'backend.countLinkReviews'
                },
                type: "post",
                beforeSend: function () {

                },
                success: function (resp) {
                    jQuery(".item-207").children("a").append("<span class=\"link-review-count\">(" + resp + ")</span>");
                }
            });
        },
        countEmailReviews: function () {
            jQuery.ajax({
                url: "",
                data: {
                    task: 'backend.countEmailReviews'
                },
                type: "post",
                beforeSend: function () {

                },
                success: function (resp) {
                    jQuery(".item-209").children("a").append("<span class=\"link-review-count\">(" + resp + ")</span>");
                }
            });
        },
        countArchives: function(){
            jQuery.ajax({
                url: "",
                data: {
                    task: 'backend.countArchives'
                },
                type: "post",
                beforeSend: function () {

                },
                success: function (resp) {
                    jQuery(".item-210").children("a").append("<span class=\"link-review-count\">(" + resp + ")</span>");
                }
            });
            
        }
    };


    menu.countLinkReviews();
    menu.countEmailReviews();
    menu.countArchives();
});
