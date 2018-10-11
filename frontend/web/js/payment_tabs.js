$(function () {
	
	var myWindow='';
	
	$(".submit_payment").click(function(){
		myWindow=window.open('', 'TheWindow', "toolbar=no, scrollbars=no, resizable=no, top=100, left=100, width=1000, height=550");
		document.getElementById('TheForm').submit();
		//myWindow.opener.document.write("<p>This is the source window!</p>");
	});
}


function closeAndRefreshSuccess(){
	//myWindow.opener.location.href='http://google.com/';
	myWindow.close();
}