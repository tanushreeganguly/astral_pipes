
function setCubeRolloverEffect(){
	function set3dEffect(){
		var cubeHeight, halfCubeHeight;	
		function onResize(){
	    	cubeHeight = $('.tilesCon .tiles').height();
			halfCubeHeight = cubeHeight/2;
			TweenMax.set('.tilesCon .tiles', {perspective:'500px', verticalAlign:'top' });
			TweenMax.set('.tilesCon .cube', {height:cubeHeight,  transformStyle: 'preserve-3d'});
			TweenMax.set('.tilesCon .tile_front_face,.tilesCon .tile_back_face', {height:cubeHeight });		
			TweenMax.set('.tilesCon .tile_back_face', {display:'block' });

		}
	    $(window).resize(onResize);
	    onResize();
	    var cubeParent = $('.tilesCon .tiles');
	    cubeParent.hover( function(e){
	    	var cube = $(this).find('.cube');
	    	if(e.type == 'mouseenter'){   
		    	var speed = 0.8; 		
		    	TweenMax.killTweensOf(cube);
		    	TweenMax.to(cube, speed, { rotationX:90, y:-halfCubeHeight, ease:Sine.easeInOut});
		    	TweenMax.to(cube, speed/2, { z:-150, ease:Sine.easeOut});
		    	TweenMax.to(cube, speed/2, { z:-halfCubeHeight, ease:Sine.easeIn, delay:speed/2});
	    	}
	    	if(e.type == 'mouseleave'){
		    	var speed = 0.8;
		    	TweenMax.killTweensOf(cube);
		    	TweenMax.to(cube, speed, { rotationX:0, y:0,  ease:Sine.easeInOut});
		    	TweenMax.to(cube, speed, { z:0, ease:Sine.easeIn});
	    	}
	    })
	    TweenMax.set('.tile_back_face', { y:-halfCubeHeight, z:-halfCubeHeight, rotationX:-90}); 
	    //
	    //
	}


	function set2dEffect(){
		var cubeHeight, halfCubeHeight;	
		function onResize(){	
			cubeHeight = $('.tilesCon .tiles').height();
			halfCubeHeight = cubeHeight/2;
			$('.tilesCon .cube').css({height:cubeHeight+'px', overflow:'hidden' });	
			$('.tilesCon .tile_front_face,.tilesCon .tile_back_face').css({height:cubeHeight+'px' });		
			$('.tilesCon .tile_back_face').css({display:'block', position:'relative'});

		}
	    $(window).resize(onResize);
	    onResize();
	    var cubeParent = $('.tilesCon .tiles');
	    cubeParent.hover( function(e){
	    	var front = $(this).find('.cube .tile_front_face');
	    	if(e.type == 'mouseenter'){  
	    		front.animate({
				    marginTop: -cubeHeight+'px'
				  }, 400);
	    	}
	    	if(e.type == 'mouseleave'){	    		
	    		front.animate({
				    marginTop: '0px'
				  }, 400);
	    	}
	    })
	}

	function setMobileEffect(){
		TweenMax.set('.tilesCon .tile_front_face', {display:'none' });
		TweenMax.set('.tilesCon .tile_back_face', {display:'block' });
	}

	function setCommonCSS(){
		var frontFaces = $('.tilesCon .tile_front_face');
		var face;
		for (var i = 0; i < frontFaces.length; i++) {
			face = $(frontFaces[i]);
			var mod4 = i%4;
			if(mod4==0 || mod4==3){
				face.css({background:'#0060ae'});
			}else{
				face.css({background:'#ffffff'});
			}
		}

	}
	setCommonCSS();
	if(isMobile.any()){
		setMobileEffect();
	}else if (window.Modernizr && Modernizr.csstransforms3d && Modernizr.preserve3d) {  
		set3dEffect();
	} else {
		set2dEffect();
	}
}
setCubeRolloverEffect();