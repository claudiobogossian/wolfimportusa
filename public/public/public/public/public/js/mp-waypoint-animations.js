jQuery(document).ready(function(){"undefined"!==typeof jQuery.fn.waypoint&&(jQuery(".smue-cta.smue-need-animate").waypoint({offset:"85%",handler:function(){this.enabled=!1;var a=jQuery(this.element).data("animation");jQuery(this.element).addClass("smue-animation-"+a);jQuery(this.element).find("[data-animation]").each(function(){var a=jQuery(this).data("animation");jQuery(this).addClass("smue-animation-"+a)})}}),jQuery(".smue-ce-icon-obj.smue-need-animate").waypoint(function(){this.enabled=
!1;var a=jQuery(this.element).attr("data-animation");jQuery(this.element).addClass("smue-animation-"+a)},{offset:"98%"}))});

