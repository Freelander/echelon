<?php
/**
 * Displays a list of admin or b3 bans with an ajax call.
 * Data is processed by ajax/adminbans_ajax.php for admin bans
 * and ajax/b3bans_ajax.php for b3 bans
 */
 
if(!isset($_GET['t']))
	$t = 'b';
else
	$t = $_GET['t'];
	
if($t == 'a') {
	$page = "adminbans";
	$page_title = "Admin Bans";
} else {
	$page = "b3bans";
	$page_title = "B3 Penalties";
}

$auth_name = 'penalties';

require 'inc.php';

## Require Header ##
require 'inc/header.php';

if($t == 'a') {
	?>
	<table id="adminbans-dt" class="display" width="100%">
		<caption>Admin Bans<small>A list of bans that have been added by admins</caption>
		<thead>
			<tr>
				<th>Player</th>
				<th>Type</th>
				<th>Added</th>
				<th>Duration</th>
				<th>Expires</th>
				<th>Reason</th>
				<th>Admin</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="7" class="dataTables_empty">Loading data from server</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="7">Click client or admin name to see details.</th>
			</tr>
		</tfoot>
	</table>
	<?php
} else {
	?>
	<table id="b3bans-dt" class="display" width="100%">
		<caption>B3 Bans<small>A list of bans that have been added by BigBrotherBot</caption>
		<thead>
			<tr>
				<th>Player</th>
				<th>Type</th>
				<th>Added</th>
				<th>Duration</th>
				<th>Expires</th>
				<th>Reason</th>
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
}

require 'inc/footer.php'; 