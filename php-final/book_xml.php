<?
	header("Content-Type: text/html");
	header("Cache-Control: no-cache, must-revalidate");

	include "/home/wanderin/include/common.php";

	// ***TODO***: Should think about whether these should be included ...
	// May want to just place all pushpins, even the ones off the current map.
	$maxlat = $_REQUEST['maxlat'];
	$maxlong = $_REQUEST['maxlong'];
	$minlat = $_REQUEST['minlat'];
	$minlong = $_REQUEST['minlong'];
	
	// ***TODO***: Validate $_REQUEST['id'].
	$public_id = $_REQUEST['id'];

	$sql = 	"SELECT type, latitude, longitude, DATE_FORMAT(time, '%M %d, %Y'), user_id, body" .
			" FROM events WHERE book_id=" . $public_id .
			" AND (type='left' OR type='found')" .
			" AND latitude IS NOT NULL AND longitude IS NOT NULL" .
			" ORDER BY time";

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
		
		// *** TODO ***: May want to consider using addslashes on the other
		// values.  Not sure if usernames, etc. allow quotes in them.
		print "'" . addslashes($row[5]) . "'";
	}
?>
]
