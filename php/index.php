<table class="smallHeaderText" style="width:100%; border-collapse:collapse;">
	<tr>
		<td style="text-align:left; width:50%;">
			Found a book? <a class="standardLink mainLink" href="found_book.php">Click here</a>
		</td>
		<td style="text-align:right; width:50%;">
			Returning users: <a class="standardLink mainLink" href="login.php">Log in here</a>
		</td>
	</tr>
</table>
<hr>
<div style="text-align:left;">
<table width="100%" style="padding-top:20px;">
<?
	$event_ids = last_n_events(20, array('left', 'found', 'created'));
	foreach($event_ids as $event_id)
	{
		$event = new book_event($event_id);
		$book = new public_book($event->book_public_id);

		$book_str = "Wandering book #" . $book->public_id;
		$event_str = "";

		if($event->type == "left")
		{
			$event_str = "Left on " . $event->datetime;
		}
		else if($event->type == "found")
		{
			$event_str = "Found on " . $event->datetime;
		}
		else if($event->type == "created")
		{
			$event_str = "Created on " . $event->datetime;
		}
		else
		{
			assert(FALSE);
		}

		# First cell.
		?>
		<tr><td style="vertical-align:top; padding-right:10px; padding-bottom:30px;">
		<a href="book.php?book_id=<? echo $book->public_id; ?>">
			<img class="bookImage" width="75" src="<? echo $book->image_url; ?>" style="float:left;">
		</a>
		<? # Second cell. ?>
		</td><td style="vertical-align:top; padding-bottom:30px; width:100%;">
		<a class="bookLink mainLink" href="book.php?book_id=<?echo $book->public_id; ?>"><?echo $book_str; ?>:</a>
		<a class="eventLink mainLink" href="read_post.php?id=<? echo $event->id; ?>"><? echo $event_str; ?></a><hr>
		<a class="titleLink" href="isbn.php?isbn=<? echo $book->isbn; ?>">
		<?
			if(strlen($book->title) > 75)
			{
				echo substr($book->title, 0, 75) . " ...";
			}
			else
			{
				echo $book->title;
			}
		?>
		</a>
		<br><br>
		<? echo $event->body; ?>
		</td></tr>
<?
	}
?>
</table>
</div>
