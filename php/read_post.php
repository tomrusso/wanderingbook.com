<?
	$id = $_REQUEST['id'];
	assert($id);
	$event = new book_event($id);
	$book = new public_book($event->book_public_id);

	if(!$event->user_id)
	{
		$username = "Anonymous";
	}
	else
	{
		$username = get_username($event->user_id);
	}

	if(!username)
	{
		$username = "Anonymous";
	}

	$pre = "";
	$post = "";
	if($event->type == 'created')
	{
		$post = "created";
	}
	else if($event->type == 'found')
	{
		$post = "found";
	}
	else if($event->type == 'left')
	{
		$post = "left";
	}
	else if($event->type == 'post')
	{
		$pre = "Post for";
	}
	else
	{
		assert(FALSE);
	}
?>
<div class="smallHeaderText">
	<? echo $pre; ?>
	<a class="bookLink mainLink" href="book.php?book_id=<? echo $event->book_public_id; ?>">Wandering book #<? echo $event->book_public_id; ?></a>
	<? echo $post; ?>
	by <? echo $username; ?> on <? echo $event->datetime; ?>
</div>
<hr>

<div style="text-align:left;">
<table width="100%">
	<tr><td style="vertical-align:top; padding-right:10px; padding-bottom:10px;">
		<a href="book.php?book_id=<? echo $event->book_public_id; ?>">
		<img class="bookImage" width="75" src="<? echo $book->image_url; ?>" style="float:left;">
		</a>
		<br><br>
	</td><td style="vertical-align:top; padding-bottom:10px; width:100%;">
		<a class="titleLink mainLink" href="isbn.php?isbn=<? echo $book->isbn; ?>"><? echo $book->title; ?></a>
		<br><br>
		by <? echo $book->author; ?>
	</td></tr>
</table>
</div>
<hr><br>
<div class="mainBlockText">
	<? echo $event->body; ?>
	<br><br>
</div>
