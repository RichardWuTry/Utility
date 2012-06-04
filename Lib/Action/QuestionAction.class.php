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
		$currSeq = $totalQ;
		$prevSeq = $currSeq - 1;
		
		$this->assign('paper_id', $paper_id);
		$this->assign('currSeq', $currSeq);
		$this->assign('totalQ', $totalQ);
		$this->assign('prevSeq', $prevSeq);
		$this->display();
	}
	
	public function edit() {
		if ((!isset($_GET['p']) || !isset($_GET['s']))
			&& !isset($_GET['q'])) {
			redirect_to(__APP__.'/Paper/create');
		}
		$paper_id = $_GET['p'];
		$currSeq = intval($_GET['s']);
		$prevSeq = $currSeq - 1;
		$PaperQuestion = M('PaperQuestion');
		if ($seq_max = $PaperQuestion->where("paper_id = $paper_id")
									->max('question_seq')) {
			$totalQ = intval($seq_max);
			if ($currSeq < $totalQ) {
				$nextSeq = $currSeq + 1;
			} else {
				$nextSeq = 0;
			}
			
			if ($question_id = $PaperQuestion
							->where("paper_id = $paper_id and question_seq = $currSeq")
							->getField('question_id')) {
				$QuestionHead = M('QuestionHead');
				if ($question_head = $QuestionHead
									->where("question_id = $question_id")
									->field('question_name, question_type')
									->find()) {
					$qType = $question_head['question_type'];
					if ($qType == 'radio' || $qType == 'checkbox') {
						$OptionDetail = M('OptionDetail');
						$option_detail = $OptionDetail
										->where("question_id = $question_id")
										->field('item_name, correct_value')
										->find();
					} else if ($qType == 'textarea') {
						$InputDetail = M('InputDetail');
						$input_detail = $InputDetail
										->where("question_id = $question_id")
										->field('row_count')
										->find();
					} else {
					
					}
				} 
			}
		}
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
				$currDateTime = date("Y-m-d H:i:s");
				if ($flag) {
					if ($qType == 'radio' || $qType == 'checkbox') {
						$OptionDetail = M('OptionDetail');						
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
						$inputDetailData['question_id'] = $QuestionHeadId;
						$inputDetailData['row_count'] = $_POST['row_count'];
						$inputDetailData['create_at'] = $currDateTime;
						
						$InputDetail = M('InputDetail');						
						if (!$InputDetail->add($inputDetailData)) {
							$flag = false;
						}
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