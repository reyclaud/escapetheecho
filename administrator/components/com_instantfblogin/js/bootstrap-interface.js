jQuery(function(c){c("#updatestatus label.hasPopover").popover({trigger:"hover",placement:"right",html:1});c("label.hasPopover, button.hasPopover, div.hasPopover, span.hasPopover, img.hasPopover").popover({trigger:"hover",placement:"top",html:1});c("label.hasTooltip, img.hasTooltip, a.hasTooltip, span.hasTooltip, a.hasTip").tooltip({trigger:"hover",placement:"top"});var d={instantfblogin_accordion_cpanel:"instantfblogin_stats"};c("div.accordion").on("shown.bs.collapse",function(e){if(!c(e.target).hasClass("accordion-body")){return}e.stopPropagation();c("div.accordion-heading").removeClass("opened");var f=c.jStorage.get("instantfbloginAccordionOpened",d);f[this.id]=e.target.id;c.jStorage.set("instantfbloginAccordionOpened",f);if(document.body.scrollHeight>window.innerHeight){c("html, body").animate({scrollTop:parseInt(c("#"+e.target.id).prev().offset().top)-200},500)}c(e.target).prev().addClass("opened")});c.each(c.jStorage.get("instantfbloginAccordionOpened",d),function(f,e){if(c("#"+e,"#"+f).length){c("#"+e,"#"+f).addClass("in").prev().addClass("opened")}});c("label.hasTip").each(function(h,f){var g=c(f).attr("title");var e=g.replace("::"," - ");c(f).attr("title",e);c(f).tooltip({trigger:"hover",placement:"top"})});var b={tab_configuration:"setup"};c(".nav.nav-tabs").on("shown.bs.tab",function(e){var f=c.jStorage.get("instantfbloginTabOpened",b);f[this.id]=c(e.target).data("element");c.jStorage.set("instantfbloginTabOpened",f)});var a=window.location.hash.substr(2);if(a){c("a[data-element="+a+"]").tab("show")}if(a=="licensepreferences"){c("a[data-element=setup]").tab("show");c("#params_registration_email-lbl").css("color","red");c("#params_registration_email").css("border","2px solid red")}c.each(c.jStorage.get("instantfbloginTabOpened",b),function(f,e){c("a[data-element="+e+"]","#"+f).tab("show")});c("#params_template").css({width:"150px"}).on("change",function(f){var e=c(this).val();c(this).next("div").remove();c("<img/>").insertAfter(this).attr("src",instantfbloginBaseURI+"modules/mod_instantfblogin/assets/images/fbk"+e+".png").wrap('<div class="tmpl_wrapper">')}).trigger("change");c("#params_gplus_template").css({width:"150px"}).on("change",function(f){var e=c(this).val();c(this).next("div").remove();c("<img/>").insertAfter(this).attr("src",instantfbloginBaseURI+"modules/mod_instantfblogin/assets/images/gplus"+e+".png").wrap('<div class="tmpl_wrapper">')}).trigger("change");c("#params_twitter_template").css({width:"150px"}).on("change",function(f){var e=c(this).val();c(this).next("div").remove();c("<img/>").insertAfter(this).attr("src",instantfbloginBaseURI+"modules/mod_instantfblogin/assets/images/twt"+e+".png").wrap('<div class="tmpl_wrapper">')}).trigger("change");c("#params_linkedin_template").css({width:"150px"}).on("change",function(f){var e=c(this).val();c(this).next("div").remove();c("<img/>").insertAfter(this).attr("src",instantfbloginBaseURI+"modules/mod_instantfblogin/assets/images/lkin"+e+".png").wrap('<div class="tmpl_wrapper">')}).trigger("change")});