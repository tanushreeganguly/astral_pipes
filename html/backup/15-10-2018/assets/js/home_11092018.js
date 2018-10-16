$(document).ready(function() {
    $(window).unload(function() {
        if (window.TweenMax) {
            TweenMax.killAll();
        }
    });
    if(isMobile.InternetExplorer){
        $('svg').css({'display':'none'});
    }

    var winWT = $(window).innerWidth();

    var owl = $('#slider_holder').owlCarousel({
        animateOut: 'fadeOut',
        autoplay: true,
        loop: true,
        items: 1,
        margin: 0,
        stagePadding: 0,
        smartSpeed: 1300,
        autoplayTimeout: 8000,
        dots: false,
        navigation: false,
        mouseDrag: false,
        pagination: false
    });


    function onSlideChange() {
        TweenMax.set('.bannerDet .overlay', { width: 0 });
        TweenMax.set('.bannerDet span', { opacity: 0, top: '60px' });
        TweenMax.set('.knowMoreBtn', { opacity: 0, y: 10 });

        TweenMax.killTweensOf('#slider_holder .owl-stage-outer img');
        setTimeout(function() {
            var currAnim = $('#slider_holder .owl-stage-outer .active');
            TweenMax.staggerTo(currAnim.find('.bannerDet .overlay'), 0.7, {
                width: '100%',
                ease: Sine.easeOut,
                onComplete: function() {
                    TweenMax.set(currAnim.find('.bannerDet span'), { opacity: 1, });
                    TweenMax.staggerTo(currAnim.find('.bannerDet span'), 0.7, {
                        top: 0,
                        ease: Sine.easeOut,
                        onComplete: function() {
                            TweenMax.to(currAnim.find('.knowMoreBtn'), 0.5, { opacity: 1, y: 0, ease: Sine.easeOut });
                        }
                    }, 0.1);
                }
            }, 0.2);


            TweenMax.killTweensOf(currAnim.find('img'));
            TweenMax.set(currAnim.find('img'), { scale: 1, opacity: 1 });
            TweenMax.to(currAnim.find('img'), 0.5, { opacity: 1, ease: Sine.easeOut });
            TweenMax.to(currAnim.find('img'), 25, { scale: 1.1, ease: Sine.easeOut });

        }, 10);
    }
    onSlideChange();

    owl.on('changed.owl.carousel', onSlideChange);

    owl.on('translated.owl.carousel', function(event) {
        var notActiveSlide = $('.carouselCon .owl-item').not('.active');
        TweenMax.set(notActiveSlide.find('img'), { opacity: 0 });

    });

    var tilesGroup;
    var tilesArr = $('.tilesCon .tiles');
    var item;
    tilesArr.remove();

    if (isMobile.iPad()) {
        tilesGroup = 8;
    } else if (isMobile.any()) {
        tilesGroup = 4;
    } else {
        tilesGroup = 8;
    }

    for (var i = 0; i < tilesArr.length; i++) {
        var htmlStr = tilesArr[i];

        if ((i % tilesGroup) == 0) {
            item = $('<div class="item"></div>')
            $('.tilesCon').append(item);
        }

        item.append($(htmlStr));

    }

    // $('.tilesCon').owlCarousel({
    //     autoplay: false,
    //     loop: false,
    //     items: 1,
    //     margin: 15,
    //     stagePadding: 0,
    //     smartSpeed: 1300,
    //     autoplayTimeout: 8000,
    //     dots: true,
    //     navigation: false,
    //     mouseDrag: false,
    //     pagination: false
    // });

    var tilesPagination = $('.tilesCon').find('.owl-dot');
    tilesPagination.each(function() {
        $(this).children('span').text($(this).index() + 1);
    });


    $('.counter').counterUp({
        delay: 8,
        time: 1000
    });

    setCubeRolloverEffect();

    if (winWT <= 1023) {
        var brandList = $('#top_brands').find('li');
        $(brandList).addClass('item');
        $('#top_brands ul').owlCarousel({
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
                }
            }
        });

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


    var isBenchMarkAnimDone = false;

    function setBenchmarkEffects() {
        var circleW = 240;
        var listinsectionAnimation = $('.listinsectionAnimation');
        var li = $('.listinsectionAnimation li');
        var NewsecAnimH = $('.NewsecAnimH');
        listinsectionAnimation.css({ width: 1000, height: 464, position: 'relative', padding: 0 });
        listinsectionAnimation.addClass('alignHorizontalCenter');
        NewsecAnimH.css({ padding: 0, width: circleW, height: 'auto', maxWidth: 'none' });
        li.css({ position: 'absolute', left: 0, top: 0, margin: 0, display: 'none' });
        $(li[0]).css({ display: 'block' });
        for (var i = 0; i < li.length; i++) {
            $(li[i]).css({ zIndex: 100 - i });
        }
        TweenMax.set(listinsectionAnimation.find('.animationiconimg, h3, h4, p'), { opacity: 0 });

        if(window.navigator && navigator.appVersion && navigator.appVersion.indexOf("Win")!=-1 && navigator.userAgent.search("Chrome")>=0){
            console.log('windows');
            listinsectionAnimation.addClass('svgElasticEffect');
        } 
        


        var ease = Power0.easeNone;
        //ease = Elastic.easeOut.config(0.5, 0.5);
        //ease = Elastic.easeOut.config(1, 1);

        var bgimgcutsecH = $('.listinsectionAnimation .bgimgcutsecH');
        TweenMax.set(bgimgcutsecH, { display: 'none' });
        var bgimgcutsecHUp = $('.listinsectionAnimation .bgimgcutsecHUp');
        TweenMax.set(bgimgcutsecHUp, { display: 'none' });
        TweenMax.set($(li[0]), { scale: 0.1 });

        function showFirstCir() {
            var ele = $(li[0]);
            TweenMax.set(ele, { scale: 0.1 });
            TweenMax.to(ele, 1, {
                scale: 1,
                ease: ease,
                onComplete: function() {
                    TweenMax.set(bgimgcutsecH, { display: 'block' });
                    TweenMax.from(bgimgcutsecH, 1, { left: 35, bottom: 35, ease: ease });
                    TweenMax.to(ele.find('.animationiconimg, h3, h4, p'), 0.6, { opacity: 1, ease: Cubic.easeInOut });
                    showDownCir({ index: 1 });
                }
            });
        }

        function showLastSmallCir() {

            TweenMax.set(bgimgcutsecHUp, { display: 'block' });
            TweenMax.from(bgimgcutsecHUp, 1, { right: 0, top: 35, ease: ease });
        }

        function getXY(paramObj) {
            var index = paramObj.index;
            var x = (circleW + 7) * index;
            var y = 0;
            if (index % 2 == 1) {
                y = 120;
            }
            return { x: x, y: y }
        }

        function showDownCir(paramObj) {
            var index = paramObj.index;
            if (index >= 4) {
                showLastSmallCir();
                return;
            }
            var ele = $(li[index]);
            var speed = 1.5;
            var conDiv, x, y;
            var xyObj = getXY({ index: index - 1 });
            var rotation = -30;
           
            if (index % 2 == 1) {
                conDiv = $('<div class="conDiv"><img src="assets/images/curve-down.png"></img></div>');
                rotation = 30;
                x = -53;
                y = 13;
            }else{
                x = -53;
                y = 129;
                conDiv = $('<div class="conDiv"><img src="assets/images/curve-up.png"></img></div>');
            }
            TweenMax.set(conDiv, {
                position: 'absolute',
                //width: 150,
                //height: 55,
                //rotation: rotation,
                left: 0,
                top: 0,
                x: x,
                y: y,
                //background: '#0297e0'
            });
            ele.append(conDiv);

            TweenMax.set(ele, { scale: 0.25, display: 'block', x: xyObj.x, y: xyObj.y });
            xyObj = getXY({ index: index });
            TweenMax.to(ele, speed, {
                scale: 1,
                x: xyObj.x,
                y: xyObj.y,
                ease: ease,
                onComplete: function() {
                    TweenMax.to(ele.find('.animationiconimg, h3, h4, p'), 0.6, { opacity: 1, ease: Cubic.easeInOut });
                    showDownCir({ index: index + 1 });
                }
            });

        }
        $('#benchmarkAnimH').waypoint(function() {
            if (isBenchMarkAnimDone) {
                return;
            } else {
                showFirstCir();
                isBenchMarkAnimDone = true;
            }
        }, { offset: '100%' });


    }
    if (isMobile.any()) {} else {

        setBenchmarkEffects();
    }

});

function setCubeRolloverEffect() {
    function set3dEffect() {
        var cubeHeight, halfCubeHeight;

        $('.tilesCon .tile_front_face, .tilesCon .tile_back_face').addClass('cubeInnerShadow');

        function onResize() {
            cubeHeight = $('.tilesCon .tiles').height();
            halfCubeHeight = cubeHeight / 2;
            TweenMax.set('.tilesCon .tiles', { perspective: '500px', verticalAlign: 'top' });
            TweenMax.set('.tilesCon .cube', { height: cubeHeight, transformStyle: 'preserve-3d' });
            TweenMax.set('.tilesCon .tile_front_face,.tilesCon .tile_back_face', { height: cubeHeight });
            TweenMax.set('.tilesCon .tile_back_face', { display: 'block' });

        }
        $(window).resize(onResize);
        onResize();
        var cubeParent = $('.tilesCon .tiles');
        cubeParent.hover(function(e) {
            var cube = $(this).find('.cube');
            var data = $(this).data();
            if (e.type == 'mouseenter') {
                var speed = 0.8;
                TweenMax.killTweensOf(cube);
                TweenMax.to(cube, speed, { rotationX: 90, y: -halfCubeHeight, ease: Sine.easeInOut });
                TweenMax.to(cube, speed / 2, { z: -150, ease: Sine.easeOut });
                TweenMax.to(cube, speed / 2, { z: -halfCubeHeight, ease: Sine.easeIn, delay: speed / 2 });
                if (data.rollOverFun) {
                    data.rollOverFun();
                }
            }
            if (e.type == 'mouseleave') {
                var speed = 0.8;
                TweenMax.killTweensOf(cube);
                TweenMax.to(cube, speed, { rotationX: 0, y: 0, ease: Sine.easeInOut });
                TweenMax.to(cube, speed, { z: 0, ease: Sine.easeIn });
                if (data.rollOutFun) {
                    data.rollOutFun();
                }
            }
        });
        TweenMax.set('.tile_back_face', { y: -halfCubeHeight, z: -halfCubeHeight, rotationX: -90 });


        function createAnimDivForHoverEffect(obj) {
            var tilesHolder = $(obj.id);
            var backface = tilesHolder.find('.tile_back_face');
            backface.css({ background: '#ffffff', overflow: 'hidden' });
            var animDiv = $('<div class="animDiv"></div>');
            backface.prepend(animDiv);
            obj.tilesHolder = tilesHolder;
            obj.animDiv = animDiv;
            return obj;
        }

        function setOverOutFun(obj) {
            function startDropAnim() {
                obj.tl.timeScale(1);
                obj.tl.play();
            }

            function stopDropAnim() {
                obj.tl.timeScale(2);
                obj.tl.reverse();
            }
            if (obj.startDropAnim != undefined) {
                obj.tilesHolder.data("rollOverFun", obj.startDropAnim);
                obj.tilesHolder.data("rollOutFun", obj.stopDropAnim);
            } else {
                obj.tilesHolder.data("rollOverFun", startDropAnim);
                obj.tilesHolder.data("rollOutFun", stopDropAnim);
            }
        }

    }


    function set2dEffect() {
        var cubeHeight, halfCubeHeight;

        function onResize() {
            cubeHeight = $('.tilesCon .tiles').height();
            halfCubeHeight = cubeHeight / 2;
            $('.tilesCon .cube').css({ height: cubeHeight + 'px', overflow: 'hidden' });
            $('.tilesCon .tile_front_face,.tilesCon .tile_back_face').css({ height: cubeHeight + 'px' });
            $('.tilesCon .tile_back_face').css({ display: 'block', position: 'relative' });

        }
        $(window).resize(onResize);
        onResize();
        var cubeParent = $('.tilesCon .tiles');
        cubeParent.hover(function(e) {
            var front = $(this).find('.cube .tile_front_face');
            if (e.type == 'mouseenter') {
                front.animate({
                    marginTop: -cubeHeight + 'px'
                }, 800);
            }
            if (e.type == 'mouseleave') {
                front.animate({
                    marginTop: '0px'
                }, 800);
            }
        })
        setBackgroundImageToBackface();
    }

    function setBackgroundImageToBackface() {
        var backFaces = $('.tilesCon .tile_back_face');
        backFaces.each(function(index) {
            data = $(this).data();
            if (data.background) {
                $(this).css({ background: data.background });
                if (data.backgroundSize) {
                    $(this).css({ backgroundSize: data.backgroundSize });
                }
            }
        });
    }

    function setMobileEffect() {
        TweenMax.set('.tilesCon .tile_front_face', { display: 'none' });
        TweenMax.set('.tilesCon .tile_back_face', { display: 'block' });
    }

    function setCommonCSS() {
        var frontFaces = $('.tilesCon .tile_front_face');
        var backFacess = $('.tilesCon .tile_back_face');
        var face, back;
        var colorWhite = '#ffffff';
        var colorBlack = '#2d2d2d';
        var colorBlue = '#0060ae';
        

        for (var i = 0; i < frontFaces.length; i++) {
            face = $(frontFaces[i]);
            back = $(backFacess[i]);
            var mod4 = i % 4;
            if (isMobile.iPad()) {
                if (mod4 == 0 || mod4 == 3) {
                    // back.css({ background: colorBlue });
                    back.find('.exploe_con p').css({ color: colorWhite });
                } else {
                    back.css({ background: colorWhite });
                    back.find('.exploe_con p').css({ color: colorBlack });
                }
            } else if (isMobile.any()) {
                var plser;
                if (i % 8 <= 3) {
                    plser = 0;
                } else {
                    plser = 1;
                }

                if ((i + plser) % 2 == 0) {
                    // back.css({ background: colorBlue });
                    back.find('.exploe_con p').css({ color: colorWhite });
                } else {
                    // back.css({ background: colorWhite });
                    back.find('.exploe_con p').css({ color: colorWhite });
                }
                $('.tiles').css({ display: 'block', width: '100%' });
            } else {
                if (mod4 == 0 || mod4 == 3) {
                    // face.css({ background: colorBlue });
                    face.find('.desc_con').css({ color: colorWhite });
                } else {
                    face.css({ background: colorWhite, color: colorBlue });
                    face.find('.desc_con').css({ color: colorBlack });
                }
            }

        }
    }
    setCommonCSS();
    if (isMobile.any()) {
        setMobileEffect();
    } else if (window.Modernizr && Modernizr.csstransforms3d && Modernizr.preserve3d) {
        console.log('kjhasfadkashdlasdh');
        set3dEffect();
    } else {
        set2dEffect();
    }
}
Modernizr.csstransforms3d = false;

console.log(isMobile.any());
if (isMobile.any()) {
    $('#top_brands .front_face').css({ 'display': 'none' });
} else if (window.Modernizr && Modernizr.csstransforms3d && Modernizr.preserve3d) {
    document.write('<link href="assets/css/direction-reveal.css" rel="stylesheet" type="text/css">');
    document.write('<script type="text/javascript" src="assets/js/bundle.js"></script>');
} else {
    $('.direction-reveal__overlay').addClass('for_desk');
    $('#top_brands li').each(function() {
        $(this).hover(
            function() {
                TweenMax.to($(this).find('.direction-reveal__overlay'), 0.5, { top: 0, ease: Sine.easeOut }, 'startPoint')
            },
            function() {
                TweenMax.to($(this).find('.direction-reveal__overlay'), 0.5, { top: '100%', ease: Sine.easeOut }, 'startPoint')
            }
        );
    });
}