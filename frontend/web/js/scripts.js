function updateCountSearchBlok(){
    var dataString = $("#search_blok").serialize();
    var baseurl=$("#baseurl").val();
    $.post(baseurl+"/elanlar/?"+dataString+"&ajax=1",function(data){
        $(".goster_button").html('('+data+')');
    });
}

function initSlyScroll() {
    if ('sly' in $.fn) {
        $frame = $('.scroll');
        $frame.each(function() {
            var _this = $(this);
            var $wrap = $(this).parent();

            var _thisH = _this.height(),
                _listH = $('.scroll-holder', _this).height();

            if (!$('.scrollbar', _this).size()) {
                _this.append('<div class="scrollbar"><div class="handle"><div class="mousearea"></div></div></div>');
            }

            if (_listH > _thisH) {
                _this.addClass('init');
            } else {
                _this.removeClass('init');
            }

            $(this).sly({
                smart: 1,
                mouseDragging: 0,
                touchDragging: 1,
                releaseSwing: 1,
                startAt: 0,
                cycleBy: 0,
                cycleInterval: 0,
                scrollBar: 0,
                scrollBy: 100,
                speed: 1000,
                elasticBounds: 1,
                scrollBar: _this.find('.scrollbar'),
                easing: 'easeOutExpo',
                dragHandle: 1,
                dynamicHandle: 1,
                clickBar: 1,
                prevPage: _this.find('.prev'),
                nextPage: _this.find('.next'),
                draggedClass: 'dragged', // Class for dragged elements (like SLIDEE or scrollbar handle).
                activeClass: 'active', // Class for active items and pages.
                disabledClass: 'disabled'
            }, {
                move: function(a) {
                    wst = this.pos.cur;
                    $(window).trigger('scroll');
                }
            });
            $frame.sly('reload');
        });
    }
}

function initPopups() {
    if ('fancybox' in $.fn) {
        if ($('#wrapper').width() < 640) {
            $('.call-popup').fancybox({
                type: 'ajax',
                wrapCSS: 'popup',
                scrollOutside: false,
                padding: 0,
                margin: 0,
                beforeShow: function(current, previous) {
                    if ('iCheck' in $.fn) {
                        $('input').iCheck({
                            checkboxClass: 'check',
                            radioClass: 'radio',
                            increaseArea: '20%' // optional
                        });
                    }
                    if ('SumoSelect' in $.fn) {
                        $('select').SumoSelect();
                    }
                    if ('starrr' in $.fn) {
                        var $s2input = $('.review-popup #rating');
                        $('.review-popup .stars').starrr({
                            max: 5,
                            emptyClass: 'fa fa-star',
                            fullClass: 'fa fa-star active',
                            rating: $s2input.val(),
                            change: function(e, value) {
                                $s2input.val(value).trigger('input');
                            }
                        });
                    }
                    $('.basket .scroll').css({
                        'max-height': $('.fancybox-inner').height() - 161
                    })
                    initSlyScroll();
                }
            });
        } else {
            $('.call-popup').fancybox({
                type: 'ajax',
                wrapCSS: 'popup',
                padding: 0,
                margin: 10,
                fitToView: false,
                maxWidth: 622,
                beforeShow: function(current, previous) {
                    if ('iCheck' in $.fn) {
                        $('input').iCheck({
                            checkboxClass: 'check',
                            radioClass: 'radio',
                            increaseArea: '20%' // optional
                        });
                    }
                    if ('SumoSelect' in $.fn) {
                        $('select').SumoSelect();
                    }
                    if ('starrr' in $.fn) {
                        var $s2input = $('.review-popup #rating');
                        $('.review-popup .stars').starrr({
                            max: 5,
                            emptyClass: 'fa fa-star',
                            fullClass: 'fa fa-star active',
                            rating: $s2input.val(),
                            change: function(e, value) {
                                $s2input.val(value).trigger('input');
                            }
                        });
                    }
                    initSlyScroll();
                }
            });
        }
        $(document).on('click', '.popup .back', function(event) {
            $.fancybox.close();
            event.preventDefault();
        });
    }
}

$(function () {

    initPopups();

    updateCountSearchBlok();

    $("#search_blok input, #search_blok select").change(function(){
        updateCountSearchBlok();
    });
    $(".s_b").show();


    if($('.banner-left a img').length>0){
        var wdth=$('.banner-left a img').attr('width');
        $(".banner-left").css('left','-'+wdth+'px');
    }
    if($('.banner-left iframe').length>0){
        var wdth=$('.banner-left iframe').attr('width');
        $(".banner-left").css('left','-'+wdth+'px');
    }

    $(".rent_btn").click(function(){
        var announce_type=2;
        var info=$(this).attr('data-info');             if(info=='vip2') announce_type=1;
        var html=$("#"+info+"_rent").html();
        if(html.indexOf('bx_loader')>0){
            var baseurl=$("#baseurl").val();
            $.post(baseurl+"/site/get_home_announces/?property_type="+info+"&announce_type="+announce_type+"&limit=5",function(data){
                $("#"+info+"_rent").html(data);
            });
        }
    });

    $(".change_all_count").click(function(){
        var info=$(this).attr('data-info');
        var val=$(this).attr('data-val');
        var announce_type=$(this).attr('data-ann');
        $("#view_all"+info).html(val);

        var href=$("#view_all_href"+info).attr('href');
        href=href.replace('ann_type=1','ann_type='+announce_type);
        href=href.replace('ann_type=2','ann_type='+announce_type);
        $("#view_all_href"+info).attr('href',href);

    });


    $(".page_li").click(function(){
        if($(this).hasClass('active')) return false;

        var info=parseInt($(this).attr('data-tip'));
        var page=parseInt($(this).attr('data-page'));
        $('li[data-tip="'+info+'"').removeClass('active');
        $(this).addClass('active');

        var check_announce_type=$('div.rent_btn[data-info="'+info+'"]');
        var announce_type=1;
        if(check_announce_type.hasClass('active')) announce_type=2;

        var baseurl=$("#baseurl").val();
        var url=baseurl+"/site/get_home_announces/?property_type="+info+"&announce_type="+announce_type+"&limit=5&page="+page;
        $.post(url,function(data){
            if(announce_type==2) $("#"+info+"_rent").html(data);
            else $("#"+info+"_sale").html(data);
        });
    });


    $(".sekli_deyis").click(function(){
        $(this).siblings(".inp-file").click();
    });
    $(".inp-file").on('change',function()
    {
        var file_input_image=$("#file_input_image").val();
        if(file_input_image!='') $("#profil_edit_form").submit();
    });
    $('#profil_edit_form').on('submit', function (e) {
        e.preventDefault();

        var baseurl=$("#baseurl").val();
        $("#loading_gif").removeClass('hide');
        $.ajax({
            url: baseurl+"/profil/change_image",
            type: "POST",
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function (res) {
                if(res!='') { $("#profil_edit_img").attr('src',res); $("#error_image_upload").css('display','none'); }
                else $("#error_image_upload").css('display','block');
                $("#loading_gif").addClass('hide');
                $("#file_input_image").val('');
            }
        });
    });
    ///////////////////////////////////////////////////////////////////////////////

    //lang
    $(".lang").hover(function () {
        $(this).find("a").show();
    }, function () {
        $(this).find("a").each(function () {
            if ($(this).hasClass("active") === false) {
                $(this).hide();
            }
        });
    });

    $(".lang").each(function () {
        if ($(this).children("a").hasClass("active")) {
            var pdiv = $(this).prev('a');
            pdiv.insertBefore(pdiv.prev());
        }
    });

    //tabs
    $('#info .tabs-content:not(:first)').hide();

    $('#info-nav li').click(function (event) {
        event.preventDefault();
        $('#info-nav li.un_current').removeClass('un_current');
        $('#info').css('height','280px');
        var idi=$(this).data('id');
        $("#ann_type").val(idi);
        if(idi==2){
            $("p.tip_ch").hide();
            $("p.rent_ch").show();
            var ti1=$("#ti1").html();		$("#t_1").html(ti1);
            var ti2=$("#ti2").html();		$("#t_2").html(ti2);
            var alli=$("#alli").html();		$("#all_l").html(alli);
        }
        else{
            $("p.tip_ch").show();
            $("p.rent_ch").hide();
            var ts1=$("#ts1").html();		$("#t_1").html(ts1);
            var ts2=$("#ts2").html();		$("#t_2").html(ts2);
            var alls=$("#alls").html();		$("#all_l").html(alls);
        }

        $('#info .tabs-content').hide();
        $('#info-nav .current').removeClass("current");
        $(this).addClass('current');
        if ($(".search-form").hasClass('closed')) {
            $(".search-form").removeClass("closed");
        }

        var clicked = $(this).find('a:first').attr('href');
        $('#info ' + clicked).fadeIn('fast');

        var dataString = $("#search_blok").serialize();
        var baseurl=$("#baseurl").val();
        $.post(baseurl+"/elanlar/?"+dataString+"&ajax=1",function(data){
            $(".goster_button").html('('+data+')');
        });

    }).eq(0).addClass('current');

//equalHieght
    function equalHeight(group) {

        tallest = 0;

        group.each(function () {

            thisHeight = $(this).height();

            if (thisHeight > tallest) {

                tallest = thisHeight;

            }

        });

        group.height(tallest);

    }

    $(window).load(function () {
        if ($(".column-table .col").length > 0) {
            // equalHeight($(".column-table .col"));
        }
        if ($(".ticket-item").length > 0) {
            equalHeight($(".ticket-item"));
        }
        if ($(".news-list li h3").length > 0) {
            equalHeight($(".news-list li h3"));
        }
    });



    $('.tabs-panel, .tabs').each(function () {
        var par = $(this).children(".i-tab");
        if(par.hasClass('not_select')==false) par.children("div:first").addClass("active");
    });
    $('.tab-content').each(function () {
        var par=$(this).children(".tabs-main:first");
        if(par.hasClass('not_select')==false) par.css('display', 'block');
        else $(".show_this").css('display', 'block');
    });

    $('.i-tab').each(function () {
        $(this).delegate('div:not(.active)', 'click', function () {
            $(this).addClass('active').siblings().removeClass('active').parents('.tabs').find('.tab-content .tabs-main').hide()
                .eq($(this).index()).fadeIn('slow');
        });
    });

    //placeholder
    $('input,textarea').focus(function () {
        $(this).data('placeholder', $(this).attr('placeholder'))
        $(this).attr('placeholder', '');
    });
    $('input,textarea').blur(function () {
        $(this).attr('placeholder', $(this).data('placeholder'));
    });
//  popup premium
    $('.popup .close, .popup-overlay').click(function () {
        var check_google_map_popup=$('.popup.google_map').css('opacity');  //eger 1-dise demeli google mapdir aciq olan
        if($('.popup.google_map').length>0 && check_google_map_popup==1) showMap();

        $('body').removeClass('themodal-lock');
        $('.popup, .popup-overlay').css({'opacity': '0', 'visibility': 'hidden'});
        return false;
    });


    /*
     $('a.premium-l, .top-panel .premium-link, .top-panel .gg-link, .elan .boxed .item a').click(function (e) {
     $('.popup.premium, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
     e.preventDefault();
     });
     */
//            popup reg
    $('a.reg-links').click(function (e) {
        $('.popup, .popup-overlay').css({'opacity': '0', 'visibility': 'hidden'});
        $('body').addClass('themodal-lock');
        $('.popup.reg, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
//            popup entry
    $('a.entry-links').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.entry, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
//    alicinin_sifarishi nisangah
    $('.customer_order .order_tab_div button').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.upd-popup, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
    /*
     //            popup nisangah
     $('.area-links-1').click(function (e) {
     $('.popup.nisangah-1, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
     e.preventDefault();
     });
     */
//            popup nisangah2
    $('.area-links-2').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.nisangah-2, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });

//    Yaşayış komekpleksini yerləşdir
    $('.residential .popup-trigger').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.apartment, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
//    Şikayət etmək
    $('.elan .complaint-reason').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.complain, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
//    Dostuna etmək
    $('.elan .fr-send').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.send_friend, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
//    Email-s-popup
    $('.email-s').click(function (e) {
        $('.popup.email').css({'opacity': '0', 'visibility': 'hidden'});
        $('.popup.email-s-popup, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });

//    elanlara sms abune ol
    $('.sms-links').click(function (e) {
        //$('.popup.sms-abune, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
//    telefon nomreni tesdiqle
    $('.confirm-link').click(function (e) {
        $('.popup.sms-abune').css({'opacity': '0', 'visibility': 'hidden'});
        $('.popup.confirm, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
    //    email tesdiqle
    $('.email-tr').click(function (e) {
        $('.popup.sms-abune').css({'opacity': '0', 'visibility': 'hidden'});
        $('.popup.email-sb, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });

    //scrollbar here
    if ($('.wrapper-c').length > 0) {
        $('.wrapper-c').scrollbar();
    }

    //reset checkbox
    $(".reset-btn").click(function () {
        var checkbox = $(".jq-checkbox");
        if (checkbox.hasClass("checked")) {
            checkbox.removeClass("checked");
        }
        $(".rayon_home_check_click").removeClass('checked');    $(".rayon_home_check_click").prop('checked',false);
        $(".rayon_check_click").removeClass('checked');         $(".rayon_check_click").prop('checked',false);
//update text disable
        $(".jq-selectbox").each(function () {
            $(this).find(".jq-selectbox__select-text").text("")
            var drop = $(this).children('.jq-selectbox__dropdown')
            var updateTxt = drop.children('ul').children('li.disabled').text();
            $(this).find(".jq-selectbox__select-text").text(updateTxt);
        });

    });

//     $("p.tip_ch input[type=checkbox]").change(function () {
//
//         if ($(this).attr("checked"))
//         {
//             var checkbox = $(".jq-checkbox");
//             if (checkbox.hasClass("checked")) {
//                 checkbox.removeClass("checked");
//             }
//             $(".rayon_home_check_click").removeClass('checked');    $(".rayon_home_check_click").prop('checked',false);
//             $(".rayon_check_click").removeClass('checked');         $(".rayon_check_click").prop('checked',false);
// //update text disable
//             $(".jq-selectbox").each(function () {
//                 $(this).find(".jq-selectbox__select-text").text("")
//                 var drop = $(this).children('.jq-selectbox__dropdown')
//                 var updateTxt = drop.children('ul').children('li.disabled').text();
//                 $(this).find(".jq-selectbox__select-text").text(updateTxt);
//             });
//
//             $("ul.area-list li").remove();
//         }
//
//     });

    // search open
    $(".search-bottom button").click(function () {
        $(this).parent().hide();
        $(".search-form.closed").removeClass("closed");
    });


    // window scroll search fixed
    $(window).scroll(function () {
        if ($(".search-form").length > 0) {
            if ($(window).scrollTop() > 280) {

                $(".search-form").parent().addClass("fixed");
                $(".search-form").addClass("closed");
                $(".search-bottom").show();
                $(".head-panel").css({"marginBottom": 103});
                $('#info-nav li.current').addClass('un_current');
                $('#info').css('height','0px');
            }
            else if ($(window).scrollTop() <50) {
                $(".search-form").parent().removeClass("fixed");
                $(".search-form").removeClass("closed");

                $(".head-panel").css({"marginBottom": 10})
                $(".search-form").parent().removeClass("fixed");
                $('#info-nav li.un_current').removeClass('un_current');
                $('#info').css('height','280px');
            }

        }

    });

    $(".dropbox").hover(function () {
        $(this).children(".drop-list").slideDown();
    }, function () {
        $(this).children(".drop-list").stop().slideUp('fast');
    });

    if ($('.bxslider').length > 0) {
        $('.bxslider').bxSlider({
            pagerCustom: '#bx-pager'
        });
    }
    if ($('.bxslider1').length > 0) {
        $('.bxslider1').bxSlider({
            pagerCustom: '#bx-pager1'
        });
    }

    if ($('.bxslider2').length > 0) {
        $('.bxslider2').bxSlider({
            pagerCustom: '#bx-pager2'
        });
    }

    //radio active label
    $('.radios label').click(function () {
        $('.radios label ').removeClass('active');
        $(this).addClass('active');
    });
    //select active label
    $(window).load(function () {
        $('.jq-checkbox').each(function () {
            if ($(this).hasClass("checked")) {
                $(this).parent('label').addClass('active');
            }
            else {
                $(this).parent('label').removeClass('active');
            }
        });

    });
//    click checkbox addClass label
    $('.jq-checkbox').click(function () {
        if ($(this).hasClass("checked")) {
            $(this).parent('label').addClass('active');
        }
        else {
            $(this).parent('label').removeClass('active');
        }

    });

    //masked input
    if ($(".phone_number").length > 0) {
        var country=$("#country").val();
        if(country==1) $(".phone_number").mask("(999) 999-99-99");
    }
    if ($("#user_phone").length > 0) {
        $("#user_phone").mask("(999) 999-99-99");
    }

    $(".left_panel .green_button").click(function () {
        $(".right_panel .tabs").hide();
        $(this).parent().siblings(".tabs").toggle();
        return false;
    });
    $(".right_panel .green_button").click(function () {
        $(".left_panel .tabs").hide();
        $(this).parent().siblings(".tabs").toggle();
        return false;
    });

    //new
    // $("input.y_otaq").change(function () {
    //     var y_otaq_arr = [];
    //     var k_otaq_arr = [];
    //
    //     $('input.y_otaq:checked').each(function() {
    //         y_otaq_arr.push($(this).val());
    //     });
    //
    //     $('input.k_otaq:checked').each(function() {
    //         k_otaq_arr.push($(this).val());
    //     });
    //
    //     var largest = 0;
    //     var smallest = 0;
    //
    //     if(y_otaq_arr.length>0)
    //     {
    //         largest = Math.max.apply(Math, y_otaq_arr);
    //         smallest = Math.min.apply(Math, y_otaq_arr);
    //     }
    //     else if(k_otaq_arr.length>0)
    //     {
    //         largest = Math.max.apply(Math, k_otaq_arr);
    //         smallest = Math.min.apply(Math, k_otaq_arr);
    //     }
    //
    //     if($('input.y_otaq:checked').val()>0)
    //         $('select[name=property_type] option[value="1"]').attr("selected",true);
    //     else if($('input.k_otaq:checked').val()>0)
    //         $('select[name=property_type] option[value="2"]').attr("selected",true);
    //     else
    //         $('select[name=property_type] option[value="0"]').attr("selected",true);
    //
    //     $('select').trigger('refresh');
    //     $('input[name=room_min]').val(smallest);
    //     $('input[name=room_max]').val(largest);
    // });
    //
    // $("input.k_otaq").change(function () {
    //     var k_otaq_arr = [];
    //     var y_otaq_arr = [];
    //
    //     $('input.y_otaq:checked').each(function() {
    //         y_otaq_arr.push($(this).val());
    //     });
    //
    //     $('input.k_otaq:checked').each(function() {
    //         k_otaq_arr.push($(this).val());
    //     });
    //
    //     var largest = 0;
    //     var smallest = 0;
    //
    //     if(k_otaq_arr.length>0)
    //     {
    //         largest = Math.max.apply(Math, k_otaq_arr);
    //         smallest = Math.min.apply(Math, k_otaq_arr);
    //     }
    //     else if(y_otaq_arr.length>0)
    //     {
    //         largest = Math.max.apply(Math, y_otaq_arr);
    //         smallest = Math.min.apply(Math, y_otaq_arr);
    //     }
    //
    //     if($('input.k_otaq:checked').val()>0)
    //         $('select[name=property_type] option[value="2"]').attr("selected",true);
    //     else if($('input.y_otaq:checked').val()>0)
    //         $('select[name=property_type] option[value="1"]').attr("selected",true);
    //     else
    //         $('select[name=property_type] option[value="0"]').attr("selected",true);
    //
    //     $('select').trigger('refresh');
    //     $('input[name=room_min]').val(smallest);
    //     $('input[name=room_max]').val(largest);
    // });

//    $(".banner-left").each(function () {
//        var th = $(this);
//        var thw = th.children('a').width();
//        var updWidth = th.width(thw);
//        th.offset({left: - thw})
//        var position = th.position();
//        var getir = position.left;
//
//    });
});