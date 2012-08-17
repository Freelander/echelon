<?php
/**
 * This file generates a list of client data in JSON format
 * to be called within clients.php via jquery dataTables plugin
 */
 
$auth_name = 'clients';
$b3_conn = true; // this page needs to connect to the B3 database

require '../inc.php';

// the columns to be filtered, ordered and returned
// must be in the same order as displayed in the table
$columns = array (
	"clients.name",
	"clients.id", 
	"groups.name",
	"clients.connections",
	"clients.time_add",
	"clients.time_edit",  
	"clients.group_bits"
);
 
// the table being queried
$table = "clients";

//custom where operation
$custom_where = "clients.id != 1";
 
// any JOIN operations that you need to do
$joins = "LEFT JOIN groups ON clients.group_bits = groups.id";
 
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
	if($column == "groups.name") {
		$column = "groups.name as level";
	}
	$columns_n[] = $column;
}

if(!$db->error) { 
	$main_query = $db->query("SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns_n) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}");
}

//Just testing the main query
//$p = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns_n) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit}";
//echo $p;

// get the number of filtered rows
if(!$db->error) {
	$filtered_rows_query = $db->query("SELECT FOUND_ROWS()");
}
$row = $filtered_rows_query['data'];
$response['iTotalDisplayRecords'] = $row[0]['FOUND_ROWS()'];
 
// get the number of rows in total
if(!$db->error) {
	$total_query = $db->query("SELECT COUNT(id) FROM {$table}");
}
$row = $total_query['data'];
$response['iTotalRecords'] = $row[0]['COUNT(id)'];
 
// send back the sEcho number requested
$response['sEcho'] = intval($_GET['sEcho']);
 
// this line is important in case there are no results
$response['aaData'] = array();
 
// finish getting rows from the main query
foreach($main_query['data'] as $client) {
	$cid = $client['id'];
	if($client['name'] == '') {
		$name = '-';
	} else {
		$name = $client['name'];
	}
	$level = $client['level'];
	$connections = $client['connections'];
	$time_edit = $client['time_edit'];
	$time_add = $client['time_add'];
	$time_add = date($tformat, $time_add);
	$time_edit = date($tformat, $time_edit);

	$client = clientLink($name, $cid);
	$cid = '@' . $cid;

	$response['aaData'][] = array($client, $cid, $level, $connections, $time_add, $time_edit);
}
 
// prevent caching and echo the associative array as json
header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($response);