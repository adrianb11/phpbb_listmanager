function loadcontent(f, t)
{
	let $listmanagercard = $('#list-manager-view-card');
	$("#elementreplace").load('./app.php/listmanager/get/topic?f=' + f + '&t=' + t);
	$listmanagercard.fadeIn(100, function() {
		$listmanagercard.show();
	});
	$('body').css('overflow','hidden');
}

function closecontent()
{
	let $listmanagercard = $('#list-manager-view-card');
	$listmanagercard.fadeOut(100, function() {
		$listmanagercard.hide();
	});
	$("#elementreplace").html("Please wait while the topic is loading...");
	$('body').css('overflow','auto');
}
