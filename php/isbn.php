<div style="text-align:left;">
<table width="100%">

<?  # First cell. ?>
	<tr><td style="vertical-align:top; padding-right:10px; padding-bottom:0px;">
	<img class="bookImage" width="75" src="<? echo $title->image_url; ?>" style="float:left;"><br><br>

<?	# End first cell, begin second cell. ?>
	</td><td style="vertical-align:top; padding-bottom:10px; width:100%;">
	<div class="smallHeaderText"><? echo $title->title; ?></div>
	<br>
	by <? echo $title->author; ?>
	</td></tr>
</table>
<hr>
<?
	if($user_id && user_has_isbn($user_id, $title->isbn))
	{
		echo "user can post -- write the code :)";
	}
	else
	{
		echo "check for valid book id.  if not, user can't post :(";
	}
?>
</div>
