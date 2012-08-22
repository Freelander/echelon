//dataTables Scripts

$(document).ready(function() {
		//Clients
		$('#clients-dt').dataTable( {
			"aoColumns": [ 
			/* Name */         { "sWidth" : "30%" },
			/* Client-id */    { "sWidth" : "8%" },
			/* Level */        null,
			/* Connections */  { "sWidth" : "10%"},
			/* First Seen */   null,
			/* Last Seen */    null
			],
			"aaSorting": [[ 1, "asc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/clients_ajax.php"
		} );

		//Admins
		$('#admins-dt').dataTable( {
			"aoColumns": [ 
			/* Name */         { "sWidth" : "30%" },
			/* Level */        null,
			/* Client-id */    { "sWidth" : "8%" },
			/* Connections */  { "sWidth" : "10%"},
			/* Last Seen */    null
			],
			"aaSorting": [[ 1, "desc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/admins_ajax.php"
		} );

		//Regulars
		$('#regular-dt').dataTable( {
			"aoColumns": [ 
			/* Name */         { "sWidth" : "30%" },
			/* Connections */  { "sWidth" : "10%"},
			/* Client-id */    { "sWidth" : "8%" },
			/* Level */        null,
			/* Last Seen */    null
			],
			"aaSorting": [[ 4, "desc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/regular_ajax.php"
		} );

		//Inactive Admins
		$('#active-dt').dataTable( {
			"aoColumns": [ 
			/* Name */         { "sWidth" : "30%" },
			/* Client-id */    { "sWidth" : "8%" },
			/* Level */        null,
			/* Connections */  { "sWidth" : "10%"},
			/* Last Seen */    null,
			/* Duration */     { "sWidth" : "25%", "bSortable": false }
			],
			"sDom": '<"H"lT<"duration-select">r>t<"F"ip>', //Replacing standart filter text box with custom select box
			"aaSorting": [[ 4, "asc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/active_ajax.php"
		} );

		//Create the select box that will replace the standart filter text box on Inactive Admins page
		$("div.duration-select").html(
		'<label>Admins who have not been seen by B3 for </label>' +
		'<select id="d" name="d">' + 
			'<option>Select Duration</option>' +
			'<option value="1">1 Day</option>' +
			'<option value="3">3 Days</option>' +
			'<option value="7">1 Week</option>' +
			'<option value="14">2 Weeks</option>' +
			'<option value="21">3 Weeks</option>' +
			'<option value="28">4 Weeks</option>' +
			'<option value="35">5 Weeks</option>' +
			'<option value="182">6 Months</option>' +
			'<option value="365">1 Year</option>' +
			'</select>'
		);

		// Adding select box filter to Inactive Admins page
		var oTable = $('#active-dt').dataTable();
		$('select#d').change( function() { oTable.fnFilter( $(this).val() ); } );

		//Admin Kicks
		$('#adminkicks-dt').dataTable( {
			"aoColumns": [ 
			/* Client */     { "sWidth" : "20%" },
			/* Kicked at */  null,
			/* Reason */     { "sWidth" : "45%" },
			/* Admin */      { "sWidth" : "20%"}
			],
			"bFilter": false,
			"aaSorting": [[ 1, "desc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/adminkicks_ajax.php"
		} );

		//B3 Kicks
		$('#b3kicks-dt').dataTable( {
			"aoColumns": [ 
			/* Client */     { "sWidth" : "25%" },
			/* Kicked at */  null,
			/* Reason */     { "sWidth" : "55%" }
			],
			"bFilter": false,
			"aaSorting": [[ 1, "desc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/b3kicks_ajax.php"
		} );

		//Admin Bans
		$('#adminbans-dt').dataTable( {
			"aoColumns": [ 
			/* Player */     { "sWidth" : "15%" },
			/* Type */       { "sWidth" : "10%" },
			/* Added */      { "sWidth" : "10%" },
			/* Duration */   { "sWidth" : "10%" },
			/* Expires */    { "sWidth" : "10%" },
			/* Reason */     { "sWidth" : "30%" },
			/* Admin */      { "sWidth" : "15%"}
			],
			"bFilter": false,
			"aaSorting": [[ 2, "desc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/adminbans_ajax.php"
		} );

		//B3 Bans
		$('#b3bans-dt').dataTable( {
			"aoColumns": [ 
			/* Player */     { "sWidth" : "15%" },
			/* Type */       { "sWidth" : "10%" },
			/* Added */      { "sWidth" : "10%" },
			/* Duration */   { "sWidth" : "10%" },
			/* Expires */    { "sWidth" : "10%" },
			/* Reason */     null,
			],
			"bFilter": false,
			"aaSorting": [[ 2, "desc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/b3bans_ajax.php"
		} );

		//Public Bans
		$('#pubbans-dt').dataTable( {
			"aoColumns": [ 
			/* Player */     { "sWidth" : "15%" },
			/* Ban-id */     { "sWidth" : "7%" },
			/* Type */       { "sWidth" : "7%" },
			/* Added */      { "sWidth" : "15%" },
			/* Duration */   { "sWidth" : "10%" },
			/* Expires */    { "sWidth" : "10%" },
			/* Reason */     null,
			],
			"sDom": '<lfr>t<"F"ip>',
			"iDisplayLength": 100,
			"bLengthChange": false,
			"bFilter": false,
			"aaSorting": [[ 3, "desc" ]],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/pubbans_ajax.php"
		} );

	} );