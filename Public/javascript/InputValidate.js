var errorImgHtml = '<img src="/Utility/Public/images/error.png" />';

function validateRadioChecked(radioGrp, helpText, helpMessage) {
	for (var i = 0; i < radioGrp.length; i++) {
		if (radioGrp[i].checked) {
			if (helpText != null) {
				helpText.innerHTML = "";
			}
			return true;
		}
	}
	if (helpText != null) {
		helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "此项必选";
		helpText.innerHTML = errorImgHtml + helpMessage;
	}
	return false;	
}

function validateRegEx(regex, input, helpText, helpMessage) {
	// See if the input data validates OK
	if (!regex.test(input)) {
		// The data is invalid, so set the help message and return false
		if (helpText != null)
			helpText.innerHTML = errorImgHtml + helpMessage;
		return false;
	}
	else {
		// The data is OK, so clear the help message and return true
		if (helpText != null)
			helpText.innerHTML = "";
		return true;
	}
}

function validateNumber(inputField, helpText, minValue, maxValue) {
	var inputValue = inputField.value;
	if (isNaN(inputValue)) {
		if (helpText != null) {
			helpText.innerHTML = errorImgHtml + "请输入数值";			
		}
		return false;
	}
	if (minValue != null || maxValue != null) {
		if (inputValue < minValue || inputValue > maxValue) {
			if (helpText != null) {
				helpText.innerHTML = errorImgHtml + "该数值无效";
			}
			return false;
		}
	}
	return true;	
}

function validateNonEmpty(inputField, helpText, helpMessage) {
	// See if the input value contains any text
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "Please enter a value.";
	
	return validateRegEx(/.+/,
		inputField.value, helpText,
		helpMessage);
}

function validateLength(minLength, maxLength, inputField, helpText) {
	// See if the input value contains at least minLength but no more than maxLength characters
	return validateRegEx(new RegExp("^.{" + minLength + "," + maxLength + "}$"),
		inputField.value, helpText,
		"Please enter a value " + minLength + " to " + maxLength +
		" characters in length.");
}

function validateZipCode(inputField, helpText) {
	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText))
		return false;

	// Then see if the input value is a ZIP code
	return validateRegEx(/^\d{5}$/,
		inputField.value, helpText,
		"Please enter a 5-digit ZIP code.");
}

function validateDate(inputField, helpText) {
	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText))
		return false;

	// Then see if the input value is a date
	return validateRegEx(/^\d{2}\/\d{2}\/(\d{2}|\d{4})$/,
		inputField.value, helpText,
		"Please enter a date (for example, 01/14/1975).");
}

function validatePhone(inputField, helpText, helpMessage) {
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "Please enter a phone number (for example, 123-456-7890).";

	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText, helpMessage))
		return false;

	// Then see if the input value is a phone number
	return validateRegEx(/^\d{3}-\d{3}-\d{4}$/,
		inputField.value, helpText,
		helpMessage);
}

function validateEmail(inputField, helpText, helpMessage) {
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "Please enter an email address (for example, johndoe@acme.com).";

	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText, helpMessage))
		return false;

	// Then see if the input value is an email address
	return validateRegEx(/^[\w\.-_\+]+@[\w-]+(\.\w{2,3})+$/,
		inputField.value, helpText,
		helpMessage);
}
