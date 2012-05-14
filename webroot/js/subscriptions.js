$(document).ready(function () {
	var eventIdElement = $('#jsEventId');
	var userIdElement = $('#jsUserId');

	$("#jsUserName").autocomplete({
		source: getUrl(eventIdElement),
		minLength: 1,
		select: function(event, ui) {
			userIdElement.val(ui.item.id);
		}
	});
});

function getUrl(el) {
	var eId = el.val();

	return "/admin/subscriptions/ajaxGetNonParticipants/" + eId;
}