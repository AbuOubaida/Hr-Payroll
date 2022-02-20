(function ($) {
 "use strict";
    
    //---------------------------------------------
    //Nivo slider
    //---------------------------------------------
    $('#nivoslider').nivoSlider({
        effect: 'random',
        slices: 15,
        boxCols: 10,
        boxRows: 10,
        animSpeed: 500,
        pauseTime: 5000,
        startSlide: 0,
        directionNav: true,
        controlNavThumbs: false,
        prevText: '<i class="zmdi zmdi-long-arrow-left"></i> <br /> PREV',
        nextText: '<i class="zmdi zmdi-long-arrow-right"></i> <br /> NEXT', 
        pauseOnHover: false,
        manualAdvance: false
    });
})(jQuery); 