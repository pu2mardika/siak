jQuery(document).ready(function () {
	if ( $('#kleper').length) {
		$('#kleper').DataTable();
	}
	
	if ( $('.data-tables').length) {
		$setting = $('#dataTables-setting');
		settings = {};
		if ($setting.length > 0) {
			settings = $.parseJSON($('#dataTables-setting').html());
		}
		$('.data-tables').DataTable(settings);
	}
});