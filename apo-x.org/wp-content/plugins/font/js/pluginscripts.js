// JavaScript Document
jQuery(document).ready(function () {
    clearInterval(documentLoaded);
    // if there's no "draggable" then something's wrong so load provided jquery ui
    initializeFontPlugin();
});
// this won't run unless jquery is completely overwritten by some plugin
var documentLoaded = setInterval(function () {
    if(document.readyState === "complete") {
        alert('Conflict with another plugin which overwrites jQuery');
        // stop checking if the document is laoded
        clearInterval(documentLoaded);
    }
}, 100);

function initializeFontPlugin () {
    /*
    show font plugin browser BUTTON
    */
    jQuery('#FFW_chooseFontButton, #content_FFWButton, #wp-admin-bar-font_settings > a').bind('click', function (e) {
        e.preventDefault();

        //if initialized already just toggle
        if (jQuery('#fontplugin')[0] && jQuery('#fontplugin').data('fontPlugin') && jQuery('#fontplugin').data('fontPlugin').$presets) {
            jQuery('#fontplugin').data('fontPlugin').$presets.fadeToggle(500);
        } else {
            window.onbeforeunload = function () {
                return 'Have you saved the changes?';
            };

            //open jquery plugin
            var fontPluginWrapper = jQuery('<div id="fontplugin" class="draggableModal"></div>'),
                settings;
            fontPluginWrapper.appendTo('body');
            settings = {
                "settingFields": [
                    {
                        "type": "text",
                        "label": "Selector",
                        "name": "selector",
                        "settingType": "general",
                        "settingName": "selector",
                        "extendWith": "selectorPicker"
                    },
                    {
                        "type": "text",
                        "label": "Font size",
                        "name": "font-size",
                        "settingType": "css",
                        "settingName": "fontSize",
                        "extendWith": "slider",
                        "unit": "px"
                    },
                    {
                        "type": "text",
                        "label": "Color",
                        "name": "color",
                        "settingType": "css",
                        "settingName": "color",
                        "extendWith": "colorPicker"
                    }]
            };
            if(!jQuery.fontPlugin) {
                jQuery.fn.fontPlugin = fontPlugin;
            }

            try {
                fontPluginWrapper.fontPlugin(settings);                
            } catch (e) {
                console.dir(e);
                alert('The plugin cannot start because of an error. This is usually caused by a conflict with a poorly written plugin or a theme overwriting jQuery. Try disabling all other plugins and then see if the "Font" plugin works. If that works, enable them one by one to find the one, which is causing the conflict. If nothing helps copy this error and send to the plugin author: ' + e);
            }
        }
        return false;
    });
    
    // extend with object size
    if(!Object.size) {
        Object.size = function(obj) {
            var size = 0, key;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size;
        };
    }
    //make image colorpickable
    /*function makeImagesColorpickable() {
        var image = jQuery("#header1preview").contents().find('img');
        jQuery("#header1preview").contents().find('a').click(function () {
            return false;
        });
        image.click(function (e) {
            var img = new Image(),
                canvas,
                context,
                posX,
                posY,
                x,
                y,
                data,
                color;
            img.src = jQuery(this).attr('src');
            canvas = jQuery('<canvas id="canvas" style="display:none"></canvas>');
            canvas[0].setAttribute('width', jQuery(this).width());
            canvas[0].setAttribute('height', jQuery(this).height());
            jQuery('body').append(canvas);
            context = document.getElementById('canvas').getContext('2d');
            context.drawImage(img, 0, 0);
            posX = jQuery(this).offset().left;
            posY = jQuery(this).offset().top;
            x = Math.round(e.pageX - posX);
            y = Math.round(e.pageY - posY);
            data = context.getImageData(x, y, 1, 1).data;
            color = dec2html(data[0]) + dec2html(data[1]) + dec2html(data[2]);
            ffwSetFontColor('#' + color);
            return false;
        });
        //calculating functions
        function dec2html(d) {
            // Converts from decimal color value (0-255) to HTML-style (00-FF)
            var hch = "0123456789ABCDEF",
                a = d % 16,
                b = (d - a) / 16;
            return hch.charAt(b) + hch.charAt(a);
        }
    }*/
    // Escape regex chars with \
    RegExp.escapeX = function (text) {
        return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
    };
    // The style function
    jQuery.fn.style = function (styleName, value, priority) {
        //console.log(styleName + ' - ' + value + ' - ' + priority);
        var node,
            style;
        // For those who need them (< IE 9), add support for CSS functions
        if (!CSSStyleDeclaration.prototype.getPropertyValue || !CSSStyleDeclaration.prototype.setProperty) {
            CSSStyleDeclaration.prototype.getPropertyValue = function (a) {
                return this.getAttribute(a);
            };
            CSSStyleDeclaration.prototype.setProperty = function (styleName, value, priority) {
                var rule;
                priority = typeof priority !== undefined ? priority : '';
                this.setAttribute(styleName, value);
                if (priority !== '') {
                    // Add priority manually
                    rule = new RegExp(RegExp.escapeX(styleName) + '\\s*:\\s*' + RegExp.escapeX(value) + '(\\s*;)?', 'gmi');
                    this.cssText = this.cssText.replace(rule, styleName + ': ' + value + ' !' + priority + ';');
                }
            };
            CSSStyleDeclaration.prototype.removeProperty = function (a) {
                return this.removeAttribute(a);
            };
            CSSStyleDeclaration.prototype.getPropertyPriority = function (styleName) {
                var rule = new RegExp(RegExp.escapeX(styleName) + '\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?', 'gmi');
                return rule.test(this.cssText) ? 'important' : '';
            };
        }
        function camelToDash(str) {
            return str.replace(/\W+/g, '-')
                .replace(/([a-z\d])([A-Z])/g, '$1-$2');
        }
        styleName = camelToDash(styleName);
        // DOM node
        node = this.get(0);
        // Ensure we have a DOM node
        if (typeof node === 'undefined') {
            return;
        }
        // CSSStyleDeclaration
        style = this.get(0).style;
        // Getter/Setter
        if (styleName !== undefined) {
            if (value !== undefined) {
                // Set style property
                priority = priority !== undefined ? priority : '';
                //console.log(styleName + ', ' + value + ', ' + priority)
                style.setProperty(styleName, value, priority);
            } else {
                // Get style property
                return style.getPropertyValue(styleName);
            }
        } else {
            // Get CSSStyleDeclaration
            return style;
        }
    };
    if(!jQuery.fn.inlineStyle) {
        jQuery.fn.inlineStyle = function (prop) {
            return this.prop("style")[jQuery.camelCase(prop)];
        };
    }
    (function ($) {
        $.fn.removePrefixedClasses = function (prefix) {
            if(!$(this).attr('class')) return;
            var classNames = $(this).attr('class').split(' '),
                className,
                newClassNames = [],
                i;
            //loop class names
            for(i = 0; i < classNames.length; i++) {
                className = classNames[i];
                // if prefix not found at the beggining of class name
                if(className.indexOf(prefix) !== 0) {
                    newClassNames.push(className);
                    continue;
                }
            }
            // write new list excluding filtered classNames
            $(this).attr('class', newClassNames.join(' '));
        };
    }(jQuery));
    
    if(!jQuery.fn.animateRotate) {
        jQuery.fn.animateRotate = function(angle, duration, easing, complete) {
            return this.each(function() {
                var $elem = jQuery(this);
                var currentRotationAngle = $elem.data('rotation');
                if(currentRotationAngle === undefined) {
                    currentRotationAngle = 0;
                }
                $elem.data('rotation', angle);

                jQuery({deg: currentRotationAngle}).animate({deg: angle}, {
                    duration: duration,
                    easing: easing,
                    step: function(now) {
                        
                        $elem.css({
                            transform: 'rotate(' + now + 'deg)'
                        });
                    },
                    complete: complete || jQuery.noop
                });
            });
        };
    }
}