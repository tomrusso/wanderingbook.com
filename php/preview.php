<?
	$book_id = $_REQUEST['book_id'];
	$book = new public_book($book_id);
?>
<div class="smallHeaderText">Preview post for Wandering Book #<? echo $book->public_id; ?></div>
<hr>
<?
	$title = htmlentities($_REQUEST['title'], ENT_QUOTES);
	$body = htmlentities($_REQUEST['body'], ENT_QUOTES);
?>

<table style="width:100%; text-align:left;">
	<tr>
		<td>
			<form method="post" action="post.php">
				<input type="hidden" name="book_id" value="<? echo $book_id; ?>">
				<input type="hidden" name="title" value="<? echo $title; ?>">
				<input type="hidden" name="body" value="<? echo $body; ?>">
				<input style="float:left;" type="submit" value="&lt;&lt; Back">
			</form>
			<form method="post" action="post.php">
				<input type="hidden" name="book_id" value="<? echo $book_id; ?>">
				<input type="hidden" name="title" value="<? echo $title; ?>">
				<input type="hidden" name="body" value="<? echo $body; ?>">
				<input style="float:right;" type="submit" value="Post &gt;&gt;">
			</form>
		</td>
	</tr>
	<tr>
		<td>	
			<br>
			<img class="bookImage" width="75" style="float:left; margin-right:10px;" src="<? echo $book->image_url; ?>">
			<div class="blogTitle"><? echo $title; ?></div>
			<div style="color:blue; font-size:9pt; padding-top:5px;">by tom on 11 Aug 2011</div>
			<hr>
			<? echo text_to_html($body); ?>
		</td>
	</tr>
</table>
