<?php
class QuestionAction extends Action {	
	public function add() {
		// if (!isset($_GET['p'])) {
			// redirect_to(__APP__.'/Paper/create');
			// return;
		// }
		$paper_id = isset($_GET['p']) ? $_GET['p'] : 0;
		
		$totalQ = 0;
		$PaperQuestion = M('PaperQuestion');
		if ($seq_max = $PaperQuestion
						->where("paper_id = $paper_id")
						->max('question_seq')) {
			$totalQ = intval($seq_max) + 1;
		} else {
			$totalQ = 1;
		}
		$currQ = $totalQ;
		$prevQ = $currQ - 1;
		
		$this->assign('paper_id', $paper_id);
		$this->assign('currQ', $currQ);
		$this->assign('totalQ', $totalQ);
		$this->assign('prevQ', $prevQ);
		$this->display();
	}
	
	public function save() {
		if ($this->isPost()) {
			$QuestionHead = D('QuestionHead');
			if ($QuestionHead->create()) {				
				$QuestionHead->startTrans();				
				$flag = true;				
				if (!$QuestionHeadId = $QuestionHead->add()) {
					$flag = false;
				}
				
				$qType = $_POST['question_type'];
				if ($flag) {
					if ($qType == 'radio' || $qType == 'checkbox') {
						$OptionDetail = M('OptionDetail');
						$currDateTime = date("Y-m-d H:i:s");
						$i = 1;
						$options = $_POST['option'];
						while (isset($_POST[$i])) {
							$data[$i-1]['question_id'] = $QuestionHeadId;
							$data[$i-1]['item_name'] = $_POST[$i];
							if (in_array($i, $options)) {
								$data[$i-1]['correct_value'] = '1';
							} else {
								$data[$i-1]['correct_value'] = '0';
							}
							$data[$i-1]['create_at'] = $currDateTime;
							$i++;
						}
						if (!$OptionDetail->addAll($data)) {
							$flag = false;					
						}
					} else if ($qType == 'textarea') {
					
					} else {
					
					}
				}				
				
				if ($flag && isset($_POST['paper_id'])) {
					$PaperQuestion = M('PaperQuestion');
					$pqData['paper_id'] = $_POST['paper_id'];
					$pqData['question_id'] = $QuestionHeadId;
					$pqData['question_seq'] = $_POST['question_seq'];
					$pqData['create_at'] = $currDateTime;
					if (!$PaperQuestion->add($pqData)) {
						$flag = false;
					}
				}				
				
				if ($flag) {				
					$QuestionHead->commit();
					$this->success($_POST['eid']);
				} else {
					$QuestionHead->rollback();
					$this->error('写入数据库错误');
				}				
			} else {
				$this->error($QuestionHead->getError());
			}
		} else {
			redirect_to(__APP__.'/Paper/create');
		}		
	}
}
?>