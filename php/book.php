<?
	$book_public_id = $_REQUEST['book_id'];
	$book = new public_book($book_public_id);
?>
<div class="smallHeaderText">History for Wandering Book #<? echo $book->public_id; ?></div>
<hr/>
<?
	$private_id = get_private_id($book->public_id);
	if(($_SESSION['id'] && user_has_book($_SESSION['id'], $private_id)) || $_SESSION['book'] == $private_id)
	{
		?>
			<br>
			Actions for this book:
			&nbsp;
			<a class="standardLink" href="isbn.php?isbn=<? echo $book->isbn; ?>">Discuss</a>
			&nbsp; | &nbsp;
			<a class="standardLink" href="post.php?book_id=<? echo $book->public_id; ?>">Blog post</a>
			<br><br>
		<?
	}
?>
<div id="myMap" class="map"></div>
<br>
<div style="text-align:left;">
<table width="100%">

<?  # First cell. ?>
	<tr><td style="vertical-align:top; padding-right:10px; padding-bottom:10px;">
	<img class="bookImage" width="75" src="<? echo $book->image_url; ?>" style="float:left;"><br><br>

<?	# End first cell, begin second cell. ?>
	</td><td style="vertical-align:top; padding-bottom:10px; width:100%;">
	<a class="titleLink mainLink" href="isbn.php?isbn=<? echo $book->isbn; ?>"><? echo $book->title; ?></a>
	<hr>
	by <? echo $book->author; ?>
	</td></tr>
</table>

<?
	$event_ids = last_n_events_for_book(20, array('created', 'found', 'left', 'post'), $book->public_id);

	foreach($event_ids as $event_id)
	{
		$event = new book_event($event_id);

		$post_title = "";

		if($event->type == 'created')
		{
			$post_title = "Created on " . $event->datetime;
		}
		else if($event->type == 'left')
		{
			$post_title = "Left on " . $event->datetime; 
		}
		else if($event->type == 'post')
		{
			$post_title = "Post on " . $event->datetime;
		}
		else if($event->type == 'found')
		{
			$post_title = "Found on " . $event->datetime;
		}

		?>
		<hr>
		<a href="read_post.php?id=<? echo $event->id; ?>"><? echo $post_title; ?></a>
		<br>
		<?
		echo $event->body;
	}
?>
</div>
