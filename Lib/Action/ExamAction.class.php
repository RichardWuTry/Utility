<?php
class ExamAction extends Action {
	public function manage() {
		if (!isLogin()) {
			redirect_to(__APP__.'/User/login/');
		} else {
			
			$this->assign('user_name', $_SESSION['user_name']);
			$this->display();
		}
	}
}
?>