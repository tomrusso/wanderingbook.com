<?
	$action = $_REQUEST['action'];
	$private_id = $_REQUEST['id'];
	$event_id = $_REQUEST['event_id'];
	$error_message = "";
	if($action == "locate")
	{
		$event_id = event_found((int)$private_id, $_SESSION['id']);
		if(!$event_id)
		{
			$error_message='<div style="{ color:red; }">The number you entered could not be found.</div><br/><br/>';
		}
//	}
//	if($locate_book && $event_id)
//	{
?>
<div class="smallHeaderText">
	Where did you find this book?
</div>
<hr/>
<div style="text-align:left;">
	wanderingbook.com is a book tracking site.  Using your book's ID number
	you'll be able to see where it's been and who's had it in the past.  First we
	need you to tell us where you found this book.

	<ul>
		<li><b>Drag</b> the map to move it around and <b>double click</b> to zoom in
		<li><b>Click</b> to place a pushpin where you found the book
		<li>Click the <b>submit button</b> when you're done
	</ul>
</div>

<form name="location" action="found_book.php" method="post"
	onsubmit="return submitLocation(document.getElementById('lat'), document.getElementById('long'));">
	<input style="float:right;" type="submit" value="Submit &gt;&gt;">
	<input type="hidden" name="action" value="show">
	<input id="lat" type="hidden" name="lat">
	<input id="long" type="hidden" name="long">
	<input type="hidden" name="id" value="<?print $private_id;?>">
	<input type="hidden" name="event_id" value="<?print $event_id;?>">
</form>
<br><br>
<div id="myMap" class="map"></div>
<?
	}
	else if($action == "show")
	{
?>
<div class="smallHeaderText">
	Where your book has been
</div>
<hr/>
<?
		update_found_loc($event_id, $private_id, $_REQUEST['lat'], $_REQUEST['long']);
		$result_book = new private_book($private_id);
?>
<br/>
<table>
	<tr>
		<td style="padding-left:0px;">
			<img class="bookImage" src="<?php echo $result_book->image_url?>" alt="Book image"/>
		</td>
		<td style="padding-left:10px; text-align:left; vertical-align:top;">
			<i><?php echo $result_book->title?></i>
			<br/><br/>
			<?php echo $result_book->author?>
		</td>
	</tr>
</table>

<!--
<div style="{ height: 100%; padding-top: 3px; }">
	<div style="{ float: left; width: 50%; }">
		<div style="{ float: left; vertical-align: middle; padding-right: 10px; }">
			<img src="<?php echo $result_book->image_url?>"/>
		</div>
		<div style="{ float: left; vertical-align: top; }">
			<i><?php echo $result_book->title?></i>
			<br/><br/>
			<?php echo $result_book->author?>
		</div>
	</div> -->
	<div style="{ float: right; }">
		<form method="POST">
			<input type="hidden" name="event_id" value="<?print $event_id;?>">
			<input type="hidden" name="id" value="<?print $private_id;?>">
			<input type="hidden" name="action" value="body">
			<input style="float:right;" type="submit" value="Next &gt;&gt;">
		</form>
	</div>
	<br><br>
<!--</div>
<br/> -->
<div id="myMap" class="map"></div>
<?
	}
	else if($action == "body")
	{
		$event_id = $_REQUEST['event_id'];
?>
<div class="smallHeaderText">
	Where did you find this book?
</div>
<hr/>
<br>
<form action="create_user.php" method="POST">
	Please write a short description of where you found this book and
	then click Next. &nbsp;&nbsp;  <input style="{ float:right; }" type="submit" value="Next &gt;&gt;">
	<br><br>
	<input type="hidden" name="event_id" value="<?print $event_id;?>">
	<input type="hidden" name="id" value="<?print $private_id;?>">
<textarea name="body" cols="40" rows="20"></textarea>
</form>
<br>
<?
	}
	else
	{
?>
<div class="smallHeaderText">
	Book found
</div>
<hr/>
<br/><br/><br/>
<div style="{ text-align:center; }">
<form method="POST" action="found_book.php" name="book_id" onsubmit="return submitForm();">
	<?print $error_message;?>
	Enter the 9 digit ID:&nbsp;&nbsp;
	<input 	type="text" size="3" maxlength="3" name = "id1"
			style="{text-align:center;}" onKeyUp="return autoTab(this);">
	&ndash;
	<input 	type="text" size="3" maxlength="3" name="id2"
			style="{text-align:center;}" onKeyUp="return autoTab(this);">
	&ndash;
	<input 	type="text" size="3" maxlength="3" name="id3"
			style="{text-align:center;}" onKeyUp="return autoTab(this);">
	<!-- 	The submit button needs to be right after the last input field
			so that the autoTab function moves focus to it after the last
			field is filled in. -->
	&nbsp;&nbsp;
	<input type="submit" value="  Go!  ">
	<input type="hidden" name="id">
	<input type="hidden" name="action" value="locate">
</form>
</div>
<br/><br/><br/>
<?
	}
?>
