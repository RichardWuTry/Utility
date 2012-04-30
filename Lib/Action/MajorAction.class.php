<?php
class MajorAction extends Action {
    public function research(){
		$this->display();
    }
	
	public function addMajorResearch(){
		if (isset($_POST['submit'])) {
			if($_SESSION['verify'] != md5($_POST['verify'])){
				$this->error('验证码错误');
			}
			$MajorResearch = D('MajorResearch');
			if ($MajorResearch->create()) {
				if ($MajorResearch->add()) {
					$this->success();
				} else {
					$this->error('写入数据库错误');
				}
			} else {
				//$this->error('some error');
				$this->error($MajorResearch->getError());
			}
		} else {
			redirect_to(__URL__.'/research');
		}
	}
	
	public function showVerifyImage() {
		verify();
	}
}
?>