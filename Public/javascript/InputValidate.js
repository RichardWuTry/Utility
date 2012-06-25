var defaultErrorImgHtml = '<img src="/Utility/Public/images/error.png" />';

function validateRadioChecked(radioGrp, helpText, helpMessage, errorImgHtml) {
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
		errorImgHtml = typeof errorImgHtml !== 'undefined' ? errorImgHtml : defaultErrorImgHtml;
		helpText.innerHTML = errorImgHtml + helpMessage;
	}
	return false;	
}

function validateOptionChecked(optionGrp, helpText, helpMessage, errorImgHtml) {
	for (var i = 0; i < optionGrp.length; i++) {
		if (optionGrp[i].checked) {
			if (helpText != null) {
				helpText.innerHTML = "";
			}
			return true;
		}
	}
	if (helpText != null) {
		helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "此项必选";
		errorImgHtml = typeof errorImgHtml !== 'undefined' ? errorImgHtml : defaultErrorImgHtml;
		helpText.innerHTML = errorImgHtml + helpMessage;
	}
	return false;	
}

function validateRegEx(regex, input, helpText, helpMessage, errorImgHtml) {
	// See if the input data validates OK
	if (!regex.test(input)) {
		// The data is invalid, so set the help message and return false
		if (helpText != null) {
			errorImgHtml = typeof errorImgHtml !== 'undefined' ? errorImgHtml : defaultErrorImgHtml;
			helpText.innerHTML = errorImgHtml + helpMessage;
		}
		return false;
	}
	else {
		// The data is OK, so clear the help message and return true
		if (helpText != null)
			helpText.innerHTML = "";
		return true;
	}
}

function validateNumber(inputField, helpText, helpMessage, errorImgHtml, minValue, maxValue, mustInt) {
	var inputValue = inputField.value;
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "请输入数值";
	errorImgHtml = typeof errorImgHtml !== 'undefined' ? errorImgHtml : defaultErrorImgHtml;
	if (isNaN(inputValue)) {
		if (helpText != null) {			
			helpText.innerHTML = errorImgHtml + helpMessage;			
		}
		return false;
	}
	if (minValue != null || maxValue != null) {
		if (inputValue < minValue || inputValue > maxValue) {
			if (helpText != null) {
				helpText.innerHTML = errorImgHtml + helpMessage;
			}
			return false;
		}
	}
	if (mustInt && parseInt(inputValue) != inputValue) {
		if (helpText != null) {
			helpText.innerHTML = errorImgHtml + helpMessage;
		}
		return false;
	}
	return true;	
}

function validateNonEmpty(inputField, helpText, helpMessage, errorImgHtml) {
	// See if the input value contains any text
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "Please enter a value.";
	
	return validateRegEx(/.+/,
		inputField.value, helpText,
		helpMessage,
		errorImgHtml);
}

function validateLength(minLength, maxLength, inputField, helpText, helpMessage, errorImgHtml) {
	// See if the input value contains at least minLength but no more than maxLength characters
	var defaultHelpMessage = "Please enter a value " + minLength + " to " + maxLength +
		" characters in length.";
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : defaultHelpMessage;
	
	return validateRegEx(new RegExp("^.{" + minLength + "," + maxLength + "}$"),
		inputField.value, helpText,	helpMessage, errorImgHtml);
}

function validateZipCode(inputField, helpText, errorImgHtml) {
	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText))
		return false;

	// Then see if the input value is a ZIP code
	return validateRegEx(/^\d{5}$/,
		inputField.value, helpText,
		"Please enter a 5-digit ZIP code.",
		errorImgHtml);
}

function validateDate(inputField, helpText, errorImgHtml) {
	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText))
		return false;

	// Then see if the input value is a date
	return validateRegEx(/^\d{2}\/\d{2}\/(\d{2}|\d{4})$/,
		inputField.value, helpText,
		"Please enter a date (for example, 01/14/1975).",
		errorImgHtml);
}

function validatePhone(inputField, helpText, helpMessage, errorImgHtml) {
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "Please enter a phone number (for example, 123-456-7890).";

	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText, helpMessage, errorImgHtml))
		return false;

	// Then see if the input value is a phone number
	return validateRegEx(/^\d{3}-\d{3}-\d{4}$/,
		inputField.value, helpText,
		helpMessage,
		errorImgHtml);
}

function validateEmail(inputField, helpText, helpMessage, errorImgHtml) {
	helpMessage = typeof helpMessage !== 'undefined' ? helpMessage : "Please enter an email address (for example, johndoe@acme.com).";

	// First see if the input value contains data
	if (!validateNonEmpty(inputField, helpText, helpMessage, errorImgHtml))
		return false;

	// Then see if the input value is an email address
	return validateRegEx(/^[\w\.-_\+]+@[\w-]+(\.\w{2,3})+$/,
		inputField.value, helpText,
		helpMessage,
		errorImgHtml);
}
