</div><!-- close #content -->

<div id="content-lower">
	&nbsp;
	<a href="#t" title="Go to the top of the page">Top</a>		
</div>

</div> <!-- close #mc -->

<div id="footer">
	<p>
		<span class="copy">&copy;<?php echo date("Y"); ?> <a href="http://eire32designs.com" target="_blank">Eire32</a> &amp; <a href="http://bigbrotherbot.net" target="_blank">Big Brother Bot</a> - All rights reserved</span>
		<?php if($mem->loggedIn()) { ?>
			<span class="foot-nav links">
				<a href="<?php echo $path; ?>" title="Home Page">Home</a> -
				<a href="<?php echo $path; ?>sa.php" title="Site Administration">Site Admin</a> -
				<a href="<?php echo $path; ?>me.php" title="Edit your account">My Account</a> -
				<a href="http://echelon.bigbrotherbot.net/help/" title="Get some help with Echelon">Help</a> -
				<a href="<?php echo $path; ?>actions/logout.php" class="logout" title="Logout">Logout</a>
			</span>
		<?php } ?>
	</p>
</div><!-- close #footer -->

</div><!-- close #page-wrap -->

<!-- ie6 png transparncy fix -->
<!--[if lt IE 7]>		
		<script type="text/javascript" src="<?php echo $path; ?>js/unitpngfix.js"></script>
<![endif]--> 

<!-- load jQuery off google CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

<!-- load main site js -->
<script src="<?php echo $path; ?>js/site.js" charset="<?php echo $charset; ?>"></script>

<!-- load Datatables -->
<script src="<?php echo $path; ?>js/jquery.dataTables.js" charset="<?php echo $charset; ?>"></script>

<!-- load Datatables scripts -->
<script src="<?php echo $path; ?>js/dataTables-scripts.js" charset="<?php echo $charset; ?>"></script>

<!-- jQuery UI Tabs -->
<script src="<?php echo $path; ?>js/jquery-ui-1.8.23.custom.min.js" charset="<?php echo $charset; ?>"></script>

<!-- page specific js -->
<?php if(isMe()) { ?>
	<script src="js/me.js" charset="<?php echo $charset; ?>"></script>
<?php } ?>

<?php if(isCD()) : ?>
	<script src="js/jquery.colorbox-min.js" charset="<?php echo $charset; ?>"></script>
	<script src="js/cd.js" charset="<?php echo $charset; ?>"></script>
	<script charset="<?php echo $charset; ?>">
		$('#level-pw').hide();

		// check for show/hide PW required for level change 
		if ($('#level').val() >= <?php echo $config['cosmos']['pw_req_level_group']; ?>) {
			$("#level-pw").show();
		}
		$('#level').change(function(){
			if ($('#level').val() >= 64) {
				$("#level-pw").slideDown();
			} else {
				$("#level-pw").slideUp();
			}
		});
	</script>
<?php endif; ?>

<?php
	## plugin specific js ##
	if(!$no_plugins_active)
		$plugins->getJS();
?>

</body>
</html>
