<?
if(!$user_id && (!empty($_REQUEST['username']) && !empty($_REQUEST['password'])))
{
	$user_id = validate_login($_REQUEST['username'], $_REQUEST['password']);
	$_SESSION['id'] = $user_id;
}
else
{
	$user_id = $_SESSION['id'];
}

if($user_id)
{
	$current_books_list = current_books($user_id);
?>
<div class="smallHeaderText">User Profile: <? print get_username($user_id);?></div>
<hr>
<br>
<table>
	<tr>
		<td class="booksHeader">Current&nbsp;Books</td>
<?
	if(count($current_books_list) == 0)
	{
		?><td>No current books</td><?
	}
	else
	{
		?><td style="text-align:left";><?
		foreach($current_books_list as $book_id)
		{
			$book = new private_book($book_id);
			?>
				<a href="book.php?book_id=<? print $book->public_id;?>"><img class="bookImage" style="margin:5px;" src="<?print $book->image_url;?>"></a>
			<?
		}
		?></td><?
	}
	?>
	</tr>
	<tr>
		<td colspan="2">
			<br>
			<hr>
			<br>
		</td>
	<tr>
		<td class="booksHeader">Past&nbsp;Books</td>
	<?

	$past_books_list = past_books($user_id);
	if(count($past_books_list) == 0)
	{
		?><td>No past books</td><?
	}
	else
	{
		?><td style="text-align:left;"><?
		foreach($past_books_list as $book_id)
		{
			$book = new public_book($book_id);
			?><img class="bookImage" style="margin:5px;" src="<?print $book->image_url;?>"><?
		}
		?></td><?
	}
	?>
	</tr>
</table>
<br>
<?
}
else
{
	print "failure";
}
?>
