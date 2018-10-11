$(function() {

    $("#files").change(function()
    {
        $("#submit_form").trigger('click');
    });

    $('#insert_form').submit(function(e) {
            e.preventDefault();
            var last_bar=parseInt($("#last_bar").val());    last_bar++; $("#last_bar").val(last_bar);
            e.last_bar=last_bar;
            $('.pure-form').ajaxSubmit({
            beforeSend: function() {
                var files_val=$("#files").val();
                if(files_val!='')
                {
                    $(".progress").removeClass('hide');
                    var append='';
                    var files=$("#files").get(0).files.length;
                    var baseurl=$("#baseurl").val();
                    for(var i=1;i<=files;i++)
                    {
                        append+='<li>';
                            append+='<div class="li_div">';
                                append+='<div class="li_div2"><img class="uploading_image" src="'+baseurl+'/images/uploading_image.gif" alt="" /></div>';
                                append+='<div class="progress"><div class="bar bar'+e.last_bar+'"></div></div>';
                            append+='</div>';
                            append+='<a href="javascript:void(0);" degrees="0" class="delete_photo delete_photo_new" style="display: none"></a>';
                            append+='<a href="javascript:void(0);" class="turn_left turn_new rotate" style="display: none"></a>';
                            append+='<a href="javascript:void(0);" class="turn_right turn_new rotate" style="display: none"></a>';
                        append+='</li>';
                    }
                    $(".photo_list").append(append);
                }
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var pVel = percentComplete + '%';
                $('.bar'+ e.last_bar).width(pVel);
            },
            success: function(data) {
                var files_val=$("#files").val();
                var baseurl=$("#baseurl").val();
                if(files_val!='')
                {
                    var newImagesThumb=data.split('~~~');
                    var src=baseurl+'/images/uploading_image.gif';
                    var i=0;
                    $(".bar"+ e.last_bar).each(function()
                    {
                        var thiis=$(this).parents('div.li_div').children('div.li_div2').children('img');
                        if(newImagesThumb[i]!=null)
                        {
                            var new_src=baseurl+'/images/announces/temporary/thumb/'+newImagesThumb[i];
                            thiis.attr('src',new_src);
                            thiis.parents('.li_div').children('.progress').fadeOut('slow');
                            thiis.parents('li').children('a').fadeIn('slow');
                        }
                        i++;
                    });
                    //$("#files").val('');
                    var image_count=$(".photo_list li").length;
                    if(image_count>=4) $(".photo_error").addClass('unvisible');
                }
                else
                {
                    //alert(data);
                    console.debug(data);
                    data=data.split('-');
                    if(data[0]=='inserted' && data[1]>0) window.location.href = baseurl+'/elan-ver/ok/'+data[1];

                    // adminden edit edilib
                    else if(data[0]=='updatedAdmin') { window.close(); alert('Məlumatlar uğurla yadda saxlanıldı.'); }

                    // profilden edit edilib
                    else if(data[0]=='updatedUser'){
                        var backstatus=parseInt($("#gonder").attr('backstatus'));
                        window.location.href = baseurl+'/profil/elanlar?status='+backstatus;
                    }

                    // emaildeki linkden daxil edilib edit edilib
                    // else if(data[0]=='updatedAnnounce')

                    // admin update etdi. hecne deyiwmedi. (ve ya siralama deyiwdi)
                    else if(data[0]=='updatedSimpleAdmin') { window.close(); alert('Məlumatlar uğurla yadda saxlanıldı.'); }

                    // profilden edit edildi. hecne deyiwmedi. (ve ya siralama deyiwdi)
                    else if(data[0]=='updatedSimpleUser'){
                        var backstatus=parseInt($("#gonder").attr('backstatus'));
                        window.location.href = baseurl+'/profil/elanlar?status='+backstatus;
                    }
                }
            }
        });
    });







});