<?php
/**
 * Displays a list of admin or b3 kicks with an ajax call.
 * Data is processed by ajax/adminkicks_ajax.php for admin kicks
 * and ajax/b3kicks_ajax.php for b3 kicks
 */
 
if(!isset($_GET['t']))
	$t = 'a';
else
	$t = $_GET['t'];

if($t == 'a') {
	$page = "adminkicks";
	$page_title = "Admin Kicks";
	$type_admin = true;
} else {
	$page = "b3kicks";
	$page_title = "B3 Kicks";
	$type_admin = false; // this is not an admin page
}

$auth_name = 'penalties';

require 'inc.php';

## Require Header ##
require 'inc/header.php';

if($t == 'a') {
	?>
	<table id="adminkicks-dt" class="display" width="100%">
		<caption>Admin Kicks<small>A list of active kicks that have been added by admins</caption>
		<thead>
			<tr>
				<th>Client</th>
				<th>Kicked at</th>
				<th>Reason</th>
				<th>Admin</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="4" class="dataTables_empty">Loading data from server</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="4">Click client name to see details.</th>
			</tr>
		</tfoot>
	</table>
	<?php
} else {
	?>
	<table id="b3kicks-dt" class="display" width="100%">
		<caption>B3 Kicks<small>A list of active kicks that have been added by BigBrotherBot</caption>
		<thead>
			<tr>
				<th>Client</th>
				<th>Kicked at</th>
				<th>Reason</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="3" class="dataTables_empty">Loading data from server</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3">Click client name to see details.</th>
			</tr>
		</tfoot>
	</table>
	<?php
}

require 'inc/footer.php'; 
?>