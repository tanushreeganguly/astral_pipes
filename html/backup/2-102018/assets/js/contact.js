$(document).ready(function(){
    var winWT = $(window).innerWidth();

    if(winWT >= 1024){
        TweenMax.set('.pin', {top:'15px', opacity:0, scale:0.5});
        TweenMax.set('.base', {scale:0.5, opacity:0});
        corporateAddressAnimDesk();
        globalAddressAnimDesk();
    }else{
        mobileCorporateAnim();
        mobileGlobalAnim();
    }
    
});


function corporateAddressAnimDesk(){
    TweenMax.set('.cityAdd .address_det', {x:-30, opacity:0, display:'none'});
    TweenMax.set('.line_con', {rotation:180});
    TweenMax.set('.line', {width:0});

    TweenMax.staggerTo('.cityAdd .pin', 0.3, {opacity:1, scale:1, ease:Sine.easeInOut, onComplete:function(){
        TweenMax.set('.add_kanpur', {display:'block'});
        TweenMax.to('.add_kanpur', 0.5, {opacity:1, x:0, ease:Sine.easeOut});
        //TweenMax.to('.kanpur_loc .line', 0.5, {width:'100%', ease:Sine.easeOut});
        TweenMax.to('.kanpur_loc .pin', 0.3, {opacity:1, top:'0', ease:Sine.easeOut},'pin');
        TweenMax.to('.kanpur_loc .base', 0.3, {opacity:1, scale:1, ease:Sine.easeOut},'pin');
        TweenMax.to('.kanpur_loc .city_name', 0.3, {opacity:'1', display:'block', ease:Sine.easeOut},'pin');
    }}, 0.08);

    $('.cityAdd .pointers').each(function(){
        $(this).bind('click', function(){
            var currAddress = '.add_'+$(this).attr('attr');

            TweenMax.set('.cityAdd .pin', {top:'15px'});
            TweenMax.set('.cityAdd .base', {scale:0.5, opacity:0});
            TweenMax.set('.cityAdd .line', {width:0});

            TweenMax.to($(this).find('.pin'), 0.5, {top:'0', ease:Sine.easeInOut},'pin');
            TweenMax.to($(this).find('.base'), 0.5, {opacity:'1', scale:1, ease:Sine.easeInOut},'pin');
            TweenMax.set('.city_name', {display:'none'});
            TweenMax.to($(this).find('.city_name'), 0.5, {opacity:'1', display:'block', ease:Sine.easeInOut},'pin');
            //TweenMax.to($(this).find('.line'), 0.5, {width:'100%', ease:Sine.easeInOut},'pin');
            TweenMax.set('.cityAdd .address_det', {x:-30, opacity:0, display:'none'});
            TweenMax.set(currAddress, {display:'block'});
            TweenMax.to(currAddress, 0.5, {opacity:1, x:0, ease:Sine.easeOut});

        });
    });
}

function globalAddressAnimDesk(){
    TweenMax.set('.global_address_con .address_det', {x:-30, opacity:0, display:'none'});
    TweenMax.staggerTo('.global_address_con .pin', 0.5, {opacity:1, scale:1, ease:Sine.easeInOut,onComplete:function(){
        TweenMax.to('.us_loc .pin', 0.3, {opacity:1, top:'0', ease:Sine.easeOut},'pin');
        TweenMax.to('.us_loc .base', 0.3, {opacity:1, scale:1, ease:Sine.easeOut},'pin');
        TweenMax.set('.loc_global01', {display:'block'});
        TweenMax.to('.loc_global01', 0.5, {opacity:1, x:0, ease:Sine.easeOut});
    } },0.08);

    $('.global_address_con .pointers').each(function(){
        $(this).bind('click', function(){
            var currAddress = '.loc_'+$(this).attr('attr');
            TweenMax.set('.global_address_con .pin', {top:'15px'});
            TweenMax.set('.global_address_con .base', {scale:0.5, opacity:0});
            TweenMax.set('.global_address_con .line', {width:0});

            TweenMax.to($(this).find('.pin'), 0.5, {top:'0', ease:Sine.easeInOut},'pin');
            TweenMax.to($(this).find('.base'), 0.5, {opacity:'1', scale:1, ease:Sine.easeInOut},'pin');
            TweenMax.set('.global_address_con .address_det', {x:-30, opacity:0, display:'none'});
            TweenMax.set(currAddress, {display:'block'});
            TweenMax.to(currAddress, 0.5, {opacity:1, x:0, ease:Sine.easeOut});
            console.log(currAddress);
        }); 
    });
}

function mobileCorporateAnim(){
    var corporateAddHead = $('.cityAdd').find('h2');
    var corporateAddDet = $('.cityAdd').find('.res_det');

    $(corporateAddDet[0]).css({'display':'block'});

    function opeenRespectiveAddress(i){
        var currHeading = $(corporateAddHead[i]);
        currHeading.bind('click', function(){
            var currAddress = $(corporateAddDet[i]);
            if(currHeading.hasClass('openAdd')){
                corporateAddDet.slideUp(300);
                TweenMax.to(currHeading.find('.arrow'),0.5, {rotation: 0, ease:Sine.easeInOut});
                currHeading.removeClass('openAdd');
            }else{
                corporateAddDet.slideUp(300);
                currAddress.slideDown(300);
                corporateAddHead.removeClass('openAdd');
                TweenMax.to('.arrow',0.5, {rotation: 0, ease:Sine.easeInOut});
                TweenMax.to(currHeading.find('.arrow'),0.5, {rotation: -180, ease:Sine.easeInOut});
                currHeading.addClass('openAdd');
                $("html, body").animate({ scrollTop:($(currHeading).offset().top - 220) }, {duration:1200});
            }
        });
    }

    for(var i = 0; i<corporateAddHead.length; i++){
        opeenRespectiveAddress(i);
    }
}

function mobileGlobalAnim(){
    var globlaHead =  $('.global_address_con').find('h2');

    globlaHead.each(function(){
        $(this).bind('click', function(){
            var currId = '#open_'+$(this).attr('id');
            $('.global_address_con .res_det').slideUp();
            $(currId).slideDown(300);
            TweenMax.to(globlaHead.find('.arrow'),0.5, {rotation: 0, ease:Sine.easeInOut});
            TweenMax.to($(this).find('.arrow'),0.5, {rotation: -180, ease:Sine.easeInOut});
            $("html, body").animate({ scrollTop:($(this).offset().top - 220) }, {duration:1200});
        });
    });
}