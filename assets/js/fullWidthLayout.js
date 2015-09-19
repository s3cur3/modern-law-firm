/* ========================================================================
 * Handles window resizing in the full-width layout.
 * MUST be included in the page <head>!
 * ======================================================================== */

function resizeNoPad() {
    var windowWidth = jQuery(window).width();
    var noPadAndCarousel = jQuery('.container-fluid .pad > .no-pad, .container-fluid .pad > .no-pad > .carousel');
    noPadAndCarousel.width(windowWidth);
    noPadAndCarousel.css('max-width', windowWidth + 'px');

    if( windowWidth > 1920 ) {
        var carousel = jQuery('.container-fluid .pad > .no-pad > .carousel');
        carousel.width(1920);
    } else if( windowWidth <= 1200 ) {
        jQuery('.container-fluid .pad > .no-pad > :not(.carousel)').width(jQuery(window).width() - 90);
    }


    // Fix things that no longer have a fluid container
    jQuery('.container .pad > .no-pad[style], .container .pad > .no-pad > .carousel[style], .container .pad > .no-pad > *[style]').removeAttr('style');
}
(function($) {
    $(document).ready(resizeNoPad);
    $(window).resize(resizeNoPad);
})(jQuery);