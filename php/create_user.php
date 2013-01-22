<div class="smallHeaderText">Create account</div>
<hr>
<?php

# *** TODO ***: Should be able to safely comment this stuff out.
# Verify and delete.
#
# $private_id = $_REQUEST['id'];
# $event_id = $_REQUEST['id'];
# $body = $_REQUEST['body'];
#
#if($private_id && $event_id && $body)
#{
#	update_found_body($event_id, $private_id, $body);
#}

#### !!! TODO !!!
#### Make _sure_ to properly escape all user supplied values and values
#### from the database.  Make sure to do this for ALL files, not just
#### this one.  Figure out how the input defaults should work as well.

	# If the user has entered a description of where they found a book,
	# we save that to the database.
	# *** TODO ***: If we want to make creating a login optional we
	# should also use this to display a message to that effect.
	$event_id = $_REQUEST['event_id'];
	$private_id = $_REQUEST['id'];
	$body = $_REQUEST['body'];

	if($event_id && $private_id && $body)
	{
		update_found_body($event_id, $private_id, $body);
	}

	# Variables to hold the parameters to create_user and the result.
	$email = "";
	$username = "";
	$password = "";
	$result = NULL;

	# An indicator whether or not user creation succeeded.  Used to
	# control display of the information input version of the page.
	$success = FALSE;

	# A container for any error messages that are necessary.
	$error_message = "";

	# These variables are used to set the class of the appropriate labels
	# to "error".
	$email_error = FALSE;
	$username_error = FALSE;
	$password_error = FALSE;

	if (isset($_REQUEST['action']) && $_REQUEST['action'] == "add")
	{
		$email = trim($_REQUEST['email']);

		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];

		# Attempt to create a new user with the information provided.
		# create_user does all the necessary string processing, so the
		# email, usrname and password that get returned in the result
		# object are safe to display.
		$result = create_user($email, $username, $password);

		# From here onward the only thing we use the email, username
		# and password for is display.  For this we use the versions
		# of email, username and password that are returned in the
		# result object.  These strings have been properly escaped to
		# prevent any funny business.  Unset $email, $username and
		# $password so they don't accidentally get used below.
		unset($email);
		unset($username);
		unset($password);

		if ($result->success())
		{
			# We've succeeded, so we don't want to redisplay the information entry
			# screen below.
			$success = TRUE;

			print $event_id;
			print $private_id;

			# Update the found event with the newly created user's ID.
			update_found_user($event_id, $private_id, $result->user_id);

			# Here we need to send a confirmation email to the user with a link
			# they can click to confirm their registration.
?>
			Your account has been successfully created.  Insert text about how they will get 
			an email and need to click the link in it to confirm their registration.  Include
			a link back to the home page (?).  Click
			<a href="profile.php?username=<?print $result->email;?>&password=<?print $result->password;?>">here</a> to go to
			your profile page.
<?php
		}
		else
		{
			# *** TODO ***: Better error presentation.  Error text should be in
			# red.  Field labels should also be made red.

			# The account creation attempt has failed, so we need to construct
			# an error message.

			if ($result->email_blank)
			{
				$error_message .= "<li>Email cannot be blank.\n";
				$email_error = TRUE;
			}
			elseif ($result->email_invalid)
			{
				# *** TODO ***: Move the trim to a better place.  Should be
				# either above in this file, in create_user, or both.
				# *** TODO ***: Change the error message to "Invalid email: <email>."
				$error_message .= "<li>The email address you entered is invalid.<br>\n";
				$email_error = TRUE;
			}
			elseif ($result->email_exists)
			{
				# The email address entered already exists.  We actually probably want
				# something different in this case, ie. click this button to be emailed
				# your password.  This really needs to be moved to an else clause of the
				# if that does the info entry page.
				$error_message .= "<li>The email address you entered already exists in our database.\n";
				$email_error = TRUE;
			}

			if ($result->username_blank)
			{
				$error_message .= "<li>Username cannot be blank.\n";
				$username_error = TRUE;
			}
			elseif ($result->username_exists)
			{
				$error_message .= "<li>The username you entered already exists in our database.  Please choose another.\n";
				$username_error = TRUE;
			}
			elseif ($result->username_is_email)
			{
				$error_message .= "<li>Your username cannot be an email address.  Please choose another.\n";
				$username_error = TRUE;
			}

			if ($result->password_blank)
			{
				$error_message .= "<li>Password cannot be blank.\n";
				$password_error = TRUE;
			}
		}
	}

	if(!$success)
	{
?>
<table>
	<tr>
		<td style="width:50%;">
			<form method="POST" action="create_user.php">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="event_id" value="<?print $event_id;?>">
				<input type="hidden" name="id" value="<?print $private_id;?>">
				<table style="text-align:left;">
					<tr>
						<td colspan="2">
							<?php
								if ($error_message)
								{
							?>
							Please correct the following problems:
							<div class="error"><ul><?php echo $error_message; ?></ul></div>
							<?php
								}
								else
								{
							?>
							Enter your email address and the
							username and password you'd like to use.<br><br>
							<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td <?php if ($email_error) echo 'class="error"'; ?>>Email:</td>
						<td><input type="text" name="email" class="default" value="<?php echo $result->email;?>"></td>
					</tr>
					<tr>
						<td <?php if ($username_error) echo 'class="error"'; ?>>Username:</td>
						<td><input type="text" name="username" class="default" value="<?php echo $result->username;?>"></td>
					</tr>
					<tr>
						<td <?php if ($password_error) echo 'class="error"'; ?>>Password:</td>
						<td><input type="password" name="password" class="default" value="<?php echo $result->password;?>"></td>
					</tr>
					<tr>
						<td style="text-align:center;" colspan="2">
							<br>
							<input type="submit" value="Submit">
						</td>
					</tr>
				</table>
			</form>
		</td>
		<td>
			<?
				$url = "https://www.facebook.com/dialog/oauth?client_id=18199723360&redirect_uri=" . urlencode("http://www.wanderingbook.com/facebook");
			?>
			Or, <a class="standardLink" href="<? echo $url; ?>">log in with Facebook</a>
			<br><br>
			Or, you can <a class="standardLink" href="">skip this step</a>
		</td>
	</tr>
</table>
<?php
	}
?>
