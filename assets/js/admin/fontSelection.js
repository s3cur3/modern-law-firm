(function($) {
    var fontList = {};

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

    /**
     * See if an array of strings contains a particular substring
     * @param search {string}
     * @returns {boolean}
     */
    Array.prototype.contains = function(search) {
        for( var i = 0; i < this.length; i++ ) {
            if( this[i].contains(search) ) {
                return true;
            }
        }
        return false;
    };

    Array.prototype.containsExactly = function(search) {
        return this.indexOf(search) > -1;
    };

    function sizeOf( obj ) {
        var size = 0;
        var key;
        for( key in obj ) {
            if( obj.hasOwnProperty(key) ) size++;
        }
        return size;
    }


    function loadFonts() {
        WebFontConfig = {
            google: { families: [ 'Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800:latin', 'Raleway:200:latin', 'Roboto:100,100italic,500,500italic,900,900italic:latin' ] }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    }

    function getFontVariantFromLongID(stringIdentifier) {
        var weight = stringIdentifier.replace(/[^0-9]/g, '');
        var italic = stringIdentifier.contains('italic');
        return weight.toString() + (italic ? "italic" : '');
    }

    /**
     * Updates the available variants for the selected font family.
     * @param fontSelect jQuery object for the font <select>
     * @param variantList jQuery object for the section containing the checkboxes
     */
    function updateFont(fontSelect, variantList) {
        function loadFontFromGoogle(fontID) {
            if( typeof WebFont != 'undefined' ) {
                WebFont.load({
                    google: {
                        families: [fontID]
                    }
                });
            } else {
                setTimeout(function(){
                    loadFontFromGoogle(fontID)
                }, 500);
            }
        }

        function getFontData(fontName) {
            for( var i = 0; i < fontList.length; i++ ) {
                if( fontList[i].family == fontName ) {
                    return fontList[i];
                }
            }
            return {};
        }
        
        function getVariants(fontData) {
            var availableVariants = fontData.variants;
            for( var j = 0; j < availableVariants.length; j++ ) {
                if( availableVariants[j] == "regular" ) {
                    availableVariants[j] = "400";
                } else if( availableVariants[j] == "italic" ) {
                    availableVariants[j] = "400italic";
                }
            }
            return availableVariants;
        }
        
        
        

        var fontID = fontSelect.val();
        var fontName = fontSelect.find(":selected").text();

        loadFontFromGoogle(fontID);
        var crntFontData = getFontData(fontName);

        if( sizeOf(crntFontData) > 0 ) {
            var availableVariants = getVariants(crntFontData);

            // Hide all unavailable variants
            var variantLabels = variantList.find('label');
            variantLabels.each(function() {
                var thisVariant = getFontVariantFromLongID( $(this).attr('for') );


                console.log(fontName + " variants contains " + thisVariant + " ?");
                console.log(availableVariants.containsExactly(thisVariant));
                console.log("Available variants: ");
                console.log(availableVariants);
                if( availableVariants.containsExactly(thisVariant) ) {
                    $(this).show();
                    $(this).prev().show();
                    $(this).css('font-family', '"' + fontName + '"');
                } else {
                    $(this).hide();
                    $(this).prev().hide();
                }
            });
        } else {
            console.error("Unknown font " + fontName);
        }
    }

    $(document).ready(function () {
        if( window.location.href.contains('page=options-framework') ) {
            var prefix = "the_modern_law_firm-";
            var fontLocations = ['title', 'heading', 'widget_title', 'body'];
            var variants = [
                '100', '100italic',
                '200', '200italic',
                '300', '300italic',
                '400', '400italic',
                '600', '600italic',
                '700', '700italic',
                '800', '800italic',
                '900', '900italic'
            ];

            $.getJSON(templateURL + '/assets/js/admin/googleFontsJSON.php', {},
                function( allFonts ) {
                    fontList = allFonts.items;
                    var fontSelectIDs = [];
                    for( var i = 0; i < fontLocations.length; i++ ) {
                        loc = fontLocations[i];

                        // Set up weights and styles
                        $("#section-" + loc + "_font_variants .controls label").each(function() {
                            var name = $(this).text();
                            var weight = name.replace(/[^0-9]/g, '');
                            var italic = name.contains('italic');

                            $(this).css({
                                'font-size': '16px',
                                'margin-bottom': '10px',
                                'font-weight': weight,
                                'font-style': (italic ? "italic" : "normal")
                            })
                        });

                        // Perform the initial font load
                        updateFont( $('#' + loc + '_font_family'), $('#section-' + loc + '_font_variants') );

                        // Monitor for changes to the font selection
                        $('#' + loc + '_font_family').change(function() {
                            updateFont( $(this), $(this).parent().parent().parent().next() );
                        });
                    }
                }
            );
            loadFonts();
        }
    } );
})(jQuery);