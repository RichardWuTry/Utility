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

function verify() {
	require_once COMMON_PATH.'/Image.class.php';
	Image::buildImageVerify(4, 1, 'gif');
}

function setSessionCookie($user_id, $user_name) {
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user_name'] = $user_name;
	setcookie('user_id', $user_id, time() + (60 * 60 * 24 * 30), '/');
	setcookie('user_name', $user_name, time() + (60 * 60 * 24 * 30), '/');
}

function clearSessionCookie() {
	if (isset($_SESSION['user_id'])) {
		// 清空session
		$_SESSION = array();
		// 删除session cookie
		if (isset($_COOKIE[session_name()])) {
		  setcookie(session_name(), '', time() - 3600, '/');
		}
		// 销毁session
		session_destroy();
	}
	// 删除user_id和username cookies
	setcookie('user_id', '', time() - 3600, '/');
	setcookie('user_name', '', time() - 3600, '/');
}

function isLogin() {
	if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
		return true;
	} else {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])){
			$_SESSION['user_id'] = $_COOKIE['user_id'];
			$_SESSION['user_name'] = $_COOKIE['user_name'];
			return true;
		} else {
			return false;
		}
	}
}


?>