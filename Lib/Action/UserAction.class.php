<?php
class UserAction extends Action {
	public function register() {
		$this->display();
	}
	
	public function addUser() {
		if($this->isPost()) {
			$User = D('User');
			if($_SESSION['verify'] != md5($_POST['verify'])){
				$this->error('验证码不匹配');
			}
			
			if($User->create()) {
				if(!preg_match('/^.{6,12}$/', $User->password)){
					$this->error('密码有效长度为6~12位');
				}				
				
				$User->password = sha1($User->password);
				$username = $User->user_name;
				if($user_id = $User->add()) {
					setSessionCookie($user_id, $username);
					$this->success('注册成功');
				} else {
					$this->error('保存失败');
				}				
			} else {
				$this->error($User->getError());
			}
		}
	}
	
	public function login() {
		$this->display();
	}
	
	public function loginUser() {
		if($this->isPost()) {
			$email = $_POST['email'];
			$shaPwd = sha1($_POST['password']);
			$User = M('User');
			if ($currUser = $User
							->where("email = '$email' and password = '$shaPwd'")
							->field("user_id, user_name")
							->find()) {
				setSessionCookie($currUser['user_id'], $currUser['user_name']);
				$this->success('登录成功');
			} else {
				$this->error('邮箱或密码错误');
			}
		}
	}
	
	public function logout() {
		clearSessionCookie();
		redirect(__APP__.'/User/login/');
	}
	
	public function showVerifyImage() {
		verify();
	}
	
	public function forgotPassword() {
		$this->display();
	}
	
	public function newPasswordEmail() {
		if ($this->isPost()) {
			$email = $_POST['email'];
			$User = M('User');
			if ($currUser = $User
							->where("email = '$email'")
							->field("user_id, user_name")
							->find()) {
				$token = encryptId($currUser['user_id']);				
				
				$subject = '[考评牛马] 重置密码';
				$body = $this->prepareEmailBody($currUser['user_name'], $token);
				require_once COMMON_PATH.'/Mail/mail.php';
				if (sendMail(array($email), $subject, $body)) {
					$this->success('几分钟后，您将收到重置密码的电子邮件');
				} else {
					$this->error('重置密码邮件发送失败');
				}
			} else {
				$this->error('该邮箱没有找到');
			}
		}
	}
	
	private function prepareEmailBody($userName, $token) {
		$serverName = $_SERVER["SERVER_NAME"];
		$index_page_link = "http://$serverName".__APP__;
		$reset_password_link = "http://$serverName".__URL__."/resetPassword/token/$token/";
		
		$body = file_get_contents(TMPL_PATH.'/User/newPasswordEmail.html');
		$body = mb_eregi_replace('{index_page}', $index_page_link, $body);
		$body = mb_eregi_replace('{user_name}', $userName, $body);		
		$body = mb_eregi_replace('{reset_password_link}', $reset_password_link, $body);
		
		return $body;
	}
	
	public function resetPassword() {
		if ($token = $_GET['token']) {
			if ($id = decryptToken($token)) {
				$_SESSION['id'] = $id;				
				$this->display();
			} else {
				redirect(__APP__);
			}
		} else {
			redirect(__APP__);
		}
	}
	
	public function savePassword() {
		if ($this->isPost() && !empty($_SESSION['id'])) {
			$user_id = $_SESSION['id'];
			$email = $_POST['email'];
			$data['password'] = sha1($_POST['password']);
			
			$User = M('User');
			if ($User->where("user_id = $user_id and email = '$email'")
					->save($data)) {
				$currUser = $User->where("user_id = $user_id")
								->field("user_id, user_name")
								->find();
				setSessionCookie($currUser['user_id'], $currUser['user_name']);				
				unset($_SESSION['id']);
				$this->success();
			} else {
				$this->error('请输入原始注册邮箱');
			}
		} else {
			redirect(__APP__);
		}
	}
}
?>