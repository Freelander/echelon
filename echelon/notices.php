<?php
/**
 * Displays notices with an ajax call.
 * Data is processed by ajax/notices_ajax.php
 */
 
$page = "notices";
$page_title = "Notices";
$auth_name = 'penalties';

require 'inc.php';

## Require Header ##
require 'inc/header.php';
?>

<table id="notices-dt" class="display" width="100%">
	<caption>Notices<small>List of notices, made by admins in the server(s)</small></caption>
	<thead>
		<tr>
			<th>Player</th>
			<th>Client-id</th>
			<th>Time Added</th>
			<th>Comment</th>
			<th>Admin</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="5">Click player name to see details.</th>
		</tr>
	</tfoot>
</table>

<?php
require 'inc/footer.php'; 
?>