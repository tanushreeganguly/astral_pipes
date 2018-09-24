var isMobile = new Object();  
isMobile.Android = function() {return navigator.userAgent.match(/Android/i);}
isMobile.BlackBerry = function() {return navigator.userAgent.match(/BlackBerry/i);}
isMobile.iOS = function() {return navigator.userAgent.match(/iPhone|iPad|iPod/i);}
isMobile.iPad = function() {return navigator.userAgent.match(/iPad/i);}
isMobile.Opera = function() {return navigator.userAgent.match(/Opera Mini/i);}
isMobile.Windows = function() {return navigator.userAgent.match(/IEMobile/i);} 
isMobile.Firefox = function() {return navigator.userAgent.match(/Firefox/ig);}  
isMobile.InternetExplorer = function() {return navigator.userAgent.match(/MSIE/ig);} 
isMobile.Opera = function() {return navigator.userAgent.match(/Opera/ig);}  
isMobile.Safari = function() {return navigator.userAgent.match(/Safari/ig);} 

isMobile.Edge = function() {return null}  
if (document.documentMode || /Edge/.test(navigator.userAgent)) {
   isMobile.Edge = function() {return true}  
}
 
isMobile.any = function() {return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());}
if(isMobile.any() && isMobile.iPad()==null){
//return;
}

$(document).ready(function(){
	var winWidth = $(window).innerWidth();
	var headerHT = $('header').innerHeight();
	var headerTopHT = $('.hd_top').innerHeight();
	var resHeaderHT = $('.hd_bottom').innerHeight();
	var topOfGrayStrip;
	
	$('.slimmenu').slimmenu({
		resizeWidth: '1157',
		collapserTitle: '',
		animSpeed:'medium',
		indentChildren: true,
		childrenIndenter: '&raquo;'
	});

	if(winWidth < 1157){
		var topHeader = $('.hd_top').remove();
		$(topHeader).insertAfter('ul.slimmenu.collapsed > li:last-child');
		TweenMax.set('.hd_top', {display:'block'});
	}

	TweenMax.set('#search_con', { opacity:0, top:'-50%'});
	$('.search').bind('click', function(){
		TweenMax.to('#search_con',0.8,{opacity:1, top:0,ease:Sine.easeInOut});
	});

	$('.closeSearch').bind('click', function(){
		TweenMax.to('#search_con',0.8,{opacity:0, top:'-50%',ease:Sine.easeInOut});
	});


	$('.footerClose').bind('click', function(){
		if($(this).hasClass('open')){
			$('.footerClose').removeClass('open');
			$('.footer').slideDown(500);
			$("html, body").animate({ scrollTop:($('.footer').offset().top)}, {duration:1200, easing:'easeInOutCubic'});
			TweenMax.to('.arrow',0.5, {rotation: 180, ease:Sine.easeInOut});
			$('.ft_close').empty();
			$('.ft_close').text('Close');
		}else{
			$('.footerClose').addClass('open');
			$('.footer').slideUp(500);
			TweenMax.to('.arrow',0.5, {rotation: 0, ease:Sine.easeInOut});
			$('.ft_close').empty();
			$('.ft_close').text('Open');
		}
	});

	function setWrapperFromHeader(){
		if(winWidth > 1157){
			TweenMax.set('.gutter', {paddingTop:headerHT+'px'});
		}else{
			TweenMax.set('.gutter', {paddingTop:resHeaderHT+'px'});
		}
	}

	setTimeout(function(){	
		setWrapperFromHeader();	
	}, 100);

	$(window).scroll(function(){
		if(winWidth > 1157){
			topOfGrayStrip = 65;
			if ($(this).scrollTop() > 100) {
				TweenMax.to('header',0.1,{top:(-headerTopHT-5)+'px',ease:Sine.easeInOut});
			}else {
				TweenMax.to('header',0.1,{top:'0px',ease:Sine.easeInOut});
			}
		}else{
			topOfGrayStrip = 55;
		}


		if ($(this).scrollTop() > 100){
			TweenMax.to('.product_graystrip',0.1,{position:'fixed',left:'0px;',top:topOfGrayStrip+'px',ease:Sine.easeInOut});
		}else{
			TweenMax.to('.product_graystrip',0.1,{position:'relative',left:'0', top:0,ease:Sine.easeInOut});
		}

	});
	
	function onWindowResize(){
		setWrapperFromHeader();		
	}

	$(window).resize(onWindowResize);
});