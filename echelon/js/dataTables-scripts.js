//Clients
$(document).ready(function() {
		$('#clients').dataTable( {
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
	} );
