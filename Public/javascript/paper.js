
function valignMainDiv() {
	var halfMainHeight = parseFloat($('#main').css('height').replace('px', ''))/2;
	var halfContentHeight = parseFloat($('#content').css('height').replace('px', ''))/2;
	if (halfContentHeight > halfMainHeight) {			
		$('#main').css('padding-top', (halfContentHeight - halfMainHeight)/2 + 'px');
	}
}

function validateThisForm() {
	var isValid = true;
	var helpMsg = $('#helpMsg');
	
	$('.non-empty').each(function(){
		var labelText = $('label[for = "' + $(this).prop('id') + '"]').text();
		var label = labelText.replace(/[:：]/g, "");
		if (label == '') {
			label = '选项';
		}
		isValid = validateNonEmpty(this, helpMsg[0], label + ' 不能为空', '');
		return isValid;
	});
	
	var optionGrp = document.getElementsByName('option[]');
	if (isValid && optionGrp.length > 0) {
		isValid = validateOptionChecked(optionGrp, helpMsg[0], '请点选正确答案', '');
	}
	
	if (!isValid) {
		helpMsg.show();
	} else {
		helpMsg.hide();
	}
	
	return isValid;
}

function submitThisForm(elementId, formObj) {
	var ajaxOptions = { 
		success:	showResponse,  // post-submit callback
		dataType:	'json',
		data: {eid: elementId}
	}; 
	
	formObj.ajaxSubmit(ajaxOptions);
}

function promptMsg(msgBox, bgColor, fColor) {
	var box = $(msgBox);
	var left = centerAlignLeft(box);
	box.css('left', left);
	if (typeof bgColor !== 'undefined') {
		box.css('background-color', bgColor);
	}
	if (typeof fColor !== 'undefined') {
		box.css('color', fColor);
	}
	box.slideDown(function() {
					setTimeout(function() { box.slideUp(); }, 
					2000)});
}

function centerAlignLeft(element) {
	var dWidth = $(document).width();
	var eWidth = $(element).width();
	return (dWidth - eWidth)/2;
}
