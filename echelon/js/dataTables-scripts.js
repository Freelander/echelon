//dataTables Scripts

$(document).ready(function() {
		//Clients
		$('#clients-dt').dataTable( {
            "aoColumns": [ 
			/* Client-id */    { "sWidth" : "8%" },
			/* Name */         { "sWidth" : "30%" },
			/* Level */        null,
			/* Connections */  { "sWidth" : "10%"},
			/* First Seen */   null,
			/* Last Seen */    null
            ],
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
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "ajax/admins_ajax.php"
		} );
	} );

