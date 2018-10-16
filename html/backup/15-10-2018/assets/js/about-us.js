$(document).ready(function(){

	var winWT = $(window).innerWidth();
	

	

	if (winWT >= 1024) {

	}else{
		
		$('#subsidiaries').find('li').addClass('item');

        $('#subsidiaries ul').owlCarousel({
            autoplay: false,
            loop: false,
            items: 3,
            margin: 0,
            stagePadding: 0,
            smartSpeed: 800,
            autoplayTimeout: 5000,
            dots: true,
            navigation: false,
            mouseDrag: true,
            pagination: false,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                680: {
                    items: 3
                }
            }
        });


	}
	

	

});