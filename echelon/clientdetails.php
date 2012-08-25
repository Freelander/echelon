<?php
$page = "clientdetails";
$page_title = "Client Details";
$auth_name = 'clients';
$b3_conn = true; // this page needs to connect to the B3 database
$pagination = false; // this page requires the pagination part of the footer
require 'inc.php';

## Do Stuff ##
if($_GET['id'])
	$cid = $_GET['id'];

if(!isID($cid)) :
	set_error('The client id that you have supplied is invalid. Please supply a valid client id.');
	send('clients.php');
endif;
	
if($cid == '') {
	set_error('No user specified, please select one');
	send('clients.php');
}

## Get Client information ##
$query = "SELECT c.ip, c.connections, c.guid, c.name, c.mask_level, c.greeting, c.time_add, c.time_edit, c.group_bits, g.name
		  FROM clients c LEFT JOIN groups g ON c.group_bits = g.id WHERE c.id = ? LIMIT 1";
$stmt = $db->mysql->prepare($query) or die('Database Error '. $db->mysql->error);
$stmt->bind_param('i', $cid);
$stmt->execute();
$stmt->bind_result($ip, $connections, $guid, $name, $mask_level, $greeting, $time_add, $time_edit, $group_bits, $user_group);
$stmt->fetch();
$stmt->close();

## Require Header ##
$page_title .= ' '.$name; // add the clinets name to the end of the title

require 'inc/header.php';
?>
<table class="cd-table">
	<caption><img src="images/cd-page-icon.png" width="32" height="32" alt="" /><?php echo $name; ?><small>Everything B3 knows about <?php echo $name; ?></small></caption>
	<tbody>
		<tr>
			<th>Name</th>
				<td><?php echo  tableClean($name); ?></td>
			<th>@id</th>
				<td><?php echo $cid; ?></td>
		</tr>
		<tr>
			<th>Level</th>
				<td><?php 
					if($user_group == NULL)
						echo 'Un-registered';
					else
						echo $user_group; 
					?>
				</td>
			<th>Connections</th>
				<td><?php echo $connections; ?></td>
		</tr>
		<tr>
			<th>GUID</th>
				<td>
				<?php echo guidLink($mem, $config['game']['game'], $guid); ?>
				</td>
			<th>IP Address</th>
				<td>
					<?php
					$ip = tableClean($ip);
					if($mem->reqLevel('view_ip')) :
						if ($ip != "") { ?>
							<a href="clients.php?s=<?php echo $ip; ?>&amp;t=ip" title="Search for other users with this IP adreess"><?php echo $ip; ?></a>
								&nbsp;&nbsp;
							<a href="http://whois.domaintools.com/<?php echo $ip; ?>" title="Whois IP Search"><img src="images/id_card.png" width="16" height="16" alt="W" /></a>
								&nbsp;&nbsp;
							<a href="http://www.geoiptool.com/en/?IP=<?php echo $ip; ?>" title="Show Location of IP origin on map"><img src="images/globe.png" width="16" height="16" alt="L" /></a>
					<?php
						} else {
							echo "(No IP address available)";
						}
					else:	
						echo '(You do not have access to see the IP address)';
					endif; // if current user is allowed to see the player's IP address
					?>
				</td>
		</tr>
		<tr>
			<th>First Seen</th>
				<td><?php echo date($tformat, $time_add); ?></td>
			<th>Last Seen</th>
				<td><?php echo date($tformat, $time_edit); ?></td>
		</tr>
	</tbody>
</table>

<?php 
## Plugins Client Bio Area ##

	if(!$no_plugins_active)
		$plugins->displayCDBio();

##############################
?>

<!-- Start Echelon Actions Panel -->

<a name="tabs" />
<div id="actions">
	<ul class="cd-tabs">
		<?php if($mem->reqLevel('comment')) { ?><li class="cd-active"><a href="#tabs" title="Add a comment to this user" rel="cd-act-comment" class="cd-tab">Comment</a></li><?php } ?>
		<?php if($mem->reqLevel('greeting')) { ?><li><a href="#tabs" title="Edit this user's greeting" rel="cd-act-greeting" class="cd-tab">Greeting</a></li><?php } ?>
		<?php if($mem->reqLevel('ban')) { ?><li><a href="#tabs" title="Add Ban/Tempban to this user" rel="cd-act-ban" class="cd-tab">Ban</a></li><?php } ?>
		<?php if($mem->reqLevel('edit_client_level')) { ?><li><a href="#tabs" title="Change this user's user level" rel="cd-act-lvl" class="cd-tab">Change Level</a></li><?php } ?>
		<?php if($mem->reqLevel('edit_mask')) { ?><li><a href="#tabs" title="Change this user's mask level" rel="cd-act-mask" class="cd-tab">Mask Level</a></li><?php } ?>
		<?php 
			if(!$no_plugins_active)
				$plugins->displayCDFormTab();
		?>
	</ul>
	<div id="actions-box">
		<?php
			if($mem->reqLevel('comment')) :
			$comment_token = genFormToken('comment');
		?>
		<div id="cd-act-comment" class="act-slide">
			
			<form action="actions/b3/comment.php" method="post">
				<label for="comment">Comment:</label><br />
					<textarea type="text" name="comment" id="comment"></textarea>
					<?php tooltip('Add a comment to this users Echelon profile'); ?>
					<br />
					
				<input type="hidden" name="token" value="<?php echo $comment_token; ?>" />
				<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
				
				<input type="submit" name="comment-sub" value="Add Comment" />
			</form>
		</div>
		<?php
			endif;
			if($mem->reqLevel('greeting')) :
			$greeting_token = genFormToken('greeting');
		?>
		<div id="cd-act-greeting" class="act-slide">
			<form action="actions/b3/greeting.php" method="post">
				<label for="greeting">Greeting Message:</label><br />
					<textarea name="greeting" id="greeting"><?php echo $greeting; ?></textarea><br />
					
				<input type="hidden" name="token" value="<?php echo $greeting_token; ?>" />
				<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
				<input type="submit" name="greeting-sub" value="Edit Greeting" />
			</form>
		</div>
		<?php
			endif;
			if($mem->reqLevel('ban')) :
			$ban_token = genFormToken('ban');
		?>
		<div id="cd-act-ban" class="act-slide">
			<form action="actions/b3/ban.php" method="post">
		
				<fieldset class="none">
					<legend>Type</legend>
					
					<label for="pb">Permanent Ban?</label>
						<input type="checkbox" name="pb" id="pb" /><?php tooltip('Is this ban to last forever?'); ?><br />
					
					<div id="ban-duration">
						<label for="duration">Duration:</label>
							<input type="text" name="duration" id="duration" class="int dur" /><?php tooltip('This is the number (eg. 3) of minutes/hours ect.'); ?>
							
							<select name="time">
								<option value="m">Minutes</option>
								<option value="h">Hours</option>
								<option value="d">Days</option>
								<option value="w">Weeks</option>
								<option value="mn">Months</option>
								<option value="y">Years</option>
							</select>
							<?php tooltip('How long should this ban last'); ?>
					</div>
				</fieldset>
				<br class="clear" />
				
				<label for="reason">Reason:</label>
					<input type="text" name="reason" id="reason" />
					
				<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
				<input type="hidden" name="c-name" value="<?php echo $name; ?>" />
				<input type="hidden" name="c-ip" value="<?php echo $ip; ?>" />
				<input type="hidden" name="c-pbid" value="<?php echo $guid; ?>" />
				<input type="hidden" name="token" value="<?php echo $ban_token; ?>" />
				<input type="submit" name="ban-sub" value="Ban User" />
			</form>
		</div>
		<?php
			endif; // end hide ban section to non authed
			$b3_groups = $db->getB3Groups(); // get a list of all B3 groups from the B3 DB
			
			if($mem->reqLevel('edit_client_level')) :
			$level_token = genFormToken('level');
		?>
		<div id="cd-act-lvl" class="act-slide">
			<form action="actions/b3/level.php" method="post">
				<label for="level">Level:</label>
					<select name="level" id="level">
						<?php
							foreach($b3_groups as $group) :
								$gid = $group['id'];
								$gname = $group['name'];
								if($group_bits == $gid)
									echo '<option value="'.$gid.'" selected="selected">'.$gname.'</option>';
								else
									echo '<option value="'.$gid.'">'.$gname.'</option>';
							endforeach;
						?>
					</select><br />
					
				<div id="level-pw">
					<label for="password">Your Current Password:</label>
						<input type="password" name="password" id="password" />
						
						<?php tooltip('We need your password to make sure it is really you'); ?>
						
					<br />
				</div>
					
				<input type="hidden" name="old-level" value="<?php echo $group_bits; ?>" />
				<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
				<input type="hidden" name="token" value="<?php echo $level_token; ?>" />
				<input type="submit" name="level-sub" value="Change Level" />
			</form>
		</div>
		<?php
			endif; // end if 
			if($mem->reqLevel('edit_mask')) : 
			$mask_lvl_token = genFormToken('mask');
		?>
		<div id="cd-act-mask" class="act-slide">
			<form action="actions/b3/level.php" method="post">
				<label for="mlevel">Mask Level:</label>
					<select name="level" id="mlevel">
						<?php
							foreach($b3_groups as $group) :
								$gid = $group['id'];
								$gname = $group['name'];
								if($mask_level == $gid)
									echo '<option value="'.$gid.'" selected="selected">'.$gname.'</option>';
								else
									echo '<option value="'.$gid.'">'.$gname.'</option>';
							endforeach;
						?>
					</select>
					<?php tooltip('Masking a user masks their user level from everyone in the game server, as whatever value is here'); ?>
				
				<input type="hidden" name="old-level" value="<?php echo $group_bits; ?>" />
				<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
				<input type="hidden" name="token" value="<?php echo $mask_lvl_token; ?>" />
				<input type="submit" name="mlevel-sub" value="Change Mask" />
			</form>
		</div>
		<?php 
			endif;

			## Plugins CD Form ##
			if(!$no_plugins_active)
				$plugins->displayCDForm($cid)

		?>
	</div><!-- end #actions-box -->
</div><!-- end #actions -->


<!-- Client Logs Area -->
<div id="client-logs">
	<ul>
		<li><a href="ajax/clientdetails/aliases.php?id=<?php echo $cid; ?>&name=<?php echo $name; ?>"><span>Aliases</span></a></li>
		<?php
		//Do we have iptables in b3 db? This is sub optimal, but without a better way to check b3 version...
		$result = $db->query("SHOW TABLES LIKE 'ipaliases'");
		if($result["num_rows"]) {
			?>
			<li><a href="ajax/clientdetails/ipaliases.php?id=<?php echo $cid; ?>&name=<?php echo $name; ?>"><span>IP Aliases</span></a></li>
			<?php
		}
		//Do we have echelon logs for the selected client?
		$ech_logs = $dbl->getEchLogs($cid, $game);
		$count = count($ech_logs);
		if($count > 0) {
			?>
			<li><a href="ajax/clientdetails/echelon_logs.php?id=<?php echo $cid; ?>"><span>Echelon Logs</span></a></li>
			<?php
		}
		?>
		<li><a href="ajax/clientdetails/penalties.php?id=<?php echo $cid; ?>&name=<?php echo $name; ?>&type=penalties"><span>Penalties</span></a></li>
		<li><a href="ajax/clientdetails/penalties.php?id=<?php echo $cid; ?>&name=<?php echo $name; ?>&type=adminactions"><span>Admin Actions</span></a></li>
	</ul>
</div>
<!-- /Client Logs Area-->


<?php
## Plugins Log Include Area ##
if(!$no_plugins_active)
	$plugins->displayCDlogs($cid);

// Close page off with the footer
require 'inc/footer.php';
?>