<?php
/**
 * This file generates a list of notices in JSON format
 * to be called within notices.php via jquery dataTables plugin
 */
 
$auth_name = 'penalties';
$b3_conn = true; // this page needs to connect to the B3 database

require '../inc.php';

// the columns to be filtered, ordered and returned
// must be in the same order as displayed in the table
// Add extra columns to the end of the array.
$columns = array (
	"c2.name",
	"p.client_id",
	"p.time_add",
	"p.reason",
	"COALESCE(c1.name, 'B3')",
	"p.id",
	"p.type",
	"COALESCE(c1.id, '1')"
);
 
// the table being queried
$table = "penalties p";

//custom where operation
$custom_where = "p.type = 'Notice'";
 
// any JOIN operations that you need to do
$joins = "LEFT JOIN clients c1 ON c1.id = p.admin_id LEFT JOIN clients c2 ON c2.id = p.client_id";
 
// filtering
$sql_where = "";
if ($_GET['sSearch'] != "") {
	$sql_where = "WHERE ( ";
	foreach ($columns as $column)
	{
		$sql_where .= $column . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
	}
	$sql_where = substr($sql_where, 0, -3);
	$sql_where .= " ) ";
}

if($sql_where != "") {
	$sql_where .= " AND ( $custom_where ) ";
} else {
	$sql_where .= "WHERE $custom_where ";
}

// ordering
$sql_order = "";
if ( isset( $_GET['iSortCol_0'] ) ) {
	$sql_order = "ORDER BY  ";
	for ( $i = 0; $i < $_GET['iSortingCols']; $i++ ) {
		$sql_order .= $columns[$_GET['iSortCol_' . $i]] . " " . $_GET['sSortDir_' . $i] . ", ";
	}
	$sql_order = substr_replace( $sql_order, "", -2 );
}
 
// paging
$sql_limit = "";
if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
	$sql_limit = "LIMIT " . $_GET['iDisplayStart'] . ", " . $_GET['iDisplayLength'];
}

//add AS thingy here if any and regenerate $columns array since we don't want to mess ordering/filtering etc.
foreach($columns as $column) {
	if($column == "COALESCE(c1.id, '1')") {
		$column = "COALESCE(c1.id, '1') as admin_id";
	} elseif ($column == "COALESCE(c1.name, 'B3')") {
		$column = "COALESCE(c1.name, 'B3') as admin_name";
	} elseif ($column == "c2.name") {
		$column = "c2.name as client_name";
	}
	$columns_n[] = $column;
}

if(!$db->error) { 
	$main_query = $db->query("SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns_n) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}");
}

//Just testing the main query
$p = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns_n) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}";
//echo $p;

// get the number of filtered rows
if(!$db->error) {
	$filtered_rows_query = $db->query("SELECT FOUND_ROWS()");
}
$row = $filtered_rows_query['data'];
$response['iTotalDisplayRecords'] = $row[0]['FOUND_ROWS()'];
 
// get the number of rows in total
if(!$db->error) {
	$total_query = $db->query("SELECT COUNT(id) FROM clients");
}
$row = $total_query['data'];
$response['iTotalRecords'] = $row[0]['COUNT(id)'];
 
// send back the sEcho number requested
$response['sEcho'] = intval($_GET['sEcho']);
 
// this line is important in case there are no results
$response['aaData'] = array();
 
// finish getting rows from the main query
foreach($main_query['data'] as $notice) {
	$cname = tableClean($notice['client_name']);
	$cid = $notice['client_id'];
	$aname = tableClean($notice['admin_name']);
	$aid = $notice['admin_id'];
	$reason = tableClean($notice['reason']);
	$time_add = $notice['time_add'];

	## Change to human readable	time
	$time_add = date($tformat, $time_add);

	$client = clientLink($cname, $cid);
	$admin = clientLink($aname, $aid);
	$cid = '@' . $cid;

	$response['aaData'][] = array( $client, $cid, $time_add, $reason, $admin);
}
 
// prevent caching and echo the associative array as json
header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($response);