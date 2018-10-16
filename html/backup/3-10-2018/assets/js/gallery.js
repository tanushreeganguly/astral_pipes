$(document).ready(function () {
    var winWidth = $(window).innerWidth();

    /*+++++++++++Scroll To Code++++++++++++*/
    var tabList = $('.product_graystrip').find('span');
    tabList.each(function () {
        $(this).bind('click', function () {
            var scrollPos = $(this).attr('scrollTo');
            //console.log(currId);
            // $("html, body").animate({ scrollTop:($(scrollPos).offset().top - 180) }, {duration:1200});
        });
    });
    /*+++++++++++Scroll To Code++++++++++++*/

    /*Open Specifications On Mobile*/
    $('.res_specs_tl a').bind('click', function () {

        if ($(this).hasClass('open')) {
            $('.specs_list').slideUp(300);
            $(this).removeClass('open');
            TweenMax.to('.res_specs_tl img', 0.5, { rotation: 0, ease: Sine.easeInOut });
        } else {
            $('.specs_list').slideDown(300);
            $(this).addClass('open');
            TweenMax.to('.res_specs_tl img', 0.5, { rotation: 180, ease: Sine.easeInOut });
        }

    });


    /*if(winWidth <= 767){
        $('.specs_list span').bind('click', function(){
            $('.specs_list').slideUp(300);
            $('.res_specs_tl a').removeClass('open');
            TweenMax.to('.res_specs_tl img',0.5, {rotation: 0, ease:Sine.easeInOut});
        });
    }*/

    /*Open Specifications On Mobile*/

    $('.magnific-gallery').each(function (index, value) {
        var gallery = $(this);
        var galleryImages = $(this).data('links').split(',');
        var items = [];
        for (var i = 0; i < galleryImages.length; i++) {
            items.push({
                src: galleryImages[i],
                title: ''
            });
            console.log(items);
        }
        gallery.magnificPopup({
            mainClass: 'mfp-fade',
            items: items,
            gallery: {
                enabled: true,
                tPrev: $(this).data('prev-text'),
                tNext: $(this).data('next-text')
            },
            type: 'image'
        });
    });

    $('.video_link').magnificPopup({
        type: 'iframe',
        closeOnBgClick: true,
        modal: true,
        gallery: {
            enabled: false
        }
    });



    /*Gallery Images Load*/
    function loadImgs() {
        var imgs = $('.loader_gif');
        function sendToload(i) {
            var img = $(imgs[i]);
            var src = img.attr('orgSrc');
            var imgTag = $('<img class="gal_img"  src="">');
            img.after(imgTag);
            imgTag.load(function () {
                TweenMax.to(imgTag, 0.8, { opacity: 1, ease: Power2.easeOut });
            });
            imgTag.attr('src', src);
        }

        for (var i = 0; i < imgs.length; i++) {
            sendToload(i);
        }

    }
    loadImgs();

    var mediaTab = $('.specs_list').find('span');
    mediaTab.each(function () {
        $(this).bind('click', function () {
            var currTab = '#gallery_' + $(this).attr('attr');
            $('.galleryCon').css({ 'display': 'none' });
            $(currTab).fadeIn(300);
            $('.product_graystrip span').removeClass('activeTab');
            $(this).addClass('activeTab');
        });
    });

});