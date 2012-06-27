<?php
class QuestionAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect_to(__APP__.'/User/login/');
		}
	}
	
	public function add() {
		// $paper_id = isset($_GET['p']) ? $_GET['p'] : 0;
		
		// $totalQ = 0;
		// $PaperQuestion = M('PaperQuestion');
		// if ($seq_max = $PaperQuestion
						// ->where("paper_id = $paper_id")
						// ->max('question_seq')) {
			// $totalQ = intval($seq_max) + 1;
		// } else {
			// $totalQ = 1;
		// }
		// $currSeq = $totalQ;
		// $prevSeq = $currSeq - 1;
		
		// $this->assign('paper_id', $paper_id);
		// $this->assign('currSeq', $currSeq);
		// $this->assign('totalQ', $totalQ);
		// $this->assign('prevSeq', $prevSeq);
		$QuestionNav = new QuestionNav($_GET['p'], 0, 'add');
		$this->assign('QuestionNav', $QuestionNav);
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
	
	public function edit() {
		if (!isset($_GET['q'])) {
			$this->error('页面错误');
		}
		$question_id = $_GET['q'];
		
		$QuestionHead = M('QuestionHead');
		if ($question_head = $QuestionHead
							->where("question_id = $question_id")
							->field('question_id, question_name, question_type')
							->find()) {
			$qType = $question_head['question_type'];
			if ($qType == 'radio' || $qType == 'checkbox') {
				$OptionDetail = M('OptionDetail');
				$option_detail = $OptionDetail
								->where("question_id = $question_id")
								->field('item_name, correct_value')
								->select();
				$this->assign('option_detail', $option_detail);
			} else if ($qType == 'textarea') {
				$InputDetail = M('InputDetail');
				$input_detail = $InputDetail
								->where("question_id = $question_id")
								->field('input_detail_id, row_count')
								->find();
				$this->assign('input_detail', $input_detail);
			}
			$this->assign('question_head', $question_head);
			if (isset($_GET['p']) && isset($_GET['s'])) {
				$p = $_GET['p'];
				$s = $_GET['s'];
				$this->assign('fromUrl', __URL__."/review/p/$p/s/$s");
			}
			$this->display();
		}
	}
	
	public function update() {
		if (!$this->isPost()) {
			$this->error('页面错误');
		}
		
		$qId = $_POST['question_id'];
		$QuestionHead = M('QuestionHead');
		$qHeadData['question_id'] = $qId;
		$qHeadData['question_name'] = $_POST['question_name'];
		$QuestionHead->startTrans();
		$flag = true;
		
		if (false === $QuestionHead->save($qHeadData)) {
			$flag = false;
		}		
		
		$qType = $_POST['question_type'];
		$currDateTime = date("Y-m-d H:i:s");
		if ($flag) {
			if ($qType == 'radio' || $qType == 'checkbox') {
				$OptionDetail = M('OptionDetail');
				if (false === $OptionDetail->where("question_id = $qId")->delete()) {
					$flag = false;
				}
				
				if ($flag) {
					$i = 1;
					$options = $_POST['option'];
					while (isset($_POST[$i])) {
						$data[$i-1]['question_id'] = $qId;
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
				}
			} else if ($qType == 'textarea') {
				$inputDetailData['input_detail_id'] = $_POST['input_detail_id'];
				$inputDetailData['row_count'] = $_POST['row_count'];
				
				$InputDetail = M('InputDetail');						
				if (false === $InputDetail->save($inputDetailData)) {
					$flag = false;
				}
			}
		}
		
		if ($flag) {				
			$QuestionHead->commit();
			$this->success();
		} else {
			$QuestionHead->rollback();
			$this->error('写入数据库错误');
		}	
	}
	
	public function review() {
		if (!isset($_GET['p']) || !isset($_GET['s'])) {
			$this->error('页面错误');
		}
		
		$QuestionNav = new QuestionNav($_GET['p'], $_GET['s'], 'review');
		if ($question_id = $this->getQuestionId($QuestionNav->paper_id, $QuestionNav->currSeq)) {
			$QuestionHead = M('QuestionHead');
			if ($question_head = $QuestionHead
								->where("question_id = $question_id")
								->field('question_id, question_name, question_type')
								->find()) {
				$qType = $question_head['question_type'];
				if ($qType == 'radio' || $qType == 'checkbox') {
					$OptionDetail = M('OptionDetail');
					$option_detail = $OptionDetail
									->where("question_id = $question_id")
									->field('item_name, correct_value')
									->select();
					$this->assign('option_detail', $option_detail);
				} else if ($qType == 'textarea') {
					$InputDetail = M('InputDetail');
					$input_detail = $InputDetail
									->where("question_id = $question_id")
									->field('row_count')
									->find();
					$this->assign('input_detail', $input_detail);
				}
				$this->assign('question_head', $question_head);
				$this->assign('QuestionNav', $QuestionNav);
				$this->display();
			}			
		}		
	}

	private function getQuestionId($pId, $seqId) {
		$PaperQuestion = M('PaperQuestion');
		if ($question_id = $PaperQuestion
							->where("paper_id = $pId and question_seq = $seqId")
							->getField('question_id')) {
			return $question_id;
		} else {
			return false;
		}
	}
}

class QuestionNav {
	public $paper_id = 0;
	public $currSeq = 0;
	public $prevSeq = 0;
	public $nextSeq = 0;
	public $totalQ = 0;
	
	public function __construct($pid, $seq, $action) {
		$this->paper_id = empty($pid) ? 0 : intval($pid);
		//向题库添加新题
		if ($this->paper_id == 0) {
			return;
		}
		$PaperQuestion = M('PaperQuestion');
		//获得该考卷最大question_seq，若取不到则保持为0
		if ($seq_max = $PaperQuestion->where("paper_id = $this->paper_id")
									->max('question_seq')) {
			$this->totalQ = intval($seq_max);
		}
								
		if ($action == 'add') {
			$this->totalQ++;
			$this->currSeq = $this->totalQ;			
			$this->nextSeq = 0;
		} else if ($action == 'review') {
			$this->currSeq = empty($seq) ? 1 : intval($seq);
			if ($this->currSeq < $this->totalQ) {
				$this->nextSeq = $this->currSeq + 1;
			} else {
				$this->nextSeq = 0;
			}
		} 
		$this->prevSeq = $this->currSeq - 1;
	}
}
?>