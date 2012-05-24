<?php
class PaperAction extends Action {
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
}
?>