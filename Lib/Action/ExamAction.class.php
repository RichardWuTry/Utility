<?php
class ExamAction extends Action {
	public function manage() {
		$this->display();
	}
	
	public function create() {
		$this->display();
	}
	
	public function savePaper() {
		if (isset($_POST['submit'])) {
			$ExamPaper = D('ExamPaper');
			if ($ExamPaper->create()) {
				if ($paperId = $ExamPaper->add()) {
					$this->success($paperId);
				} else {
					$this->error('写入数据库错误');
				}
			} else {
				$this->error($ExamPaper->getError());
			}
		} else {
			redirect_to(__URL__.'/create');
		}
	}
	
	public function addQuestion() {
		if(!isset($_GET['paper'])) {
			redirect_to(__URL__.'/create');
			return;
		}
		
		$this->display();
	}
}
?>