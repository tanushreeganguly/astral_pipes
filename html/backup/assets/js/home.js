$(document).ready(function() {
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

    if(isMobile.iPad()){
      tilesGroup = 8;
    }else if(isMobile.any()){
      tilesGroup = 4;
    }else{
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

    if (winWT <=1023){
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
            responsive:{
                0:{
                    items: 1
                },
                480:{
                    items: 2
                }
            }
        });
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

        //---  W A T E R   P R  O F I N G  -------------------------------------------------------
        function waterProfing() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#waterProfing' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var dropHolder = $('<div class="dropHolder" style="position:relative; left:0; top:0;"></div>');
            animDiv.append(dropHolder);
            //
            var str = '<div style="position:absolute; top:0; left:0; width:100%; height:22px; background:#c2c2c2; border-bottom:solid 3px #969696; ">';
            str += '</div>';
            var topFrame = animDiv.append(str);
            //
            function stopDropAnim() {
                clearInterval(intervalId);
            }

            function startDropAnim() {
                clearInterval(intervalId);
                var left = 20;

                function addDrop(obj) {
                    var xOg = obj.xOg;
                    var drop = $('<div class="waterDrop"></div>');
                    dropHolder.append(drop);
                    var x = xOg + Math.random() * 60 - 30;
                    TweenMax.set(drop, { x: x, y: 10, width: 0, height: 0 });
                    TweenMax.to(drop, 0.5, {
                        width: 40,
                        height: 20,
                        ease: Sine.easeIn,
                        onComplete: function() {
                            TweenMax.killTweensOf(drop);
                            TweenMax.to(drop, 2, { width: 8, height: 12, ease: Expo.easeIn });
                            TweenMax.to(drop, 4, {
                                y: 350,
                                ease: Expo.easeIn,
                                onComplete: function() {
                                    TweenMax.killTweensOf(drop);
                                    drop.remove();
                                }
                            });
                        }
                    });
                }
                clearInterval(intervalId);
                intervalId = setInterval(function() {
                    addDrop({ xOg: 100 });
                    addDrop({ xOg: dropHolder.width() - 100 });
                }, 500);
            }
            setOverOutFun({ tilesHolder: tilesHolder, stopDropAnim: stopDropAnim, startDropAnim: startDropAnim });

        }
        waterProfing();

        //---  T I L E   M O R T A R  -------------------------------------------------------
        function tileMortar() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#tileMortar' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<div class="leftAnimHolder">';
            str += '<img class="square_1" src="assets/images/application-hover/tile-mortar/square-1.png"></img>';
            str += '<img class="square_2" src="assets/images/application-hover/tile-mortar/square-2.png"></img>';
            str += '<img class="square_3" src="assets/images/application-hover/tile-mortar/square-3.png"></img>';
            str += '</div>';
            var leftAnimHolder = $(str);
            animDiv.append(leftAnimHolder);

            var str = '<div class="rightAnimHolder">';
            str += '<img class="square_4" src="assets/images/application-hover/tile-mortar/square-4.png"></img>';
            str += '<img class="square_5" src="assets/images/application-hover/tile-mortar/square-5.png"></img>';
            str += '<img class="square_6" src="assets/images/application-hover/tile-mortar/square-6.png"></img>';
            str += '</div>';
            var leftAnimHolder = $(str);
            animDiv.append(leftAnimHolder);
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#tileMortar .square_2', 0.6, { x: -40, y: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#tileMortar .square_1', 0.6, { x: -40, y: -40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.4')
            tl.from('#tileMortar .square_3', 0.6, { x: -40, y: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.8')

            tl.from('#tileMortar .square_4', 0.6, { x: -40, y: -40, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#tileMortar .square_5', 0.6, { x: 40, y: -40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.4')
            tl.from('#tileMortar .square_6', 0.6, { x: -40, y: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.8')
            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });

        }
        tileMortar();


        //---   C O N S T R U C T I O N   C  H E M I C A  L S  ----------------------------------------------
        function constructionChemicals() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#constructionChemicals' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="truck" src="assets/images/application-hover/construction-chemicals/truck.png"></img>';
            var truck = $(str);
            animDiv.append(truck);

            var str = '<div class="craneHolder">';
            str += '<img class="crane" src="assets/images/application-hover/construction-chemicals/crane.png"></img>';
            str += '<div class="bucketHolder">';
            str += '<img class="bucket" src="assets/images/application-hover/construction-chemicals/bucket.png"></img>';
            str += '</div>';
            str += '</div>';
            var craneHolder = $(str);
            animDiv.append(craneHolder);
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#constructionChemicals .truck', 1.5, { right: 1000, ease: Sine.easeOut }, 'startPoint')
            tl.to('#constructionChemicals .bucket', 1.5, { top: -83, ease: Sine.easeOut }, 'startPoint+=0.3')
            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        constructionChemicals();


        //---    M A R B L E   G R A N I T E   ----------------------------------------------
        function marbleGranite() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#marbleGranite' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="barble-1" src="assets/images/application-hover/marble-granite/barble-1.jpg"></img>';
            str += '<img class="barble-2" src="assets/images/application-hover/marble-granite/barble-2.png"></img>';
            str += '<img class="barble-3" src="assets/images/application-hover/marble-granite/barble-3.jpg"></img>';
            str += '<img class="barble-4" src="assets/images/application-hover/marble-granite/barble-4.png"></img>';
            var barbles = $(str);
            animDiv.append(barbles);
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#marbleGranite .barble-1', 0.8, { x: -40, y: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#marbleGranite .barble-2', 0.8, { x: -40, y: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.4')
            tl.from('#marbleGranite .barble-3', 0.8, { x: 40, y: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#marbleGranite .barble-4', 0.8, { x: 40, y: -40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.4')
            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        marbleGranite();


        //---    G A P   G L A Z I N G   ----------------------------------------------
        function gapGlazing() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#gapGlazing' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="spray" src="assets/images/application-hover/gap-glazing/spray.jpg"></img>';
            str += '<img class="bucket" src="assets/images/application-hover/gap-glazing/glue-bucket.jpg"></img>';
            str += '<img class="machine" src="assets/images/application-hover/gap-glazing/glazing-machine.png"></img>';
            var barbles = $(str);
            animDiv.append(barbles);
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#gapGlazing .spray', 0.8, { right: 525, bottom: -40, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#gapGlazing .machine', 0.8, { rotation: 30, opacity: 0, transformOrigin: "right bottom", ease: Sine.easeOut }, 'startPoint+=0.2')
            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        gapGlazing();


        //---    F U R N I T U R E   W O O D C A R E   ----------------------------------------------
        function furnitureWoodcare() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#furnitureWoodcare' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="flowerTable" src="assets/images/application-hover/furniture-woodcare/flower-table.png"></img>';
            str += '<img class="cupboard" src="assets/images/application-hover/furniture-woodcare/cupboard.png"></img>';
            str += '<img class="chair" src="assets/images/application-hover/furniture-woodcare/chair.png"></img>';
            var barbles = $(str);
            animDiv.append(barbles);
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            /*tl.from('.flowerTable', 0.8, {scale:1.5, opacity:0,  ease:Sine.easeOut}, 'startPoint')
            tl.from('.cupboard', 0.8, {scale:1.5, opacity:0,  ease:Sine.easeOut}, 'startPoint+=0.4')
            tl.from('.chair', 0.8, {scale:1.5, opacity:0,  ease:Sine.easeOut}, 'startPoint+=0.8')*/
            tl.from('#furnitureWoodcare .flowerTable', 0.8, { x: -100, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#furnitureWoodcare .cupboard', 0.8, { x: 100, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.4')
            tl.from('#furnitureWoodcare .chair', 0.8, { x: 100, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.8')
            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        furnitureWoodcare();


        //---    F A B R I C   A P P   ----------------------------------------------
        function fabricApp() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#fabricApp' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="fabric_1" src="assets/images/application-hover/fabric-app/fabric-02.jpg"></img>';
            str += '<img class="fabric_2" src="assets/images/application-hover/fabric-app/fabric-02.jpg"></img>';
            str += '<img class="fabric_3" src="assets/images/application-hover/fabric-app/fabric-02.jpg"></img>';
            str += '<img class="shadow" src="assets/images/application-hover/fabric-app/shadow.png"></img>';
            str += '<img class="fabric_4" src="assets/images/application-hover/fabric-app/fabric-01.jpg"></img>';
            str += '<img class="bobin" src="assets/images/application-hover/fabric-app/bobin.png"></img>';
            str += '<img class="scissor" src="assets/images/application-hover/fabric-app/scissor.png"></img>';
            var barbles = $(str);
            animDiv.append(barbles);
            var fabricSpeed = 0.4;
            var fabricW = 68;
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.set('#fabricApp .fabric_1', { display: 'none', left: 0 })
            tl.set('#fabricApp .fabric_2', { display: 'none', left: fabricW })
            tl.set('#fabricApp .fabric_3', { display: 'none', rotationY: -180, transformOrigin: "left center" })

            tl.set('#fabricApp .fabric_1', { display: 'block' }, 'startPoint+=' + fabricSpeed)
            tl.set('#fabricApp .fabric_2', { display: 'block' }, 'startPoint+=' + (fabricSpeed * 2 - 0.08))

            tl.set('#fabricApp .fabric_3', { display: 'block', rotationY: -180, transformOrigin: "left center" }, 'startPoint')
            tl.to('#fabricApp .fabric_3', fabricSpeed, { rotationY: 0, transformOrigin: "left center", ease: Sine.easeInOut }, 'startPoint')
            tl.to('#fabricApp .fabric_3', fabricSpeed, { rotationY: 180, transformOrigin: "right center", ease: Sine.easeInOut }, 'startPoint+=' + fabricSpeed)
            tl.set('#fabricApp .fabric_3', { x: (fabricW * 2), rotationY: -180, transformOrigin: "left center" }, 'startPoint+=' + (fabricSpeed * 2))
            tl.to('#fabricApp .fabric_3', fabricSpeed, { rotationY: 0, transformOrigin: "left center", ease: Sine.easeInOut }, 'startPoint+=' + (fabricSpeed * 2))

            tl.set('#fabricApp .fabric_4', { display: 'none', rotationY: -180, transformOrigin: "left center" }, 'startPoint+=' + (fabricSpeed * 3) - 0.08)
            tl.to('#fabricApp .fabric_4', fabricSpeed, { display: 'block', rotationY: 0, transformOrigin: "left center", ease: Sine.easeInOut }, 'startPoint+=' + (fabricSpeed * 3))
            tl.from('#fabricApp .shadow', fabricSpeed, { opacity: 0, ease: Sine.easeIn }, 'startPoint+=' + (fabricSpeed * 3))

            tl.from('#fabricApp .bobin', 0.5, { y: 50, opacity: 0, ease: Sine.easeOut }, '-+0.3')
            tl.from('#fabricApp .scissor', 0.5, { y: -50, opacity: 0, ease: Sine.easeOut }, '-+0.2')

            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        fabricApp();




        //---    A U T O M O B I L E   A P P   ----------------------------------------------
        function automobileApp() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#automobileApp' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="circle" src="assets/images/application-hover/automobile-app/jack.jpg"></img>';
            str += '<img class="panna1" src="assets/images/application-hover/automobile-app/panna-1.jpg"></img>';
            str += '<img class="panna2" src="assets/images/application-hover/automobile-app/panna-2.jpg"></img>';
            str += '<img class="tire" src="assets/images/application-hover/automobile-app/tire.png"></img>';
            str += '<div class="carHolder" ></img>';
            str += '<div class="stand"></div>';
            str += '<div class="blackTire"></div>';
            str += '<img class="handdle" src="assets/images/application-hover/automobile-app/handdle.png"></img>';
            str += '<img class="car" src="assets/images/application-hover/automobile-app/car.png"></img>';
            str += '</div>';
            var barbles = $(str);
            animDiv.append(barbles);
            var fabricSpeed = 0.4;
            var fabricW = 68;
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#automobileApp .circle', 0.5, { rotation: 45, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#automobileApp .panna1', 0.5, { x: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.3')
            tl.from('#automobileApp .panna2', 0.5, { x: -40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.3')
            tl.from('#automobileApp .tire', 0.5, { y: 100, ease: Sine.easeOut }, 'startPoint+=0.3')
            tl.from('#automobileApp .carHolder', 0.6, { opacity: 0, ease: Power0.easeNone }, 'startPoint+=0.8')
                .add('jackAnim')
            tl.from('#automobileApp .handdle', 2, { rotationX: 1200, y: 10, ease: Power0.easeNone }, 'jackAnim')
            tl.from('#automobileApp .stand', 2, { height: 25, ease: Power0.easeNone }, 'jackAnim')
            tl.from('#automobileApp .car', 2, { rotation: -5, transformOrigin: "right center", ease: Power0.easeNone }, 'jackAnim')

            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        automobileApp();





        //---    T A P E   A P P   ----------------------------------------------
        function tapeApp() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#tapeApp' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="blackTape" src="assets/images/application-hover/tape-app/black-tape.png"></img>';
            str += '<img class="whiteTape" src="assets/images/application-hover/tape-app/white-tape.png"></img>';
            str += '<div class="tranTape2"></div>';
            str += '<div class="tranTape1"></div>';
            var barbles = $(str);
            animDiv.append(barbles);
            var fabricSpeed = 0.4;
            var fabricW = 68;

            TweenMax.set('#tapeApp .tranTape1', { opacity: 0.5 })
            TweenMax.set('#tapeApp .tranTape2', { rotation: 15, transformOrigin: "left bottom" })
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#tapeApp .blackTape', 0.5, { x: 20, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#tapeApp .whiteTape', 0.5, { x: -20, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#tapeApp .tranTape1', 0.5, { height: 0, ease: Sine.easeOut }, 'startPoint+=0.5')
            tl.from('#tapeApp .tranTape2', 0.5, { height: 0, ease: Sine.easeOut }, '-=0.25')

            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        tapeApp();




        //---    G L A S S   B O N D I N G   ----------------------------------------------
        function glassBonding() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#glassBonding' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="glass1" src="assets/images/application-hover/glass-bonding/glass-1.png"></img>';
            str += '<img class="glass2" src="assets/images/application-hover/glass-bonding/glass-2.png"></img>';
            str += '<img class="glass4" src="assets/images/application-hover/glass-bonding/glass-4.png"></img>';
            str += '<img class="glass3" src="assets/images/application-hover/glass-bonding/glass-3.png"></img>';
            str += '<img class="glass5" src="assets/images/application-hover/glass-bonding/glass-5.png"></img>';
            var barbles = $(str);
            animDiv.append(barbles);
            var fabricSpeed = 0.4;
            var fabricW = 68;

            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#glassBonding .glass1', 0.5, { y: -50, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#glassBonding .glass2', 0.5, { y: 50, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.add('nextGlass', '-=0.2');
            tl.from('#glassBonding .glass3', 1.5, { x: -20, scale: 1.5, opacity: 0, ease: Sine.easeOut }, 'nextGlass')
            tl.from('#glassBonding .glass4', 1.5, { x: 20, scale: 0.5, opacity: 0, ease: Sine.easeOut }, 'nextGlass')
            tl.from('#glassBonding .glass5', 1.5, { x: 20, scale: 1.5, opacity: 0, ease: Sine.easeOut }, 'nextGlass+=0.3')

            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        glassBonding();



        //---    A C C E S S O R I E S   A P P   ----------------------------------------------
        function accessoriesApp() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#accessoriesApp' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<img class="glueGun" src="assets/images/application-hover/accessories-app/glue-gun.jpg"></img>';
            var barbles = $(str);
            animDiv.append(barbles);
            var fabricSpeed = 0.4;
            var fabricW = 68;

            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#accessoriesApp .glueGun', 0.5, { x: 40, y: -40, opacity: 0, ease: Sine.easeOut }, 'startPoint')

            tl.seek(0);
            tl.pause();
            setOverOutFun({ tilesHolder: tilesHolder, tl: tl });
        }
        accessoriesApp();




        //---    A C C E S S O R I E S   A P P   ----------------------------------------------
        function plumbingApp() {
            var intervalId;
            var returnObj = createAnimDivForHoverEffect({ id: '#plumbingApp' });
            var tilesHolder = returnObj.tilesHolder;
            var animDiv = returnObj.animDiv;

            var str = '<div class="leftPipeHolder">';
            str += '<img class="joinedPipe" src="assets/images/application-hover/plumbing-app/joined-pipe.png"></img>';
            str += '<img class="handdle" src="assets/images/application-hover/plumbing-app/pipe-handdle.png"></img>';
            str += '</div>';
            str += '<img class="pipe1" src="assets/images/application-hover/plumbing-app/pipe-1.jpg"></img>';
            str += '<img class="pipe2" src="assets/images/application-hover/plumbing-app/pipe-2.png"></img>';

            var barbles = $(str);
            animDiv.append(barbles);

            var svgPipe1 = $('<svg  class="svgPipe1" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 57 136"><title>line-01</title><path  d="M53,134V41s0-6-7-6c-6,0-6,6-6,6V77s1,6-6,6c-6,0-6-6-6-6V11s0-6-6-6-6,5-6,5V46s0,6-6,6-6-5-6-5V17" style="fill:none;stroke:#3fa9f5;stroke-miterlimit:10;stroke-width:5px"/></svg>');
            $('#plumbingApp .leftPipeHolder').prepend(svgPipe1);

            var kutePipe2 = KUTE.fromTo('.svgPipe1 path', { draw: '0% 0%' }, { draw: '0% 100%' }, { duration: 2000 });
            TweenMax.set('.svgPipe1', { display: 'none' });
            var tl = new TimelineLite()
                .add('startPoint', '+=0.7')
            tl.from('#plumbingApp .pipe1', 0.5, { x: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint')
            tl.from('#plumbingApp .pipe2', 0.5, { x: 40, opacity: 0, ease: Sine.easeOut }, 'startPoint+=0.3')
            tl.add('pipewithhanddle')
            tl.from('#plumbingApp .joinedPipe', 0.5, { y: 20, opacity: 0, ease: Sine.easeOut }, 'pipewithhanddle')
            tl.from('#plumbingApp .handdle', 0.5, { y: 20, opacity: 0, ease: Sine.easeOut }, 'pipewithhanddle')
            tl.add('handdle')
            tl.call(function() {
                kutePipe2.start();
            })
            tl.set('#plumbingApp .svgPipe1', { display: 'block' }, 'handdle+=0.1')
            tl.from('#plumbingApp .handdle', 2, { rotation: 1000, ease: Power0.easeNone }, 'handdle')

            tl.seek(0);
            tl.pause();

            function startDropAnim() {
                tl.timeScale(1);
                tl.play();
            }

            function stopDropAnim() {
                tl.timeScale(2);
                tl.reverse();
            }
            setOverOutFun({ tilesHolder: tilesHolder, startDropAnim: startDropAnim, stopDropAnim: stopDropAnim });
        }
        plumbingApp();


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
                }, 400);
            }
            if (e.type == 'mouseleave') {
                front.animate({
                    marginTop: '0px'
                }, 400);
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
        var face,back;
        var colorWhite = '#ffffff';
        var colorBlack = '#2d2d2d';
        var colorBlue = '#0060ae';

        for (var i = 0; i < frontFaces.length; i++) {
            face = $(frontFaces[i]);
            back = $(backFacess[i]);
            var mod4 = i % 4;
            if (isMobile.iPad()) {
                if (mod4 == 0 || mod4 == 3) {
                    back.css({ background: colorBlue });
                    back.find('.exploe_con p').css({ color: colorWhite });
                } else {
                    back.css({ background: colorWhite });
                    back.find('.exploe_con p').css({ color: colorBlack });
                }
            } else if (isMobile.any()) {
                var plser;
                if(i % 8 <= 3){
                    plser = 0;
                }else{
                    plser = 1;
                }

                if ((i+plser)%2 == 0) {
                    back.css({ background: colorBlue });
                    back.find('.exploe_con p').css({ color: colorWhite });
                } else {
                    back.css({ background: colorWhite});
                    back.find('.exploe_con p').css({ color: colorBlack });
                }
                $('.tiles').css({display:'block', width:'100%'});
            } else {
                if (mod4 == 0 || mod4 == 3) {
                    face.css({ background: colorBlue });
                    face.find('.desc_con').css({ color: colorWhite });
                } else {
                    face.css({ background: colorWhite, color: colorBlue });
                    face.find('.desc_con').css({ color: colorBlack });
                }
            }

        }
    }
    setCommonCSS();
    console.log(isMobile.any());
    if (isMobile.any()) {
        setMobileEffect();
    } else if (window.Modernizr && Modernizr.csstransforms3d && Modernizr.preserve3d) {
        console.log('kjhasfadkashdlasdh');
        set3dEffect();
    } else {
        set2dEffect();
    }
}
//Modernizr.csstransforms3d = false;

console.log(isMobile.any());
if (isMobile.any()) {
    $('#top_brands .front_face').css({'display':'none'});
} else if (window.Modernizr && Modernizr.csstransforms3d && Modernizr.preserve3d) {
    document.write('<link href="assets/css/direction-reveal.css" rel="stylesheet" type="text/css">');
    document.write('<script type="text/javascript" src="assets/js/bundle.js"></script>');
} else {
    $('.direction-reveal__overlay').addClass('for_desk');
    $('#top_brands li').each(function(){
        $(this).hover(
            function(){
               TweenMax.to($(this).find('.direction-reveal__overlay'), 0.5, { top: 0, ease: Sine.easeOut }, 'startPoint')
            },
            function(){
               TweenMax.to($(this).find('.direction-reveal__overlay'), 0.5, { top: '100%', ease: Sine.easeOut }, 'startPoint')
            }
        );
    });
}
