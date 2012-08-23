<?php
/**
 * This page is called by clientdetails.php within
 * extra client info block when clicked on "Echelon Logs" tab.
 */

$auth_name = 'clients';
$b3_conn = true; // this page needs to connect to the B3 database
require('../../inc.php');

//Get client id and name
if($_GET['id'])
	$cid = $_GET['id'];
if($_GET['name'])
	$game = $_GET['game'];

$ech_logs = $dbl->getEchLogs($cid, $game);

?>

<table>
	<thead>
		<tr>
			<th>id</th>
			<th>Type</th>
			<th>Message</th>
			<th>Time Added</th>
			<th>Admin</th>
		</tr>
	</thead>
	<tfoot>
		<tr><th colspan="5"></th></tr>
	</tfoot>
	<tbody>
		<?php displayEchLog($ech_logs, 'client'); ?>
	</tbody>
</table>