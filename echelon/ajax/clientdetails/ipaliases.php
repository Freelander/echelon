<?php
/**
 * This page is called by clientdetails.php within
 * extra client info block when clicked on "IP Aliases" tab.
 */

$auth_name = 'clients';
$b3_conn = true; // this page needs to connect to the B3 database
require('../../inc.php');

//Get client id and name
if($_GET['id'])
	$cid = $_GET['id'];
if($_GET['name'])
	$name = $_GET['name'];

?>
<table>
	<thead>
		<tr>
			<th>IP</th>
			<th>Times Used</th>
			<th>First Used</th>
			<th>Last Used</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(!$db->error) {
		$query = "SELECT ip, num_used, time_add, time_edit FROM ipaliases WHERE client_id = $cid ORDER BY time_edit DESC";
		$results = $db->query($query);
		$num_rows = $results['num_rows'];
		$data_set = $results['data'];
		
		if($num_rows > 0) {
			foreach($data_set as $data) {
				$ip = $data['ip'];
				$num_used = $data['num_used'];
				$time_add = $data['time_add'];
				$time_edit = $data['time_edit'];
				//format time
				$time_add = date($tformat, $time_add);
				$time_edit = date($tformat, $time_edit);

				$alter = alter();
				$output = <<<EOD
					<tr class="$alter">
						<td><strong>$ip</strong></td>
						<td>$num_used</td>
						<td><em>$time_add</em></td>
						<td><em>$time_edit</em></td>
					</tr>
EOD;
				echo $output;
			}
		} else {
			echo '<tr><td colspan="4">'.$name.' has no IP aliases.</td></tr>';
		}
	} else {
		echo $db->mysql->error;
	}
	?>
	</tbody>
</table>