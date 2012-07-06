<?php
class ExamineeAction extends Action {
	public function attend() {
		if (!isset($_GET['token'])) {
			$this->error('页面错误');
		}
		
		$token = $_GET['token'];
		$examId = $this->parseExamId($token);
		$Exam = M('Exam');
		if ($currExam = $Exam
						->where("exam_id = $examId")
						->field('paper_id, open_datetime, close_datetime, link')
						->find()) {
			$paperId = 	$currExam['paper_id'];		
			
			//比对数据库中的token与链接中的token
			if ($currExam['link'] != $token) {
				$this->error('页面错误');
			}
			
			//验证考试是否开放
			$today = date("Y-m-d H:i:s");
			if ($today < $currExam['open_datetime']) {
				$this->error('考试还未开放，请确认开考时间');
			} else if ($today > $currExam['close_datetime']) {
				$this->error('考试已关闭');
			}
			
			//显示考卷的卷头信息
			$ExamPaper = M('ExamPaper');
			if ($paper = $ExamPaper
						->where("paper_id = $paperId")
						->field('paper_id, paper_name, total_score, total_mins, paper_desc')
						->find()) {
				//存储考卷问题到Session中
				$PaperQuestion = M('PaperQuestion');
				if ($questions = $PaperQuestion
								->where("paper_id = $paperId")
								->field('question_id, question_score')
								->order('question_seq')
								->select()) {
					$_SESSION['questions'] = $questions;
					$_SESSION['total_mins'] = $paper['total_mins'];
					$this->assign('qCount', count($questions));
					$this->assign('paper', $paper);
					$this->assign('examId', $examId);
					$this->display();
				} else {
					$this->error('页面错误');
				}
			} else {
				$this->error('页面错误');
			}
		} else {
			$this->error('页面错误');
		}
	}
	
	private function parseExamId($token) {
		$examId = decryptAlphabetToNum(substr($token, 10, strlen($token)-20));	
		return $examId;
	}
	
	public function addAttendHead() {
		if ($this->isPost()) {
			$AttendHead = D('AttendHead');
			if ($AttendHead->create()) {
				if ($attendId = $AttendHead->add()) {
					$closeTime = new DateTime(date('Y-m-d H:i:s', time()));
					$closeTime->add(new DateInterval('PT'.$_SESSION['total_mins'].'M'));
					$_SESSION['closeTime'] = $closeTime;
					$_SESSION['attendId'] = $attendId;
					$_SESSION['qSeq'] = 1;
					$this->success();
				} else {
					$this->error('保存失败');
				}
			} else {
				$this->error($AttendHead->getError());
			}
		}
	}
	
	private function isAnsSessionValid() {
		if (empty($_SESSION['attendId'])
			|| empty($_SESSION['qSeq'])
			|| empty($_SESSION['questions'])
			|| empty($_SESSION['closeTime'])) {
			return false;
		} else {
			return true;
		}
	}
	
	public function answer() {
		if (!$this->isAnsSessionValid()) {
			$this->error('页面错误');
		}
		
		$closeTime = $_SESSION['closeTime'];
		$currTime = new DateTime(date('Y-m-d H:i:s', time()));
		if ($closeTime <= $currTime) {
			redirect(__URL__.'/finish');
		}
		
		$leftTime = $closeTime->diff($currTime);
		$this->assign('leftTime', $leftTime->format('%H : %I'));
		
		$attend_id = $_SESSION['attendId'];
		$qSeq = $_SESSION['qSeq'];
		$questions = $_SESSION['questions'];
		
		$question_id = $questions[$qSeq-1]['question_id'];
		$question_score = $questions[$qSeq-1]['question_score'];
		
		
		$QuestionHead = M('QuestionHead');
		if ($question_head = $QuestionHead
							->where("question_id = $question_id")
							->field('question_id, question_name, question_type')
							->find()) {
			$qType = $question_head['question_type'];
			//检查是否已有用户answer
			$AttendDetail = M('AttendDetail');
			if ($attend_detail = $AttendDetail
								->where("attend_id = $attend_id and question_id = $question_id")
								->field('examinee_answer, is_mark')
								->find()) {
				$cust_answer = $attend_detail['examinee_answer'];
				$is_mark = $attend_detail['is_mark'];
			} else {
				$cust_answet = '';
				$is_mark = 0;
			}
			
			$_SESSION['expect_answer'] = '';
			if ($qType == 'radio' || $qType == 'checkbox') {
				$OptionDetail = M('OptionDetail');
				$option_detail = $OptionDetail
								->where("question_id = $question_id")
								->field('item_name, option_detail_id, correct_value, 0 as cust_value')
								->select();
				//把预期结果放入SESSION中
				if (!empty($cust_answer)) {
					$ansArr = explode(',', rtrim($cust_answer, ','));
				}
				for ($i = 0; $i < count($option_detail); $i++) {
					if ($option_detail[$i]['correct_value'] == '1') {
						$expect_answer = $expect_answer.$option_detail[$i]['option_detail_id'].',';
					}
					if (in_array($option_detail[$i]['option_detail_id'], $ansArr)) {
						$option_detail[$i]['cust_value'] = 1;
					} else {
						$option_detail[$i]['cust_value'] = 0;
					}
				}

				$_SESSION['expect_answer'] = $expect_answer;
				$this->assign('option_detail', $option_detail);
			} else if ($qType == 'textarea') {
				$InputDetail = M('InputDetail');
				$input_detail = $InputDetail
								->where("question_id = $question_id")
								->field('row_count')
								->find();
				if (!empty($cust_answer)) {
					$input_detail['cust_value'] = $cust_answer;
				} else {
					$input_detail['cust_value'] = '';
				}
				$this->assign('input_detail', $input_detail);
			}
			$this->assign('qSeq', $qSeq);
			$this->assign('total_question_count', count($questions));
			$this->assign('question_head', $question_head);
			$this->assign('is_mark', $is_mark);
			$this->assign('question_score', $question_score);
			
			$this->display();
		} else {
			$this->error('页面错误');
		}
	}
	
	public function addAttendDetail() {
		if ($this->isPost()
			&& $this->isAnsSessionValid()) {
			$attend_id = $_SESSION['attendId'];
			$questions = $_SESSION['questions'];
			$qSeq = $_SESSION['qSeq'];
			$question_id = $questions[$qSeq-1]['question_id'];
			$question_score = $questions[$qSeq-1]['question_score'];
			$expect_answer = $_SESSION['expect_answer'];
			
			if (isset($_POST['examinee_answer'])) {
				$examinee_answer = $_POST['examinee_answer'];
			} else if (isset($_POST['option'])){
				$options = $_POST['option'];
				foreach ($options as $o) {
					$examinee_answer = $examinee_answer.$o.',';
				}
			} else {
				$examinee_answer = '';
			}
			
			if (!empty($expect_answer) && $expect_answer == $examinee_answer) {
				$examinee_score = $question_score;
			} else {
				$examinee_score = 0;
			}
			$is_mark = $_POST['is_mark'];
			$target = $_POST['submit_btn'];
			
			$data['attend_id'] = $attend_id;
			$data['question_id'] = $question_id;
			$data['question_type'] = $_POST['question_type'];
			$data['question_score'] = $question_score;
			$data['expect_answer'] = $expect_answer;
			$data['examinee_answer'] = $examinee_answer;
			$data['examinee_score'] = $examinee_score;
			$data['is_mark'] = $is_mark;
			$data['create_at'] = date("Y-m-d H:i:s");
			
			//判断是add还是update
			$AttendDetail = M('AttendDetail');
			if ($attend_detail = $AttendDetail
								->where("attend_id = $attend_id and question_id = $question_id")
								->field('attend_detail_id')
								->find()) {
				//update
				$data['attend_detail_id'] = $attend_detail['attend_detail_id'];
				$AttendDetail->save($data);
			} else {
				//add
				$AttendDetail->add($data);
			}
			
			if ($target == 'finish') {
				redirect(__URL__.'/review');
			} else if ($target == 'prev') {
				if ($qSeq - 1 > 0) {
					$_SESSION['qSeq'] = $qSeq - 1;
					redirect(__URL__.'/answer');
				}
			} else if ($target == 'next') {
				if ($qSeq + 1 <= count($questions)) {
					$_SESSION['qSeq'] = $qSeq + 1;
					redirect(__URL__.'/answer');
				}
			}
		}
	}
	
	public function review() {
		
	}
}
?>