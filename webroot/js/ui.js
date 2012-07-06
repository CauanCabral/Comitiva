$(document).ready(function() {
	bindDatePicker();

	$('table.jsRowSelect tr').click(function(e) {
		$(this).find('td:first input[type=radio]').attr('checked', 'checked');
	})
});

function bindDatePicker()
{
	$('.jsDatepicker').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true,
		language: 'br'
	});
}