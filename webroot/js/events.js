$(document).ready(function() {
	$('#EventFree').bind('click', function (e) {
		e.preventDefault();
		if($(this).attr('checked') == true)
		{
			$('#priceCounter').val(0);
			$('#pricesEvent').html('');
		}
	});

	$('#addEventPrice').bind('click', function (e) {
		e.preventDefault();
	 	var counter = parseInt($('#priceCounter').val());
	 	$.get(
	 		'../eventPriceAdd/',
	 		{ lastPriceIndex : counter },
	 		function(data) {
	 			$('#EventFree').attr('checked', false);
	 			$('#pricesEvent').append(data);
	 			$('#priceCounter').val(counter + 1);
	 			bindDatePicker();
	 		}
	 	);
	 });

	$('#addEventDate').bind('click', function (e) {
		e.preventDefault();
		var counter = parseInt($('#dateCounter').val());
		$.get(
			'../eventDateAdd/',
			{ lastDateIndex : counter },
			function(data) {
				$('#datesEvent').append(data);
				$('#dateCounter').val(counter + 1);
				bindDatePicker();
			}
		);
	});
});