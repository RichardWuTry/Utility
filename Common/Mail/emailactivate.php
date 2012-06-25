<?php
function genRandomString($len)
{
	$str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxy,:=+";
	$strLength = strlen($str) - 1;
	$output = "";
	for ($i=0; $i<$len; $i++)
	{
		$output .= $str[rand(0, $strLength)];
	}
	return $output;
}

function encryptNumToAlphabet($numStr)
{
	//Log::write('$numStr:'.$numStr, Log::ERR);
	$output = "";
	$NumMapping = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for ($i = 0; $i < strlen($numStr); $i++) {
		//Log::write('$numStr[$i]:'.$numStr[$i], Log::ERR);
		//Log::write('$NumMapping[intval($numStr[$i])]:'.$NumMapping[intval($numStr[$i])], Log::ERR);
		$output .= $NumMapping[intval($numStr[$i])];
	}
	return $output;
}

function decryptAlphabetToNum($alphabetStr)
{
	$output = "";
	for ($i = 0; $i < strlen($alphabetStr); $i++) {
		$output .= strval(ord($alphabetStr[$i]) - ord('A'));
	}		
	
	return $output;
}

function encryptUserInfo($user_id, $mobile)
{
	$output = "";
		
	// 2位随机字母
	$output .= genRandomString(2);
		
	// 用户id
	$output .= encryptNumToAlphabet(strval($user_id));
		
	// 分隔符
	$output .= 'z';
		
	// 用户手机号，以随机字母间隔
	$encryptMobile = encryptNumToAlphabet($mobile);
	for ($i = 0; $i < strlen($encryptMobile); $i++) {
		$output .= genRandomString(1);
		$output .= $encryptMobile[$i];
	}
		
	// 分隔符
	$output .= 'z';
		
	// 年月日时，以随机字母间隔
	$time = date("YmdH", time());
	$encryptTime = encryptNumToAlphabet($time);
	for ($i = 0; $i < strlen($encryptTime); $i++) {
		$output .= genRandomString(1);
		$output .= $encryptTime[$i];
	}
		
	// 2位随机字母
	$output .= genRandomString(2);
	
	return $output;
}
	
function decryptUserInfo($encryptUserInfo)
{
	$outputArray = array();
	
	// 分别去除首尾两个字符
	$innerUserInfo = substr($encryptUserInfo, 2, strlen($encryptUserInfo)-4);
	
	// 用户id部分
	$zPos = strpos($innerUserInfo, 'z');
	$encryptUserId = substr($innerUserInfo, 0, $zPos);
	$user_id = decryptAlphabetToNum($encryptUserId);
	
	// 手机号部分
	$zPos2 = strpos($innerUserInfo, 'z', $zPos+1);
	$mobilePart = substr($innerUserInfo,
							$zPos + 1,
							$zPos2 - $zPos - 1);
	$encryptMobile = '';
	for ($i = 1; $i < strlen($mobilePart); $i = $i+2) {
		$encryptMobile .= $mobilePart[$i];
	}
	$mobile = decryptAlphabetToNum($encryptMobile);
			
	// 时间部分
	$timePart = substr($innerUserInfo, $zPos2 + 1);
	$encryptTime = '';
	for ($i = 1; $i < strlen($timePart); $i = $i+2) {
		$encryptTime .= $timePart[$i];
	}
	$time = decryptAlphabetToNum($encryptTime);
	$outputArray['user_id'] = $user_id;
	$outputArray['mobile'] = $mobile;
	$outputArray['time'] = $time;
	
	return $outputArray;
}
?>