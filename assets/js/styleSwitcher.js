(function($) {
    /**
     * Checks to see whether this string contains the sought substring (or substrings).
     * @param search {string|Array} If search is a string, we will see if it is a substring of this string. If search
     *                              is an array of strings, we will see if any of those strings are substrings of this.
     * @returns {boolean} True if this string contains the searched string(s).
     */
    String.prototype.contains = function(search) {
        if( typeof search == "string" ) {
            return this.indexOf(search) > -1;
        } else if( search instanceof Array ) {
            for( var i = 0; i < search.length; i++ ) {
                if( this.indexOf(search[i]) > -1 ) {
                    return true;
                }
            }
            return false;
        }
        return false;
    };

    $(document).ready(function () {
        function changeBG(selectedBackground) {
            function resetBackgroundCSS(jQueryDiv) {
                jQueryDiv.css({
                    "background": "transparent",
                    "background-image": "initial",
                    "background-repeat": "initial",
                    "background-position": "initial",
                    "-webkit-background-size": "initial",
                    "-moz-background-size": "initial",
                    "-o-background-size": "initial",
                    "background-size": "initial"
                });
            }

            if( typeof selectedBackground !== "string" ) selectedBackground = $('#background').val();

            var body = $('body');
            resetBackgroundCSS(body);

            if( selectedBackground == 'white' ) {
                body.css('background', "#ffffff");
            } else if( selectedBackground == 'pattern' ) {
                body.css({
                    'background-image': "url('" + templateURL + "/assets/img/patterns/sos.png')",
                    "background-repeat": "repeat",
                    "background-position": "center center"
                });
            } else if( selectedBackground == 'image' ) {
                body.css({
                    "background": "url('" + templateURL + "/assets/img/sample-full-page-bg.jpg') no-repeat center center fixed",
                    "-webkit-background-size": "cover",
                    "-moz-background-size": "cover",
                    "-o-background-size": "cover",
                    "background-size": "cover"
                });
            }

            var bg = $("#background");
            bg.val(selectedBackground);
            setAllLinks(null, $('#layout').val(), bg.val());
        }

        function changeLayout(specifiedLayout) {
            var layoutDiv = $('#layout');
            var layoutStr = layoutDiv.val();
            if( typeof specifiedLayout == "string" ) layoutStr = specifiedLayout;

            var wrap = $('div.wrap');
            if( layoutStr == 'normal' ) {
                wrap.addClass('container');
                wrap.removeClass('container-fluid');
                wrap.removeClass('pseudo-fluid');
                wrap.css("background", "transparent");
                changeBG();
                bgSelectContainer.show();
            } else {
                wrap.addClass('container-fluid');
                wrap.addClass('pseudo-fluid');
                wrap.removeClass('container');
                wrap.css("background", "#ffffff");
                $('body').css("background", "#ffffff");
                bgSelectContainer.hide();
            }
            resizeNoPad();
            layoutDiv.val(layoutStr);

            setAllLinks(null, layoutStr, bgSelect.val());
        }


        function getURLParameter(name) {
            return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
        }

        function setAllLinks(overrideColorTheme, overrideLayout, overrideBG) {
            function appendToQueryString(key, value, queryString) {
                if( typeof value == "string" && typeof key == "string" ) {
                    var combiner = queryString.match(/\?/) ? '&' : '?';
                    return queryString + combiner + key + "=" + value;
                }
                return queryString;
            }

            var colorTheme = getURLParameter('color');
            var layout = getURLParameter('layout');
            var bg = getURLParameter('bg');

            if( overrideColorTheme ) {
                colorTheme = overrideColorTheme;
            }
            if( overrideLayout ) {
                layout = overrideLayout;
            }
            if( overrideBG ) {
                bg = overrideBG;
            }

            if( colorTheme || layout || bg ) {
                var queryString = "";
                queryString = appendToQueryString('color', colorTheme, queryString);
                queryString = appendToQueryString('layout', layout, queryString);
                queryString = appendToQueryString('bg', bg, queryString);

                $('a').each(function() {
                    var href = $(this).attr('href');

                    if( href && !$(this).hasClass('no-color-link') && !(href.indexOf('#') > -1) ) {
                        href = href.replace(/\?.*/, '');

                        href += queryString;
                        $(this).attr('href', href);
                    }
                });
            }
        }

        setAllLinks();

        var body = $('body');

        // Set up the background selector
        var bgSelectContainer = $("#background-select-container");
        var bgSelect = bgSelectContainer.find('#background');
        if( body.css('background-image').contains('patterns') ) {
            bgSelect.val('pattern');
        } else if( body.css('background-image').contains('url') ) {
            bgSelect.val('image');
        } else {
            bgSelect.val('white');
        }

        var specifiedBG = getURLParameter('bg');
        if( specifiedBG ) changeBG(specifiedBG);

        bgSelect.change(changeBG);

        // Preload the full-screen bg image
        $("#imgPreload").hide().css("background", "url('" + templateURL + "/assets/img/sample-full-page-bg.jpg') no-repeat center center fixed");



        var wrap = $('div.wrap');
        var layoutSelect = $('#layout');
        if( wrap.hasClass('container-fluid') ) {
            layoutSelect.val('full');
            console.log("set layout to full");
            wrap.css("background", "#ffffff");
            bgSelectContainer.hide();
        } else {
            layoutSelect.val('normal');
            bgSelectContainer.show();
        }

        var specifiedLayout = getURLParameter('layout');
        if( specifiedLayout ) changeLayout(specifiedLayout);

        layoutSelect.change(changeLayout);
    });
})(jQuery);
