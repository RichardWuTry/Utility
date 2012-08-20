<?php
class AboutAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/User/login/');
		}
	}
	
	public function contactUs() {
		$user_id = $_SESSION['user_id'];
		$User = M('User');
		if ($currUser = $User->where("user_id = $user_id")
							->field("user_name, email")
							->find()) {
			$this->assign('user_name', $currUser['user_name']);
			$this->assign('email', $currUser['email']);
		}			
		$this->display();
	}
	
	public function addContactUs() {
		if ($this->isPost()) {
			$ContactUs = D('ContactUs');
			if ($ContactUs->create()) {
				if ($ContactUs->add()) {
					
					require_once COMMON_PATH.'/Mail/mail.php';
					$contact_name = $_POST['contact_name'];
					$email = $_POST['email'];
					$content = nl2br($_POST['content']);
					$body = "$contact_name($email): $content";
					sendMail(array('shadow_wu82@163.com'), '[考评牛马] 用户反馈', $body);
					
					redirect(__APP__.'/Exam/manage/');
				} else {
					redirect(__URL__.'/contactUs/');
				}
			} else {
				redirect(__URL__.'/contactUs/');
			}
		} else {
			redirect(__APP__);
		}
	}
}
?>