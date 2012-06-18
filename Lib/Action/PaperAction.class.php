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
											pq.paper_question_id,
											pq.question_seq,
											pq.question_id,
											qh.question_name,
											qh.question_type,
											pq.question_score
										from
											paper_question pq
											join
											question_head qh
											on
												pq.question_id = qh.question_id
										where
											paper_id = $paperId")) {
				foreach ($question as $row) {
					$sumScore = $sumScore + $row['question_score'];
				}							
				$this->assign('sumScore', $sumScore);							
				$this->assign('question', $question);				
			}
			$this->assign('paper', $paper);
			$this->display();
		}
	}
	
	public function edit() {
		if (!isset($_GET['p'])) {
			$this->error('页面错误');
		}

		$paperId = $_GET['p'];
		$ExamPaper = M('ExamPaper');
		if ($paper = $ExamPaper
					-> where("paper_id = $paperId")
					-> field("paper_id, paper_name, total_score, total_mins, paper_desc")
					-> find()) {
			$this->assign('paper', $paper);
			$this->display();		
		} else {
			$this->error('页面错误');
		}
	}
	
	public function updatePaper() {
		if ($this->isPost()) {
			$ExamPaper = D('ExamPaper');
			if ($ExamPaper->create()) {
				if ($ExamPaper->save() === false) {
					$this->error('写入数据库错误');
				} else {
					$this->success();
				}
			} else {
				$this->error($ExamPaper->getError());
			}
		} else {
			$this->error('页面错误');
		}
	}
	
	public function updateScore() {
		if ($this->isPost()) {
			$PaperQuestion = M('PaperQuestion');
			$scoreData['paper_question_id'] = $_POST['paper_question_id'];
			$scoreData['question_score'] = $_POST['question_score'];
			if (false === $PaperQuestion->save($scoreData)) {
				$this->error($PaperQuestion->getError());
			} else {
				$this->success('分值保持成功');
			}
		}
	}
	
	public function batchUpdateScore() {
		if ($this->isPost()) {
			$batchOptionScore = $_POST['batchOptionScore'];
			$batchInputScore = $_POST['batchInputScore'];
			$paperId = $_POST['paper_id'];
			
			$isSuccess = true;
			$Model = M();
			if (is_numeric($batchOptionScore)) {
				if(false === $Model->execute("update
											  paper_question pq,
											  question_head qh
											set
											  pq.question_score = $batchOptionScore
											where
											  pq.paper_id = $paperId
											  and
											  qh.question_type in ('radio', 'checkbox')
											  and
											  pq.question_id = qh.question_id")) {
					$isSuccess = false;		
				}
			}
			
			if ($isSuccess && is_numeric($batchInputScore)) {
				if(false === $Model->execute("update
											  paper_question pq,
											  question_head qh
											set
											  pq.question_score = $batchInputScore
											where
											  pq.paper_id = $paperId
											  and
											  qh.question_type in ('textarea')
											  and
											  pq.question_id = qh.question_id")) {
					$isSuccess = false;											  
				}
			}
			
			if (!$isSuccess) {
				$this->error('写入数据出错');
			} else {
				$this->success('分值保存成功');
			}
		}
	}
	
	public function removeQuestion() {
		if ($this->isPost()) {
			$pqId = $_POST['pqId'];
			$PaperQuestion = M('PaperQuestion');
			if (false === $PaperQuestion
						->where("paper_question_id = $pqId")
						->delete()) {
				$this->error($PaperQuestion->getError());
			} else {
				$this->success('考题移除成功');
			}
			
		}
	}
}
?>