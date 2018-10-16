$(document).ready(function () {
    var winWT = $(window).innerWidth();
    // console.log(winWT);

    $('.SliderCon').owlCarousel({
        //animateOut: 'fadeOut',
        loop: false,
        items: 1,
        margin: 0,
        stagePadding: 0,
        smartSpeed: 800,
        autoplayTimeout: 5000,
        dots: true,
        navigation: true,
        mouseDrag: false,
        pagination: false
    });

    setDotOfAddSlider();
    TweenMax.set('.owl-dot img', { scale: 0.8 });
    function setDotOfAddSlider() {
        var dotcount = 1;
        var slidecount = 1;
        var slidegrabLocation;
        var grabMapLeft;
        var grabMapTop;

        $('.owl-item').not('.cloned').each(function () {
            $(this).addClass('slidenumber' + slidecount);
            slidecount = slidecount + 1;
        });

        $('.owl-dot').each(function () {
            $(this).addClass('dotnumber' + dotcount);
            $(this).attr('data-info', dotcount);
            dotcount = dotcount + 1;

            grab = $(this).data('info');
            var currSliderRef = $('.slidenumber' + grab + ' .infoDataCon');
            $(this).prepend('<img src="assets/images/white-pin.png" alt="">');
            
            /*Find Location Attr */
            slidegrabLocation = $(currSliderRef).attr('location');
            $(this).find('span').append(slidegrabLocation);

            /*Find Left Top Attr */

            $(this).bind('click', function(){
                grabMapLeft = $(currSliderRef).attr('leftPoint');
                grabMapTop = $(currSliderRef).attr('topPoint');
                TweenMax.set('.owl-dot img', { scale: 0.8 });
                TweenMax.to($(this).find('img'), 0.5, { scale:1.2, ease: Sine.easeOut });
                TweenMax.to('.mapHolder img', 0.8, { left: grabMapLeft, top: grabMapTop, ease: Sine.easeOut });
            });

        });


        // THIS FINAL BIT CAN BE REMOVED AND OVERRIDEN WITH YOUR OWN CSS OR FUNCTION, I JUST HAVE IT
        // TO MAKE IT ALL NEAT 
        /*amount = $('.owl-dot').length;
        gotowidth = 100 / amount;

        $('.owl-dot').css("width", gotowidth + "%");
        newwidth = $('.owl-dot').width();
        $('.owl-dot').css("height", newwidth + "px");*/

    }

});






