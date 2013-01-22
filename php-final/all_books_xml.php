<?
	header("Content-Type: text/html");
	header("Cache-Control: no-cache, must-revalidate");

	include "/home/wanderin/include/common.php";

	$maxlat = $_REQUEST['maxlat'];
	$maxlong = $_REQUEST['maxlong'];
	$minlat = $_REQUEST['minlat'];
	$minlong = $_REQUEST['minlong'];

	// *** TODO ***: Need to protect against SQL injection attacks by quoting
	// longitudes and latitudes.
	$sql = 	"SELECT events.type, events.latitude, events.longitude, " .
			"DATE_FORMAT(events.time, '%M %d, %Y'), events.user_id, events.body " .
			"FROM ".
			"(" .
    		"SELECT book_id, MAX(time) AS time FROM events GROUP BY book_id" .
			") " .
			"AS max_rows INNER JOIN events ON " .
			"events.book_id = max_rows.book_id AND events.time = max_rows.time " .
			"WHERE events.type='left'";

	// For now we ignore latitude and longitude -- we just place all the pushpins on the map.
	// Add the following to the SQL to limit the search to the lat and long passed in.
	// *** TODO ***: At some point may also need to set a limit on the number of results
	// returned.
	//		" AND events.latitude > " . $minlat . " AND events.latitude < " . $maxlat .
	//		" AND events.longitude > " . $minlong . " AND events.longitude < " . $maxlong;

	$db = get_db();
	$db_result = mysql_query($sql, $db);
?>

[
<?
	$i = 0;
	while($row = mysql_fetch_row($db_result))
	{
		if($i != 0)
		{
			print ",\n";
		}
		$i++;

		print "'" . addslashes($row[0]) . "'" . ",\n";
		print $row[1] . ",\n";
		print $row[2] . ",\n";
		print "'" . addslashes($row[3]) . "'" . ",\n";

		if($row[4])
		{
			print "'" . addslashes(get_username($row[4])) . "',\n";
		}
		else
		{
			print "'Anonymous user',\n";
		}
		
		// *** TODO ***: Need to figure out a consistent site-wide way of dealing
		// w/ newlines (and other non-visible characters) in db text fields.
		print "'" . addslashes(str_replace("\r\n", "<br>", $row[5])) . "'";
	}
?>
]
