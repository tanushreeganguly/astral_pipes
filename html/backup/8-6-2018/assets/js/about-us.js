$(document).ready(function(){

	var winWT = $(window).innerWidth();
	var pointers = $('.pointers');
	var tlIntro = new TimelineLite();
	var tl = new TimelineLite();
	var tl_abt = new TimelineLite();
	var tl_why = new TimelineLite();
	var tl_message = new TimelineLite();
	

	function loadBanners(){
		var preLoadImagesArray = $('.about_con [imgLoad]');
	    var loadedCount = 0;
	    function loadImages(i){
	      var src = $(preLoadImagesArray[i]).attr('src');
	      var newImg = new Image();
	      newImg.onload = function(){
	        loadedCount++;
	        if(loadedCount == preLoadImagesArray.length){
	          desktopAnim();
	        }
	      };
	      newImg.src = src;
	    }
	    for(var i = 0; i < preLoadImagesArray.length; i++){
	      loadImages(i);
	    }
	}

	if (winWT >= 1024) {
		loadBanners();
	}else{
		var flagArr = $('.pointers .flag');
		var addressArr = $('.add_con');
		$(addressArr[0]).css({'display':'block'});

		function showPlantsOnMob(i){
			var currFlag = flagArr[i];
			$(currFlag).bind('click', function(){
				var clickedAddress = addressArr[i];
				$(addressArr).css({'display':'none'});
				$(clickedAddress).fadeIn();
			});
		}

		for (var i = 0; i<flagArr.length; i++) {
			showPlantsOnMob(i);
		}

		$('.plants_india').owlCarousel({
	        autoplay: false,
	        loop: false,
	        items: 1,
	        margin: 0,
	        stagePadding: 0,
	        smartSpeed: 1300,
	        autoplayTimeout:8000,
	        dots: true,
	        navigation: false,
	        mouseDrag: true,
	        pagination: false
	    });

	    $('.plants_india').find('.add_pan').addClass('item');


	}
	

	function desktopAnim(){
		TweenMax.set('.map_slice', {scale:0.7, opacity:0, scale:0.5});
		TweenMax.set('.pin', {top:'15px', opacity:0, scale:0.5});
		TweenMax.set('.base', {scale:0.5, opacity:0});
		TweenMax.set('.line span', {height:0});
		TweenMax.set('.flag', {opacity:0, scale:0.8});
		TweenMax.set('.add_con', {opacity:0, y:20});
		TweenMax.set('.about_con p', {opacity:0, y:20});
		TweenMax.set('.shadow', {opacity:0});
		TweenMax.set('.profile_message p', {opacity:0, y:30});

		var scrollMagicController =  new ScrollMagic.Controller();

		tl_abt.staggerTo('.banner_abt li', 0.6, { height:0, ease:Sine.easeInOut}, 0.1)
			  .to('.abt_ast p', 0.6, {opacity:1, y:0, ease:Sine.easeInOut})
			  .to('.abt_ast .shadow', 0.6, {opacity:0.5, ease:Sine.easeInOut});

		tl_why.staggerTo('.banner_why li', 0.6, { height:0, ease:Sine.easeInOut}, 0.1)
			  .staggerTo('.abt_why p', 0.6, {opacity:1, y:0, ease:Sine.easeInOut},0.1)
			  .to('.abt_why .shadow', 0.6, {opacity:0.5, ease:Sine.easeInOut});

		tl_message.staggerTo('.profile_frame li', 0.6, { height:0, ease:Sine.easeInOut}, 0.1)
				  .staggerTo('.profile_message p', 0.8, {opacity:1, y:0, ease:Sine.easeInOut},0.2,'-=0.5')

		tlIntro.staggerTo('.map_slice', 0.6, {opacity:1, scale:1, ease:Sine.easeInOut}, 0.2)
			   .staggerTo('.pin', 0.5, {opacity:1, scale:1, ease:Sine.easeInOut}, 0.1)
			   .to('.ind_loc .pin', 0.3, {opacity:1, top:'0', ease:Sine.easeInOut},'pin')
			   .to('.ind_loc .base', 0.3, {opacity:'1', scale:1, ease:Sine.easeInOut},'pin')
			   .to('.ind_loc span', 0.3, {height:'100%', ease:Sine.easeInOut})
			   .to('.ind_loc .flag', 0.3, {opacity:1, scale:1, ease:Sine.easeInOut}, '+=0.2')
			   .to('.plants_india', 0.3, {opacity:1,y:0, ease:Sine.easeInOut});

		var scene1 = new ScrollMagic.Scene({
	              triggerElement: ".about_con",
	              reverse:false
	            })
	            .setTween(tl_abt)
	            .addTo(scrollMagicController);

	    var scene2 = new ScrollMagic.Scene({
	              triggerElement: ".abt_why",
	              reverse:false
	            })
	            .setTween(tl_why)
	            .addTo(scrollMagicController);

	    var scene3 = new ScrollMagic.Scene({
	              triggerElement: "#md_meassage",
	              reverse:false
	            })
	            .setTween(tl_message)
	            .addTo(scrollMagicController);

		var scene4 = new ScrollMagic.Scene({
	              triggerElement: "#production",
	              reverse:false
	            })
	            .setTween(tlIntro)
	            .addTo(scrollMagicController);

		$(pointers).each(function(){
			$(this).bind('click',function(){
				var currAddress = '.plants_'+$(this).attr('attr');

				TweenMax.set('.pin', {top:'15px'});
				TweenMax.set('.base', {scale:0.5, opacity:0});
				TweenMax.set('.line span', {height:0});
				TweenMax.set('.flag', {opacity:0, scale:0.8});
				TweenMax.set('.add_con', {opacity:0, y:20});

				TweenMax.to($(this).find('.pin'), 0.5, {top:'0', ease:Sine.easeInOut},'pin');
				TweenMax.to($(this).find('.base'), 0.5, {opacity:'1', scale:1, ease:Sine.easeInOut},'pin');
				TweenMax.to($(this).find('span'), 0.5, {height:'100%', ease:Sine.easeInOut}, 'pin+=0.3');
				TweenMax.to($(this).find('.flag'), 0.5, {opacity:1, scale:1, ease:Sine.easeInOut}, 'pin+=1');
				TweenMax.set('.add_con', {opacity:0});
				TweenMax.to(currAddress, 0.8, {opacity:1,y:0, ease:Sine.easeInOut},'pin+=1.5');

			});
		});
	}


});