// These two functions allow us to automatically tab from one
// text entry field to the next when the maxlength is reached.

// autoTab
// Check to see if the maxlength of the input field passed in has
// been reached.  If so, move focus to the next input field.
function autoTab(input)
{
	if(input.value.length >= input.getAttribute("maxlength"))
	{
		input.form[(getIndex(input) + 1) % input.form.length].focus();
	}
}

// getIndex
// Get the index of a given input field in a form.
function getIndex(input)
{
	var index = -1, i = 0, found = false;
	while (i < input.form.length && index == -1)
	{
		if (input.form[i] == input) index = i;
		else i++;
	}
	return index;
}

// submitForm
// Construct the id number from the three form fields.
function submitForm()
{
	// Put together the book id by multiplying and adding the three fields.
	// We multiply the last field by 1 to convert the string to a number.
	var book_id = 	1000000 * document.book_id.id1.value + 1000 * document.book_id.id2.value +
					1 * document.book_id.id3.value;
	document.book_id.id.value = book_id;
	return true;
}
