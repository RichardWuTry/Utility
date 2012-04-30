<?php
function redirect_to($url, $time) {
	$url = str_replace(array("\n", "\r"), '', $url);
	if (!headers_sent()) {
		if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
		}
	}
}

function verify()
{
	require_once 'Image.class.php';
	Image::buildImageVerify(4, 1, 'gif');
}
?>