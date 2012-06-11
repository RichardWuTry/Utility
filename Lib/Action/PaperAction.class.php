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
	
	public function review() {
		if (!isset($_GET['p'])) {
			$this->error('页面错误');
		}
		
		$paperId = $_GET['p'];
		$ExamPaper = M('ExamPaper');
		if ($paper = $ExamPaper
					-> where("paper_id = $paperId")
					-> field("paper_id, paper_name, total_score, total_mins, paper_desc")
					-> find()) {
			$Model = M();
			if ($question = $Model->query("select
											pq.question_seq,
											pq.question_id,
											qh.question_name,
											qh.question_type,
											qh.question_score
										from
											paper_question pq
											join
											question_head qh
											on
												pq.question_id = qh.question_id
										where
											paper_id = $paperId")) {
				$this->assign('question', $question);				
			}
			$this->assign('paper', $paper);
		}
		
		$this->display();
	}
}
?>