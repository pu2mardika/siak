// Call the dataTables jQuery plugin
$(document).ready(function() {
   $('#table-view').DataTable({
      "responsive": true, 
      "paging": true,
      "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
      "lengthChange": true, 
      "autoWidth": false, 
      "scrollX": true,
    });	
});

