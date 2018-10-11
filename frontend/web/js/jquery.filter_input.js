!function(e){e.fn.extend({filter_input:function(t){function n(a){var r=a.input?a.input:e(this);if(!a.ctrlKey&&!a.altKey){if("keypress"==a.type){var i=a.charCode?a.charCode:a.keyCode?a.keyCode:0;if((8==i||9==i||13==i||35==i||36==i||37==i||39==i||46==i)&&0==a.charCode&&a.keyCode==i)return!0;var s=String.fromCharCode(i);if(t.negkey&&s==t.negkey)return r.val().substr(0,1)==s?r.val(r.val().substring(1,r.val().length)).change():r.val(s+r.val()).change(),!1;var v=new RegExp(t.regex)}else{if("paste"==a.type)return r.data("value_before_paste",a.target.value),setTimeout(function(){n({type:"after_paste",input:r})},1),!0;if("after_paste"!=a.type)return!1;var s=r.val(),v=new RegExp("^("+t.regex+")+$")}return v.test(s)?!0:("function"==typeof t.feedback&&t.feedback.call(this,s),"after_paste"==a.type&&r.val(r.data("value_before_paste")),!1)}}var a={regex:".",negkey:!1,live:!1,events:"keypress paste"},t=e.extend(a,t),r=parseFloat(jQuery.fn.jquery.split(".")[0]+"."+jQuery.fn.jquery.split(".")[1]);return t.live?void(r>=1.7?e(this).on(t.events,n):e(this).live(t.events,n)):this.each(function(){var a=e(this);r>=1.7?a.off(t.events).on(t.events,n):a.unbind(t.events).bind(t.events,n)})}})}(jQuery);

$(document).ready(function()
{
	$('#name').filter_input({regex:'[A-Z a-zа-яА-ЯÜÖĞƏÇŞüöğıəçşİ]'});
	$("#room_count").filter_input({regex:'[0-9]'});
	$("#room_count_min").filter_input({regex:'[0-9]'});
	$('#room_count_max').filter_input({regex:'[0-9]'});
	$('#mobile1').filter_input({regex:'[0-9 ()+-]'});
	$('#mobile2').filter_input({regex:'[0-9 ()+-]'});
	$('#mobile3').filter_input({regex:'[0-9 ()+-]'});
	$('#space').filter_input({regex:'[0-9.,]'});
	$('#space_min').filter_input({regex:'[0-9]'});
	$('#space_max').filter_input({regex:'[0-9]'});
	$('#price').filter_input({regex:'[0-9.,]'});
	$('#price_min').filter_input({regex:'[0-9]'});
	$('#price_max').filter_input({regex:'[0-9]'});
	$('#floor_count').filter_input({regex:'[0-9]'});
	$('#current_floor_count').filter_input({regex:'[0-9]'});
});