/*

Template:  Jobhelp
Author: author name
Version: 1
Design and Developed by: Devitems

*/
/*================================================
[  Table of contents  ]
================================================
	01. Sticky Menu
	02. Owl Carousel
	03. ScrollUp jquery
	04. wow js active
	05. jQuery MeanMenu
	06. Counter Up
	07. Textilate Activation
	08. Video Player
	09. Mail Chimp
	10. ColorSwitcher

 
======================================
[ End table content ]
======================================*/


(function($) {
    "use strict";
    
/*------------------------------------
    01. Sticky Menu
-------------------------------------- */
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1){  
            $('#sticky-header').addClass("sticky");
        }
        else{
            $('#sticky-header').removeClass("sticky");
        }
    });
    
/*------------------------------------
    02. Owl Carousel
------------------------------------- */
/*------------------------------------
    Testimonial Carousel
------------------------------------- */
	$('.testimonial-carousel').owlCarousel({
		loop:true,
		margin:0,
		nav:true,
		animateOut: 'slideOutDown',
		animateIn: 'zoomInLeft',		
		autoplay:false,
		smartSpeed:3000,
		navText: ["<i class='zmdi zmdi-chevron-left'></i>","<i class='zmdi zmdi-chevron-right'></i>"],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}
	});	
    
/*------------------------------------
    Blog Carousel
-------------------------------------- */
	$('.blog-carousel').owlCarousel({
		loop:true,
        autoPlay: false, 
        smartSpeed: 2000,
        fluidSpeed: true,
		nav:true,
		navText: ["<i class='zmdi zmdi-chevron-left'></i>","<i class='zmdi zmdi-chevron-right'></i>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1 // from 0px up to 479px screen size 
            },
            480:{
                items:1, // from 480 to 677 
            },
            678:{
                items:1, // from this breakpoint 678 to 959
            },
            960:{
                items:2, // from this breakpoint 960 to 1199
            },
            1200:{
                items:3,
                loop:false,
            }
        }        
    }); 
	
/*-------------------------------------------
    03. ScrollUp jquery
--------------------------------------------- */
    $.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });   
    
/*-------------------------------------------
    04. wow js active
--------------------------------------------- */
    new WOW().init();
    
/*-------------------------------------------
    05. jQuery MeanMenu
--------------------------------------------- */
	jQuery('nav#dropdown').meanmenu();
	
/*--------------------------
    06. Counter Up
---------------------------- */	
    $('.counter').counterUp({
        delay: 70,
        time: 5000
    }); 
    
/*------------------------------------
	07. Textilate Activation
--------------------------------------*/
    $('.tlt').textillate({
        loop: true,
        minDisplayTime: 2500
    });
    
/*------------------------------------
	08. Video Player
--------------------------------------*/
    $(".player").YTPlayer({
        showControls: false
    });    
    
    $(".player-small").YTPlayer({
        showControls: true
    });
    
    $(".player-blog").YTPlayer({
        showControls: true
    });
    
/*------------------------------------
	09. Mail Chimp
--------------------------------------*/
    $('#mc-form').ajaxChimp({
        language: 'en',
        callback: mailChimpResponse,
        // ADD YOUR MAILCHIMP URL BELOW HERE!
        url: 'http://themeshaven.us8.list-manage.com/subscribe/post?u=759ce8a8f4f1037e021ba2922&amp;id=a2452237f8'
    });
    
    function mailChimpResponse(resp) {
        
        if (resp.result === 'success') {
            $('.mailchimp-success').html('' + resp.msg).fadeIn(900);
            $('.mailchimp-error').fadeOut(400);
            
        } else if(resp.result === 'error') {
            $('.mailchimp-error').html('' + resp.msg).fadeIn(900);
        }  
    }

    
})(jQuery);