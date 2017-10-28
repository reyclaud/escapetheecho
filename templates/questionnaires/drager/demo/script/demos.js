$(function () {
    new Dragdealer('demo-simple-slider');

    new Dragdealer('just-a-slider', {
        x: 0.5,
        animationCallback: function (x, y) {
//            $('#just-a-slider .value').text(Math.round((x - 0.5) * 200));

            var dragVal = Math.round((x - 0.5) * 200);

            if (dragVal < 0) {
                $("#just-a-slider").find(".right-drag").css({width: '0%'});
                $("#just-a-slider").find(".left-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider").find(".drag-wrapper-left").css({
//                        backgroundColor : "rgba(1, 138, 29, "+ (Math.abs(dragVal) / 100) +")"
                });

                $("#just-a-slider").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", false);
                $("#just-a-slider").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", true);

            } else {
                $("#just-a-slider").find(".left-drag").css({width: '0%'});
                $("#just-a-slider").find(".right-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider").find(".drag-wrapper-right").css({
//                        backgroundColor : "rgba(1, 138, 29, "+ (Math.abs(dragVal) / 100) +")"
                });

                $("#just-a-slider").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", false);
                $("#just-a-slider").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", true);
            }

            $("#just-a-slider").children(".handle.red-bar").html(Math.abs(dragVal) + '%');

            if (Math.abs(dragVal) > 0) {
                $("#just-a-slider").children(".handle.red-bar").addClass("rated");
            } else {
                $("#just-a-slider").children(".handle.red-bar").removeClass("rated");
            }

            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').css({display: 'inline-block'});
            }


        }
    });

    new Dragdealer('just-a-slider2', {
        x: 0.5,
        animationCallback: function (x, y) {
            var dragVal = Math.round((x - 0.5) * 200);

            if (dragVal < 0) {
                $("#just-a-slider2").find(".right-drag").css({width: '0%'});
                $("#just-a-slider2").find(".left-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider2").find(".drag-wrapper-left").css({});
                
                $("#just-a-slider2").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", false);
                $("#just-a-slider2").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", true);
                
            } else {
                $("#just-a-slider2").find(".left-drag").css({width: '0%'});
                $("#just-a-slider2").find(".right-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider2").find(".drag-wrapper-right").css({});
                
                $("#just-a-slider2").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", true);
                $("#just-a-slider2").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", false);
            }

            $("#just-a-slider2").children(".handle.red-bar").html(Math.abs(dragVal) + '%');

            if (Math.abs(dragVal) > 0) {
                $("#just-a-slider2").children(".handle.red-bar").addClass("rated");
            } else {
                $("#just-a-slider").children(".handle.red-bar").removeClass("rated");
            }

            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').css({display: 'inline-block'});
            }

        }
    });
    new Dragdealer('just-a-slider3', {
        x: 0.5,
        animationCallback: function (x, y) {
            var dragVal = Math.round((x - 0.5) * 200);

            if (dragVal < 0) {
                $("#just-a-slider3").find(".right-drag").css({width: '0%'});
                $("#just-a-slider3").find(".left-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider3").find(".drag-wrapper-left").css({});
                
                $("#just-a-slider3").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", false);
                $("#just-a-slider3").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", true);
            } else {
                $("#just-a-slider3").find(".left-drag").css({width: '0%'});
                $("#just-a-slider3").find(".right-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider3").find(".drag-wrapper-right").css({});
                
                $("#just-a-slider3").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", true);
                $("#just-a-slider3").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", false);
            }

            $("#just-a-slider3").children(".handle.red-bar").html(Math.abs(dragVal) + '%');

            if (Math.abs(dragVal) > 0) {
                $("#just-a-slider3").children(".handle.red-bar").addClass("rated");
            } else {
                $("#just-a-slider").children(".handle.red-bar").removeClass("rated");
            }

            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').css({display: 'inline-block'});
            }
        }
    });
    new Dragdealer('just-a-slider4', {
        x: 0.5,
        animationCallback: function (x, y) {
            var dragVal = Math.round((x - 0.5) * 200);

            if (dragVal < 0) {
                $("#just-a-slider4").find(".right-drag").css({width: '0%'});
                $("#just-a-slider4").find(".left-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider4").find(".drag-wrapper-left").css({});
                
                $("#just-a-slider4").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", false);
                $("#just-a-slider4").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", true);
            } else {
                $("#just-a-slider4").find(".left-drag").css({width: '0%'});
                $("#just-a-slider4").find(".right-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider4").find(".drag-wrapper-right").css({});
                
                $("#just-a-slider4").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", true);
                $("#just-a-slider4").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", false);
            }

            $("#just-a-slider4").children(".handle.red-bar").html(Math.abs(dragVal) + '%');

            if (Math.abs(dragVal) > 0) {
                $("#just-a-slider4").children(".handle.red-bar").addClass("rated");
            } else {
                $("#just-a-slider").children(".handle.red-bar").removeClass("rated");
            }

            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').css({display: 'inline-block'});
            }
        }
    });
    new Dragdealer('just-a-slider5', {
        x: 0.5,
        animationCallback: function (x, y) {
            var dragVal = Math.round((x - 0.5) * 200);

            if (dragVal < 0) {
                $("#just-a-slider5").find(".right-drag").css({width: '0%'});
                $("#just-a-slider5").find(".left-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider5").find(".drag-wrapper-left").css({});
                
                $("#just-a-slider5").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", false);
                $("#just-a-slider5").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", true);
                
            } else {
                $("#just-a-slider5").find(".left-drag").css({width: '0%'});
                $("#just-a-slider5").find(".right-drag").css({width: Math.abs(dragVal) + '%', backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"});

                $("#just-a-slider5").find(".drag-wrapper-right").css({});
                
                $("#just-a-slider5").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", true);
                $("#just-a-slider5").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", false);
            }

            $("#just-a-slider5").children(".handle.red-bar").html(Math.abs(dragVal) + '%');

            if (Math.abs(dragVal) > 0) {
                $("#just-a-slider5").children(".handle.red-bar").addClass("rated");
            } else {
                $("#just-a-slider").children(".handle.red-bar").removeClass("rated");
            }

            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').css({display: 'inline-block'});
            }
        }
    });
    new Dragdealer('just-a-slider6', {
        x: 0.5,
        animationCallback: function (x, y) {
            var dragVal = Math.round((x - 0.5) * 200);

            if (dragVal < 0) {
                $("#just-a-slider6").find(".right-drag").css({width: '0%'});
//                    $("#just-a-slider6").find(".left-drag").css({width: Math.abs(dragVal) + '%'});

                $("#just-a-slider6").find(".drag-wrapper-left").css({
                    backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"
                });
                
                $("#just-a-slider6").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", false);
                $("#just-a-slider6").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", true);
                
            } else {
                $("#just-a-slider6").find(".left-drag").css({width: '0%'});
//                    $("#just-a-slider6").find(".right-drag").css({width: Math.abs(dragVal) + '%'});

                $("#just-a-slider6").find(".drag-wrapper-right").css({
                    backgroundColor: "rgba(1, 138, 29, " + (Math.abs(dragVal) / 100) + ")"
                });
                
                $("#just-a-slider6").siblings(".formControls").find("input[type=checkbox]").last().attr("checked", true);
                $("#just-a-slider6").siblings(".formControls").find("input[type=checkbox]:first-child").attr("checked", false);
            }

            $("#just-a-slider6").children(".handle.red-bar").html(Math.abs(dragVal) + '%');

            if (Math.abs(dragVal) > 0) {
                $("#just-a-slider6").children(".handle.red-bar").addClass("rated");
            } else {
                $("#just-a-slider").children(".handle.red-bar").removeClass("rated");
            }

            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').css({display: 'inline-block'});
            }
        }
    });

    new Dragdealer('lickert', {
        x: 0.5,
        animationCallback: function (x, y) {
            $('#lickert .value').text(Math.round((x - 0.5) * 200));

            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').css({display: 'inline-block'});
            }
        }
    });

    var availHeight = $('.content-body').outerHeight() - $('.content-mask').outerHeight();

    new Dragdealer('content-scroller', {
        horizontal: false,
        vertical: true,
        yPrecision: availHeight,
        animationCallback: function (x, y) {
            $('.content-body').css('margin-top', -y * availHeight);
        }
    });

    var slideToUnlockOld = new Dragdealer('slide-to-unlock-old', {
        steps: 2,
        callback: function (x, y) {
            // Only 0 and 1 are the possible values because of "steps: 2"
            if (x) {
                this.disable();
                $('#slide-to-unlock-old').fadeOut();
                // Bring unlock screen back after a while
                setTimeout(function () {
                    slideToUnlockOld.enable();
                    slideToUnlockOld.setValue(0, 0, true);
                    $('#slide-to-unlock-old').fadeIn();
                }, 5000);
            }
        }
    });

    var slideToUnlockNew = new Dragdealer('slide-to-unlock-new', {
        x: 1,
        steps: 2,
        loose: true,
        callback: function (x, y) {
            // Only 0 and 1 are the possible values because of "steps: 2"
            if (!x) {
                this.disable();
                $('#slide-to-unlock-new').fadeOut();
                // Bring unlock screen back after a while
                setTimeout(function () {
                    slideToUnlockNew.enable();
                    slideToUnlockNew.setValue(1, 0, true);
                    $('#slide-to-unlock-new').fadeIn();
                }, 5000);
            }
        }
    });

    new Dragdealer('image-carousel', {
        steps: 4,
        speed: 0.3,
        loose: true
    });

    var canvasMask = new Dragdealer('canvas-mask', {
        x: 0,
        // Start in the bottom-left corner
        y: 1,
        vertical: true,
        speed: 0.2,
        loose: true
    });
    // Bind event on the wrapper element to prevent it when a drag has been made
    // between mousedown and mouseup (by stopping propagation from handle)
    $('#canvas-mask').on('click', '.menu a', function (e) {
        e.preventDefault();
        var anchor = $(e.currentTarget);
        canvasMask.setValue(anchor.data('x'), anchor.data('y'));
    });
});
