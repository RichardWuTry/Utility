
function valignMainDiv() {
	var halfMainHeight = parseFloat($('#main').css('height').replace('px', ''))/2;
	var halfContentHeight = parseFloat($('#content').css('height').replace('px', ''))/2;
	if (halfContentHeight > halfMainHeight) {			
		$('#main').css('padding-top', (halfContentHeight - halfMainHeight)/2 + 'px');
	}
}