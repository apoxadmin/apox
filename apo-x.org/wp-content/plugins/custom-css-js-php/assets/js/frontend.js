jQuery(document).ready(function(e) {
    e(".overlay-effect[rel='custom_overlay'] .img").mouseenter(function() {
        e(this).addClass("hover");
        target_object = e(this).parent().find(".overlay");
        target_object.css({
            "-webkit-animation-duration": target_object.data("speed") + "s",
            "-moz-animation-duration": target_object.data("speed") + "s",
            "-o-animation-duration": target_object.data("speed") + "s",
            "-animation-duration:": target_object.data("speed") + "s",
            "background-color": target_object.data("color")
        });
        var t = new String(target_object.data("height"));
        h_index = t.indexOf("px");
        if (h_index != -1) height = t;
        else height = t + "%";
        var n = new String(target_object.data("width"));
        w_index = n.indexOf("px");
        if (w_index != -1) width = n;
        else width = n + "%";
        target_object.css({
            height: height,
            width: width
        });
        in_effect = target_object.data("in");
        target_object.removeClass().addClass("overlay").addClass(in_effect + " animated ");
    }).mouseleave(function() {
        out_effect = e(this).parent().find(".overlay").data("out");
        e(this).parent().find(".overlay").removeClass().addClass("overlay").addClass(out_effect + " animated");
    });
});
