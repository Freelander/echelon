<?php
/**
 * This page is called by clientdetails.php within
 * extra client info block when clicked on "Penalties" or
 * "Admin Actions" tabs.
 */

$auth_name = 'clients';
$b3_conn = true; // this page needs to connect to the B3 database
require('../../inc.php');

//Get client id and name
if($_GET['id'])
	$cid = $_GET['id'];
if($_GET['name'])
	$name = $_GET['name'];
if($_GET['type'])
	$ptype = $_GET['type'];

?>
<table>
	<thead>
		<tr>
			<th></th>
			<th>Type</th>
			<th>Added</th>
			<th>Duration</th>
			<th>Expires</th>
			<th>Reason</th>
			<?php if($ptype == 'penalties') {
				?>
				<th>Admin</th>
			<?php
			} else {
			?>
				<th>Client</th>
			<?php
			}
			?>
		</tr>
	</thead>
	<tbody>
	<?php
	if(!$db->error) {
		if($ptype == 'penalties') {
			$query = "SELECT p.id, p.type, p.time_add, p.time_expire, p.reason, p.data, p.inactive, p.duration, 
			COALESCE(c.id,'1') as admin_id, COALESCE(c.name, 'B3') as admin_name 
			FROM penalties p LEFT JOIN clients c ON c.id = p.admin_id WHERE p.client_id = $cid ORDER BY id DESC";
		} elseif($ptype == 'adminactions') {
			$query = "SELECT p.id, p.type, p.time_add, p.time_expire, p.reason, p.data, p.inactive, p.duration, 
			COALESCE(c.id,'1') as admin_id, COALESCE(c.name, 'B3') as admin_name 
			FROM penalties p LEFT JOIN clients c ON c.id = p.client_id WHERE p.admin_id = $cid ORDER BY id DESC";
		}

		$results = $db->query($query);
		$num_rows = $results['num_rows'];
		$data_set = $results['data'];

		if($num_rows > 0) {
			foreach($data_set as $penalty) {
				$pid = $penalty['id'];
				$type = $penalty['type'];
				$time_add = $penalty['time_add'];
				$time_expire = $penalty['time_expire'];
				$duration = $penalty['duration'];
				$reason = $penalty['reason'];
				$data = $penalty['data'];
				$inactive = $penalty['inactive'];
				$admin_id = $penalty['admin_id'];
				$admin_name = $penalty['admin_name'];

				//format raw data
				$time_add = date($tformat, $time_add);
				$reason = tableClean(removeColorCode($reason));
				$data = tableClean($data);
				$admin_name = tableClean($admin_name);
				$time_expire_read = timeExpire($time_expire, $type, $inactive);

				if($admin_id != 1) // if admin is not B3 show clientdetails link else show just the name
					$admin_link = '<a href="clientdetails.php?id='.$admin_id.'" title="View the client\'s page">'.$admin_name.'</a>';
				else
					$admin_link = $admin_name;

				if($type != 'Kick' && $type != 'Notice' && $time_expire != '-1')
					$duration = time_duration($duration*60, 'yMwdhm'); // all penalty durations are stored in minutes, so multiple by 60 in order to get seconds
				else
					$duration = '';

				if($mem->reqLevel('unban')) // if user has access to unban show unban button
					$unban = unbanButton($pid, $cid, $type, $inactive);
				else
					$unban = '';

				if($mem->reqLevel('edit_ban')) // if user  has access to edit bans show the button
					$edit_ban = editBanButton($type, $pid, $inactive);
				else
					$edit_ban = '';

				$alter = alter();
				$output = <<<EOD
					<tr class="$alter">
						<td>$pid<br /> $unban $edit_ban</td>
						<td>$type</td>
						<td>$time_add</td>
						<td>$duration</td>
						<td>$time_expire_read</td>
						<td>$reason<br /><em>$data</em></td>
						<td>$admin_link</td>
					</tr>
EOD;
				echo $output;
			}
		} else {
			if($ptype == 'penalties') {
				echo '<tr><td colspan="7">'.$name.' has no penalties.</td></tr>';
			} else {
				echo '<tr><td colspan="7">'.$name.' has no admin actions.</td></tr>';
			}
		}
	} else {
		echo $db->mysql->error;
	}
	?>
	</tbody>
</table>