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
				if($user_id = $User->add()) {
					setSessionCookie($user_id, $User->user_name);
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
	
	public function showVerifyImage() {
		verify();
	}
}
?>