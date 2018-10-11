$(document).ready(function()
{
    $(".minimize").click(function()
    {
        var hasClass=$(".sidebar").hasClass('hide');
        if(hasClass==false){
			$(".sidebar").addClass('hide');
			$('.mainbar').css('margin-left','0px');
			$('.container').css('padding','0px');
		}
		else{
			$(".sidebar").removeClass('hide');
			$('.mainbar').css('margin-left','180px');
			$('.container').css('padding','15px');
		}
    });
	
	
	$(".showMyModal").click(function()
    {
        var idi=$(this).data('id');
        $(".myModal#"+idi).show('fast');
        $('.popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
    });
    $(".closeMyModal, .popup-overlay").click(function()
    {
        $(".myModal").hide('fast');
        $('.popup-overlay').css({'opacity': '0', 'visibility': 'hidden'});
    });

    $(".reasons_x").click(function()
    {
        var idi=$(this).parents('div.main_div').attr('data-idi');
        var r=$(this).attr('r');
        var hasClass=$(this).parent('div').hasClass('lightpink');
        if(hasClass==false)
        {
            $(this).parent('div').addClass('lightpink');
            var reasons=$("#reasons"+idi).val();
            reasons=reasons+r+'-'; $("#reasons"+idi).val(reasons);
        }
        else
        {
            $(this).parent('div').removeClass('lightpink');
            var reasons=$("#reasons"+idi).val();
            reasons=reasons.replace('-'+r+'-','-');
            $("#reasons"+idi).val(reasons);
        }
    });

    $(".edited_save").click(function(){
        var idi=$(this).parents('div').attr('data-idi');
        var editedi=$(this).parents('div').attr('data-edited');		if(editedi==0) var controller='announces'; else var controller='announces-edited';
        var reasons=$("#reasons"+idi).val();
        var status=$("#status").val();
        var imageChanged=$(".imageChanged").hasClass('btn-danger');	if(imageChanged==true) imageChanged=1; else imageChanged=0;
		var baseurl=$("#baseurl").val();
		url='?id='+idi+'&ok=1&status='+status+'&changeStatus=1&imageChanged='+imageChanged;
		console.debug(url);
		$("#ann_block_"+idi).hide('fast');
		$.post(baseurl+"/"+controller+"/jquery",{url:url},function(data){ console.debug(data); });
		//window.location.href = '?id='+idi+'&ok=1&status='+status+'&changeStatus=1&imageChanged='+imageChanged;
    });

    $(".edited_not_save").click(function()
    {
        var idi=$(this).parents('div').attr('data-idi');
		var editedi=$(this).parents('div').attr('data-edited');		if(editedi==0) var controller='announces'; else var controller='announces-edited';
        var baseurl=$("#baseurl").val();
        var reasons=$("#reasons"+idi).val();
        var status=$("#status").val();
		url='?id='+idi+'&reasons='+reasons+'&status='+status+'&changeStatus=3';
		console.debug(url);
		$("#ann_block_"+idi).hide('fast');
		$.post(baseurl+"/"+controller+"/jquery",{url:url},function(data){ });

        //window.location.href = '?id='+idi+'&reasons='+reasons+'&status='+status+'&changeStatus=3';
    });

    $(".delete_announce").click(function()
    {
        var idi=$(this).parents('div').attr('data-idi');
        var reasons=$("#reasons"+idi).val();
		var baseurl=$("#baseurl").val();
        var status=$("#status").val();
		url='?id='+idi+'&reasons='+reasons+'&status='+status+'&changeStatus=4';
		console.debug(url);
		$("#ann_block_"+idi).hide('fast');
		$.post(baseurl+"/announces/jquery",{url:url},function(data){ });
        //window.location.href = '?id='+idi+'&reasons='+reasons+'&status='+status+'&changeStatus=4';
    });

});