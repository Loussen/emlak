$(function () {
    $("#davam_edin").click(function() { checkPhone(); return false; });
    $("#gonder").click(function() { checkPhone('checkAnnounceForm()'); });

    $("#announce_type").change(function(){
        $(".announce_type_row span.error").addClass('unvisible');
        var property_type_val=$("#property_type").val();
        if($(this).val()==2 && property_type_val!=5 && property_type_val!=6 && property_type_val!=7 && property_type_val!=8)
        {
            $('.rent_type').removeClass('hide');
        }
        else
        {
            $('.rent_type').addClass('hide');
        }
    });
    $("#country").change(function(){
        if($(this).val()==1)
        {
            $('.city_row').removeClass('hide');
            var val=$("#city").val();
            if(val==3)
            {
                $('.region_row').removeClass('hide');
                $('.settlement_row').removeClass('hide');
                $('.metro_row').removeClass('hide');
                $('.mark_row').removeClass('hide');
            }
            else
            {
                $('.region_row').addClass('hide');
                $('.settlement_row').addClass('hide');
                $('.metro_row').addClass('hide');
                $('.mark_row').addClass('hide');
            }
        }
        else
        {
            var m1=$("#mobile1").attr("data-old");  $("#mobile1").val(m1);
            var m2=$("#mobile2").attr("data-old");  $("#mobile2").val(m2);
            var m3=$("#mobile3").attr("data-old");  $("#mobile3").val(m3);
			$('.city_row').addClass('hide');
            $('.region_row').addClass('hide');
            $('.settlement_row').addClass('hide');
            $('.metro_row').addClass('hide');
            $('.mark_row').addClass('hide');
        }
    });
    $("#city").change(function()
    {
        if($(this).val()==3)
        {
            $('.region_row').removeClass('hide');
            $('.settlement_row').removeClass('hide');
            $('.metro_row').removeClass('hide');
            $('.mark_row').removeClass('hide');
        }
        else
        {
            $('.region_row').addClass('hide');
            $('.settlement_row').addClass('hide');
            $('.metro_row').addClass('hide');
            $('.mark_row').addClass('hide');
        }
    });
    $("#property_type").change(function()
    {
        $(".jq-selectbox__dropdown").css('width','300px');
        $(".property_type_row span.error").addClass('unvisible');
        var val=parseInt($(this).val()); var sahe_vahidi_m=$("#sahe_vahidi_m").html(); var sahe_vahidi_s=$("#sahe_vahidi_s").html();
        if(val==7) $("#sahe_vahidi").html(sahe_vahidi_s); else $("#sahe_vahidi").html(sahe_vahidi_m);

        $('.space_row').removeClass('hide');
        // gunluk icareni legv edir.... bezi tiplerde...
        if(val==5 || val==6 || val==7 || val==8) $('.rent_type').addClass('hide');
        else
        {
            var announce_type_val=$("#announce_type").val();
            if(announce_type_val==2) $('.rent_type').removeClass('hide');
        }

        if(val==1 || val==2 || val==5)        // kohne tikili, yenitikili, ofis
        {
            $('.room_count_row').removeClass('hide');
            $('.floor_count_row').removeClass('hide');
            $('.repair_row').removeClass('hide');
            $('.current_floor_row').removeClass('hide');    // yalniz ofisde mecbur deyil...
        }
        else if(val==3 || val==4 || val==8 || val==10)         // ev/villa ,  bag evi,  obyekt
        {
            $('.room_count_row').removeClass('hide');
            $('.floor_count_row').removeClass('hide');
            $('.repair_row').removeClass('hide');

            $('.current_floor_row').addClass('hide');
        }
        else if(val==6)         // qaraj
        {
            $('.repair_row').removeClass('hide');

            $('.room_count_row').addClass('hide');
            $('.floor_count_row').addClass('hide');
            $('.current_floor_row').addClass('hide');
        }
        else if(val==7)         // torpaq
        {
            $('.room_count_row').addClass('hide');
            $('.repair_row').addClass('hide');
            $('.floor_count_row').addClass('hide');
            $('.current_floor_row').addClass('hide');
        }
        else
        {
            $('.room_count_row').addClass('hide');
            $('.repair_row').addClass('hide');
            $('.floor_count_row').addClass('hide');
            $('.current_floor_row').addClass('hide');
            $('.space_row').addClass('hide');
            $('.rent_type').addClass('hide');
        }
    });
    $("#current_floor").blur(function() { if($(this).val()>0) $(this).parent('label').children('span.error').addClass('unvisible'); });
    $("#floor_count").blur(function()
    {
        var current_floor=parseInt($("#current_floor").val());
        var floor_count=parseInt($("#floor_count").val());
        if(parseInt($(this).val())>0 && parseInt($(this).val())>=current_floor) $(this).parent('label').children('span.error').addClass('unvisible');
		var property_type=parseInt($("#property_type").val());
		if( (property_type==3 || property_type==4 || property_type==8) && floor_count>0) $(this).parent('label').children('span.error').addClass('unvisible');
    });
    $("#room_count").blur(function()  { if(parseInt($(this).val())>0) $(this).parent('label').children('span.error').addClass('unvisible'); });
    $("#repair").change(function() { $(".repair_row span.error").addClass('unvisible'); });
    $("#space").blur(function() { if($(this).val()>0) $(this).parent('label').children('span.error').addClass('unvisible'); });
    $("#document").change(function() { $(".document_row span.error").addClass('unvisible'); });
    $("#price").blur(function() { if($(this).val()>0) $(this).parent('label').children('span.error').addClass('unvisible'); });
    $("#city").change(function() { $(".city_row span.error").addClass('unvisible'); });
    $("#address").blur(function() { if($(this).val()>0) $(this).parent('label').children('span.error').addClass('unvisible'); });
    $("#show_announce_rules").click(function(e)
    {
        e.preventDefault();
        $('body').addClass('themodal-lock');
        $('.popup.announce_rules, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
    });

    $(".add_photo").click(function() { $("#files").trigger('click'); });

    //add phone
    $(".add_field").click(function (e) {
        var $th = $(this);
        $th.parent().siblings(".hidden-phone").first().removeClass("hidden-phone");
        if ($('.hidden-phone').length == 0) {
            $th.hide();
        }
        e.preventDefault();
    });
    //delete phone field
    $('.delete_field').click(function () {
        $(this).parent().addClass('hidden-phone');
        $(this).parent().children('input').val('');
        if ($('.hidden-phone').length > 0) {
            $('.add_field').fadeIn();
        }
        return false;
    });

    // email title
    if ($('input[note="title"]').length > 0) {
        $('input[note="title"]').poshytip({
            className: 'tip-yellowsimple',
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            offsetX: 15,
            offsetY: 5,
            showTimeout: 100
        });
    }

    // olke change
    $("#country").on('change',function()
    {
        var val=$(this).val();
        if(val!=1) $(".phone_number").unmask();
        else $(".phone_number").mask("(999) 999-99-99");
    });

    $('.radios input[type="radio"]').on('change',function()
    {
        $(".radios label").removeClass('active');
        $(this).parent('label').addClass('active');
    });

    $(".styled_line input").focus(function() {
        if($(this).closest('.field_info')) $(this).parents().children('.field_info').addClass('visible');
    }).focusout(function(){
        if($(this).closest('.field_info')) $(this).parents().children('.field_info').removeClass('visible');
    });

    $(".styled_line textarea").focus(function() {
        if($(this).closest('.field_info')) $(this).parents().children('.field_info').addClass('visible');
    }).focusout(function(){
        if($(this).closest('.field_info')) $(this).parents().children('.field_info').removeClass('visible');
    });

    // popup nisangah
    $('.area-links-1').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.nisangah-1, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });

    $(".nisangah_check_click").click(function (e) {
        e.preventDefault();
        var baseurl=$("#baseurl").val();
        var val='-';
        $( ".nisangah_check_click:checked" ).each(function( ) {
            val+=$(this).val()+'-';
        });
        $.post(baseurl+"/elan-ver/marks_select",{val:val},function(data)
        {
            $(".area-list").html(data);
        });
    });
    $("#rest_marks").click(function (e) {
        e.preventDefault();
        var baseurl=$("#baseurl").val();
        var val='-';
        $.post(baseurl+"/elan-ver/marks_select",{val:val},function(data)
        {
            $(".area-list").html(data);
        });
    });
    // delete area list
    $(document).delegate('.area-list li .remove', 'click',function(e)
    {
        e.preventDefault();
        $("#nisangah_checkbox"+$(this).data('id')+"-styler").trigger('click');
        $(this).parent().remove();
    });

    $(".map_button").click(function(e){
        $('body').addClass('themodal-lock');
        $('.popup.google_map, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });

    $(document).delegate('.delete_photo','click', function()
    {
        var e=$(this);
        var thumbImage=e.parent('li').children('div').children('div').children('img').attr('src');
        thumbImage=thumbImage.split('images/');  thumbImage=thumbImage[1];
        var baseurl=$("#baseurl").val();
        var temporaryImage=e.hasClass('delete_photo_new');  if(temporaryImage==true) temporaryImage=1; else temporaryImage=0;
        $.post(baseurl+"/elan-ver/delete_image",{thumbImage:thumbImage,temporaryImage:temporaryImage},function(data)
        {
            e.parent('li').remove();
        });
    });

    $(document).delegate('.rotate','click', function()    // rotate
    {
        var e=$(this);
        var wait=e.parent('li').hasClass('wait');
        if(wait==false)
        {
            var action=e.hasClass('turn_left'); if(action==true) action='left'; else action='right';
            e.parent('li').addClass('wait');
            e.parent('li').children('div').children('div').children('img').css('opacity','0.3');
            var thumbImage=e.parent('li').children('div').children('div').children('img').attr('src');
            thumbImage=thumbImage.split('images/');  thumbImage=thumbImage[1];
            var baseurl=$("#baseurl").val();
            var temporaryImage=e.hasClass('turn_new');  if(temporaryImage==true) temporaryImage=1; else temporaryImage=0;
            $.post(baseurl+"/elan-ver/rotate",{thumbImage:thumbImage,temporaryImage:temporaryImage,action: action},function(data) {
                //alert(data);
                if(data=='rotated') {
                    var hidden_rotate=parseInt(e.parent('li').children('.delete_photo').attr('degrees'));
                    if(action=='left') hidden_rotate-=90; else hidden_rotate+=90;
                    e.parent('li').children('div').children('div').children('img').rotate({
                        duration: 1000,
                        animateTo:hidden_rotate
                    });
                    if(hidden_rotate%360==0) hidden_rotate=0;
                    e.parent('li').children('.delete_photo').attr('degrees',hidden_rotate);
                }
                e.parent('li').removeClass('wait');
                e.parent('li').children('div').children('div').children('img').css('opacity','1');
            });
        }
    });

});

function checkPhone(go_function)
{
    var name=$("#name").val();
    var country=parseInt($("#country").val());
    var mobile1=$("#mobile1").val(); var mobile2=$("#mobile2").val(); var mobile3=$("#mobile3").val();
    var email=$("#email").val();		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var announcer1=$("#announcer1").val(); var elan1_checked=$("#announcer1").prop("checked");
    var announcer2=$("#announcer2").val(); var elan2_checked=$("#announcer2").prop("checked");
    var announce_id=$("#announce_id").val();
    var baseurl=$("#baseurl").val();
    var has_error=false;
    $.post(baseurl+"/elan-ver/check_phone",{mobile1:mobile1,mobile2:mobile2,mobile3:mobile3,email:email,country:country,announce_id:announce_id},function(data)
    {
        //alert(data);
        var tel_result=data;
        tel_result=tel_result.split('***');
        //$result[0]=> nomrenin duzgun ve ya yanliw olmagi...
        //$result[1]=> nomrenin pulsuz elan yerlewdirme balansinin qaligi...
        //$result[2]=> nomrenin elan paketi qalib yoxsa qutarib onu gosterir...
        //$result[3]=> nomrenin qara siyahida olub olmamasini deyir...
        //$result[4]=> profilin elan yerlewdirme balansi qalib yoxsa qutarib onu gosterir...
        //$result[5]=> emailin duzgun olub olmamasini yoxlayir.

        if(tel_result[3]==1) { $(".block_number").fadeIn('normal'); has_error=true; }
        else if(name!='')
        {
			tel_result[1]=parseInt(tel_result[1]);	if(tel_result[1]<0) tel_result[1]=0;
			tel_result[2]=parseInt(tel_result[2]);	if(tel_result[2]<0) tel_result[2]=0;
			tel_result[4]=parseInt(tel_result[4]);	if(tel_result[4]<0) tel_result[4]=0;
			var balance_span=tel_result[1]+tel_result[2]+tel_result[4];
			$(".block_number").fadeOut('normal');
            if(balance_span>0) $(".limit_full").fadeOut('fast');
            else { $(".limit_full").fadeIn('normal'); has_error=true; } // pulsuz elan limiti yoxdur

            if(tel_result[0]==0) has_error=true; // nomre duzgun formada daxil edilmiyib..
            else
            {
                $(".yellow_label").hide();
                $(".white_label").fadeIn('normal');
                $("#balance_span").html(balance_span);
            }

            if(elan1_checked==true || elan2_checked==true) $(".announce_choose").fadeOut('normal');
            else has_error=true; // elani veren secilmeyib...

            if(country>0) $(".country_choose").fadeOut('normal');
            else has_error=true; // elani veren secilmeyib...
        }

        if(name=='') { $("#name").focus(); has_error=true; }
        else if(country==0) { $(".country_choose").fadeIn('normal'); has_error=true; }
        else if( (mobile1=='' && mobile2=='' && mobile3=='') || (tel_result[0]==0) ) { $("#mobile1").focus(); has_error=true; }
        else if(email=='' || !emailReg.test(email)) { $("#email").focus(); has_error=true; }
        else if(elan1_checked==false && elan2_checked==false) { $(".announce_choose").fadeIn('normal'); has_error=true; }

        if(has_error==false)
        {
            $(".all_add_inputs").removeClass('with_overlay');
            if(go_function=='checkAnnounceForm()') checkAnnounceForm();
            else $("#gonder").removeClass('disabled');
        }
        else {
            console.debug();
            $(".all_add_inputs").addClass('with_overlay'); $("#gonder").addClass('disabled');
            $('html, body').animate({ scrollTop: 280 }, 'slow');
        }
    });
}

function checkAnnounceForm()
{
    var announce_type=$("#announce_type").val();
    var property_type=$("#property_type").val();
    var floor_count=$("#floor_count").val();
    var current_floor=$("#current_floor").val();
    var room_count=$("#room_count").val();
    var repair=$("#repair").val();
    var space=$("#space").val();             var sahe_vahidi_m=$("#sahe_vahidi_m").html(); var ground_space=$("#ground_space").val();
    var document=$("#document").val();
    var price=$("#price").val();
    var city=$("#city").val();  var country=$("#country").val();
    var address=$("#address").val();
    var region=$("#region").val();
    var settlement=$("#settlement").val();
    var metro=$("#metro").val();
    var rent_type=$("#rent_type").val();
    var text=$("#text").val();
    var map_content=$(".map_content").hasClass('hide'); // eger true deyeri qaytarirsa demeli xeriteni secmeyib...
    var submit_permission=$("#gonder").hasClass('disabled'); // eger true deyeri qaytarirsa demeli gozlemeliyik
    var image_count=$(".photo_list li").length;

    var baseurl=$("#baseurl").val();
    var loadingImage=$('img[src="'+baseurl+'/images/uploading_image.gif"]').length;

    var error_pos='';
    if(announce_type=='') { $(".announce_type_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='announce_type'; }
    if(property_type=='') { $(".property_type_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='property_type'; }
    if( (room_count=='' || room_count<=0) && (property_type!=6 && property_type!=7 && property_type!='') )
    {
        $(".room_count_row span.error").removeClass('unvisible');
        if(error_pos=='') error_pos='room_count';

    }
    if( (space=='' || space<=0) && property_type!='') { $(".space_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='space'; }
    if( (current_floor=='' || current_floor<=0) && (property_type==1 || property_type==2 || property_type==5) )
    {
        $(".current_floor_row span.error").removeClass('unvisible');
        if(error_pos=='') error_pos='current_floor';
    }
    else if( (floor_count=='' || floor_count<0) && (property_type!=6 && property_type!=7 && property_type!='') )
    {
        $(".floor_count_row span.floor_count_row_error2").addClass('unvisible');
        $(".floor_count_row span.floor_count_row_error2").addClass('hide');
        $(".floor_count_row span.floor_count_row_error1").removeClass('unvisible');
        $(".floor_count_row span.floor_count_row_error1").removeClass('hide');
        if(error_pos=='') error_pos='floor_count';
    }
    else if(floor_count>0 && parseInt(floor_count)<parseInt(current_floor))
    {
        $(".floor_count_row span.floor_count_row_error2").removeClass('unvisible');
        $(".floor_count_row span.floor_count_row_error2").removeClass('hide');
        $(".floor_count_row span.floor_count_row_error1").addClass('unvisible');
        $(".floor_count_row span.floor_count_row_error1").addClass('hide');
        if(error_pos=='') error_pos='floor_count';
    }
    if( repair=='' && property_type!=7 && property_type!='') { $(".repair_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='repair'; }
    if(document=='') { $(".document_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='document'; }
    if(price=='' || price<=0) { $(".price_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='price'; }
    if(text=='') { $(".field_info").addClass('visible'); $(".field_info").css('color','red'); if(error_pos=='') error_pos='text'; }
    if( (city=='' || city<=0) && country==1) { $(".city_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='city'; }
    if(address=='') { $(".address_row span.error").removeClass('unvisible'); if(error_pos=='') error_pos='address'; }
    if(map_content==true && country==1) { $(".map_error").removeClass('unvisible'); if(error_pos=='') error_pos='map_button'; }
    if(image_count<4) { $(".photo_error").removeClass('unvisible'); if(error_pos=='') error_pos='image_count'; }

    if(error_pos!='') { $("html, body").animate({ scrollTop: $('.'+error_pos+'_row').offset().top-100 }, 500); }
    else
    {
        if(loadingImage>0) alert('Zəhmət olmasa gözləyin. Şəkil yüklənir');
        else //if(submit_permission==true) alert('Zəhmət olmasa gözləyin. Məlumatlar yoxlanılır...');
        {
            var all_images='';
            var baseurl=$("#baseurl").val();
            $(".photo_list li div div img").each(function()
            {
                var src=$(this).attr('src');
                src=src.split("/");    src = src[src.length-1];
                all_images+=src+',';
            });

            $(".delete_photo").each(function(){
                var degrees=$(this).attr('degrees');
                if(degrees!=0) { $("#rotated").val(1); return false; }
            });
            var all_marks='';
            $(".nisangah_check_click:checked").each(function()
            {
                var val=$(this).val();
                all_marks+=val+'-';
            });
            $("#selected_marks").val(all_marks);

            $.post(baseurl+"/elan-ver/images_sort",{all_images:all_images},function(data)
            {
                console.debug(data);
                $("#files").val('');
                $("#gonder").addClass('disabled');
                $(".loading_btn").show();
                $("#submit_form").trigger('click');
            });
        }
    }
}

function showMap(){
    var google_map=$("#google_map").val();
    if(google_map!='(40.40983633607086, 49.86763000488281)') //
    {
        google_map=google_map.replace('(','');	google_map=google_map.replace(')',''); google_map=google_map.replace(' ','');
        $(".map_display").attr('src','http://maps.google.com/maps/api/staticmap?center='+google_map+'&zoom=14&size=600x230&maptype=roadmap&sensor=false&language=&markers=color:red|label:none|'+google_map);
        $(".map_display").show();
        initialize();
        $(".map_content").removeClass('hide');
        $(".map_error").addClass('unvisible');
    }
}

function initialize(){
    var google_map=$("#google_map").val();
    google_map=google_map.replace('(','');
    google_map=google_map.replace(')','');
    google_map=google_map.split(', ');

    var latLng = new google.maps.LatLng(google_map[0], google_map[1]);
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 14,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
        position: latLng,
        title: 'Point A',
        map: map,
        draggable: true
    });
    google.maps.event.addListener(map, 'click', function(event) {
        document.getElementById('google_map').value=event.latLng;
        marker.setMap(null);
        marker = new google.maps.Marker({
            position: event.latLng,
            title: 'Point A',
            map: map,
            draggable: true
        });
    });
    google.maps.event.addListener(marker, 'dragend', function(event) {
        document.getElementById('google_map').value=marker.getPosition();
    });
}
google.maps.event.addDomListener(window, 'load', initialize);