<?php
/**
 * Displays admins with an ajax call.
 * Data is processed by ajax/admins_ajax.php
 */
 
$page = "admins";
$page_title = "Admin Listing";
$auth_name = 'clients';

require 'inc.php';

## Require Header ##
require 'inc/header.php';
?>

<table id="admins-dt" class="display" width="100%">
	<caption>Admin Listing<small>A list of all registered admins</small></caption>
	<thead>
		<tr>
			<th>Name</th>
			<th>Level</th>
			<th>Client-id</th>
			<th>Connections</th>
			<th>Last Seen</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="5">Click admin name to see details.</th>
		</tr>
	</tfoot>
</table>

<?php
require 'inc/footer.php'; 
?>