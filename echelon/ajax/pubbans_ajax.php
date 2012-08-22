<?php
/**
 * This file generates a list of publþc bans data in JSON format
 * to be called within pubbans.php via jquery dataTables plugin
 */

$auth_user_here = false;
$b3_conn = true; // this page needs to connect to the B3 database

require '../inc.php';

$time = time();

// the columns to be filtered, ordered and returned
// must be in the same order as displayed in the table
$columns = array (
	"clients.name",
	"penalties.id",
	"penalties.type",
	"penalties.time_add",
	"penalties.duration",
	"penalties.time_expire",
	"penalties.reason",
	"clients.id"
);
 
// the table being queried
$table = "penalties";

//custom where operation
$custom_where = "penalties.inactive = 0 AND penalties.type != 'Warning' AND penalties.type != 'Notice' AND (penalties.time_expire = -1 OR penalties.time_expire > $time)";
 
// any JOIN operations that you need to do
$joins = "LEFT JOIN clients ON penalties.client_id = clients.id";
 
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
	if($column == "clients.id") {
		$column = "clients.id as client_id";
	} elseif($column == "penalties.id") {
		$column = "penalties.id as ban_id";
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
foreach($main_query['data'] as $pen) {
	$ban_id = $pen['ban_id'];
	$type = $pen['type'];
	$time_add = $pen['time_add'];
	$time_expire = $pen['time_expire'];
	$reason = tableClean($pen['reason']);
	$client_id = $pen['client_id'];
	$client_name = tableClean($pen['name']);
	$duration = $pen['duration'];

	## Tidt data to make more human friendly
	if($time_expire != '-1')
		$duration_read = time_duration($duration*60); // all penalty durations are stored in minutes, so multiple by 60 in order to get seconds
	else
		$duration_read = '';

	$time_expire_read = timeExpirePen($time_expire);
	$time_add_read = date($tformat, $time_add);
	$reason_read = removeColorCode($reason);

	if($mem->loggedIn())
		$client_name_read = clientLink($client_name, $client_id);
	else
		$client_name_read = $client_name;

	$response['aaData'][] = array($client_name_read, $ban_id, $type, $time_add_read, $duration_read, $time_expire_read, $reason_read);
}
 
// prevent caching and echo the associative array as json
header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($response);