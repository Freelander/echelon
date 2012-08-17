<?php
/**
 * Displays inactive admins with an ajax call.
 * Data is processed by ajax/active_ajax.php
 */
 
$page = "active";
$page_title = "Inactive Admins";
$auth_name = 'clients';

require 'inc.php';

## Require Header ##
require 'inc/header.php';
?>

<table id="active-dt" class="display" width="100%">
	<caption>Inactive Admins<small>List of admins who have not been seen by B3 for the selected duration.</small></caption>
	<thead>
		<tr>
			<th>Name</th>
			<th>Client-id</th>
			<th>Level</th>
			<th>Connections</th>
			<th>Last Seen</th>
			<th>Duration</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="6" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6">Click admin name to see details.</th>
		</tr>
	</tfoot>
</table>

<?php
require 'inc/footer.php'; 
?>