<? $book = new public_book($_REQUEST['book_id']); ?>
<div class="smallHeaderText">Write a blog post for Wandering Book #<? echo $book->public_id; ?></div>
<hr>
<div style="text-align:left;">
<table width="100%">

<? # First cell. ?>
	<tr><td style="vertical-align:top; padding-right:10px; padding-bottom:10px;">
	<img class="bookImage" width="75" src="<? echo $book->image_url; ?>" style="float:left;"><br><br>

<? # End first cell, begin second cell. ?>
	</td><td style="vertical-align:top; padding-bottom:10px; width:100%;">
	<a class="titleLink mainLink" href="isbn.php?isbn=<? echo $book->isbn; ?>"><? echo $book->title; ?></a>
	<hr>
	by <? echo $book->author; ?>
	</td></tr>
</table>
</div>
<br>
<form name="blogPost" method="post" action="preview.php">
	<input type="hidden" name="book_id" value="<? echo $_REQUEST['book_id']; ?>">
	<table>
		<tr>
			<td style="text-align:left;">
				Post title:<br>
				<input class="titleEntry" type="text" name="title" value="<? echo htmlentities($_REQUEST['title'], ENT_QUOTES);?>"/>
				<br/><br/>
				Post body:<br>
				<textarea class="bodyEntry" name="body" rows="15"><? echo htmlentities($_REQUEST['body'], ENT_QUOTES); ?></textarea>
			</td>
			<td style="vertical-align:bottom; padding-left:10px; text-align:right;">
				<input type="submit" value="Preview &gt;&gt;"/>
			</td>
		</tr>
	</table>
</form>
