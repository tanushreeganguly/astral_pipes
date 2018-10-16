$(document).ready(function () {
    var winWT = $(window).innerWidth();
    // console.log(winWT);

    $('.slider_holder').owlCarousel({
        //animateOut: 'fadeOut',
        loop: false,
        items: 1,
        margin: 0,
        stagePadding: 0,
        smartSpeed: 800,
        autoplayTimeout: 5000,
        dots: true,
        navigation: true,
        mouseDrag: true,
        pagination: false
    });

    setDotOfAddSlider();

    function setDotOfAddSlider() {
        var dotcount = 1;

        var slidecount = 1;

        $('.owl-item').not('.cloned').each(function () {
            $(this).addClass('slidenumber' + slidecount);
            slidecount = slidecount + 1;
        });

        $('.owl-dot').each(function () {
            

            $(this).addClass('dotnumber' + dotcount);
            $(this).attr('data-info', dotcount);
            dotcount = dotcount + 1;

            grab = $(this).data('info');
            $(this).prepend('<img src="assets/images/white-pin.png" alt="">');
            var slidegrab = $('.slidenumber' + grab + ' img').attr('location');
            $(this).find('span').append(slidegrab);
            console.log(slidegrab);

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






