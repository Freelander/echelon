<?php
/**
 * Displays regular players with an ajax call.
 * Data is processed by ajax/regular_ajax.php
 */
 
$page = "regular";
$page_title = "Regular Pubbers";
$auth_name = 'clients';

require 'inc.php';

//Required config vars
$lenght = $config['cosmos']['reg_days']; // default length (in days) that the client must have connected to the server(s) on in order to be on the list
$connections_limit = $config['cosmos']['reg_connections']; // default number of connections that the player must have (in total) to be on the list

## Require Header ##
require 'inc/header.php';
?>

<table id="regular-dt" class="display" width="100%">
	<caption>
		Regulars
		<small>
			A list of players who are regular server go'ers on your servers, excluding clan members. 
			Must have more than <strong><?php echo $connections_limit; ?></strong> connections and been 
			seen in the last <strong><?php echo $lenght; ?></strong> days.
		</small>
	</caption>
	<thead>
		<tr>
			<th>Name</th>
			<th>Connections</th>
			<th>Client-id</th>
			<th>Level</th>
			<th>Last Seen</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>

<?php
require 'inc/footer.php'; 
?>