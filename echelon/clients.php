<?php
/**
 * Displays client data with an ajax call.
 * Data is processed by ajax/clients_ajax.php
 */
 
$page = "client";
$page_title = "Clients Listing";
$auth_name = 'clients';

require 'inc.php';

## Require Header ##
require 'inc/header.php';
?>

<table id="clients-dt" class="display" width="100%">
	<caption>
		Client Listing <small>A list of all players who have ever connected to the server.</small>
	</caption>
	<thead>
		<tr>
			<th>Client-id</th>
			<th>Name</th>
			<th>Level</th>
			<th>Connections</th>
			<th>First Seen</th>
			<th>Last Seen</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="6" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6">Click client name to see details.</th>
		</tr>
	</tfoot>
</table>

<?php
require 'inc/footer.php'; 
?>