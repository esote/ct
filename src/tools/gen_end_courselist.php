<?php

/*

Print JavaScript required for courselist pages

*/

echo '<script src="style/datatables.js"></script>
<script>
	$(document).ready(function(){
		$("#datatable").dataTable({
			"pageLength": ', ((isset($_SESSION['counselor']) && $_SESSION['counselor'] === True) ? "10" : "25") , ',
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
			"order": [5, "asc"]
		});
	});
</script>';

