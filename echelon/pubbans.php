<?php
/**
 * Displays public banlist data with an ajax call.
 * Data is processed by ajax/pubbans_ajax.php
 */

$auth_user_here = false;
$page = "pubbans";
$page_title = "Public Ban List";

require 'inc.php';

checkBL(); // check the blacklist for the users IP (this is needed because this is a public page)

## Require Header ##
require 'inc/header.php';
?>

<table id="pubbans-dt" class="display" width="100%">
	<caption>Public Ban List<small>List of active bans/tempbans for
		<form action="pubbans.php" method="get" id="pubbans-form" class="sm-f-select">
			<select name="game" onchange="this.form.submit()">
				<?php
				$games_list = $dbl->getGamesList();
				$i = 0;
				$count = count($games_list);
				$count--; // minus 1
				while($i <= $count) {
					if($game == $games_list[$i]['id'])
						$selected = 'selected="selected"';
					else
						$selected = NULL;

					echo '<option value="'. $games_list[$i]['id'] .'" '. $selected .'>'. $games_list[$i]['name'] .'</option>';

					$i++;
				}
				?>
			</select>
		</form>
	</caption>
	<thead>
		<tr>
			<th>Player</th>
			<th>Ban-id</th>
			<th>Type</th>
			<th>Added</th>
			<th>Duration</th>
			<th>Expires</th>
			<th>Reason</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="7" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>

<?php
require 'inc/footer.php'; 
?>