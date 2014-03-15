$(document).ready(function() {
	$('#UsersOnline').ready(function() {
		$.getJSON('oswapi.php?t=onlineusercount', function(data) {
			$('#UsersOnline').html(data.value);
		});
	});
	$('#TotalUsers').ready(function() {
		$.getJSON('oswapi.php?t=totalusers', function(data) {
			$('#TotalUsers').html(data.value);
		});
	});
});