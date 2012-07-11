<?php
class ExamineeAction extends Action {
	public function attend() {
		if (!isset($_GET['token'])) {
			$this->error('页面错误');
		}
		
		// $this->clearSession();
		
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
				$Model = M();
				if ($questions = $Model->query("select
													pq.question_id,
													pq.question_seq,
													pq.question_score,
													case when qh.question_type in ('radio', 'checkbox') then 0 else null end as examinee_score
												from
													paper_question pq
													join
													question_head qh
													on
														pq.question_id = qh.question_id
												where
													pq.paper_id = $paperId
												order by
													pq.question_seq")) {
				// $PaperQuestion = M('PaperQuestion');
				// if ($questions = $PaperQuestion
								// ->where("paper_id = $paperId")
								// ->field('question_id, question_seq, question_score')
								// ->order('question_seq')
								// ->select()) {
					$_SESSION['questions'] = $questions;
					$_SESSION['total_mins'] = $paper['total_mins'];
					$totalCount = count($questions);
					$_SESSION['totalCount'] = $totalCount;
					$this->assign('totalCount', $totalCount);
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
		if ($this->isPost() 
			&& !empty($_SESSION['questions'])) {
			$AttendHead = D('AttendHead');
			if ($AttendHead->create()) {
				//初始化not_finish_score
				$AttendHead->not_finish_score = $this->getNotFinishScoreFlag($_SESSION['questions']);
				//事务开始
				$isSuccess = true;
				$AttendHead->startTrans();
				//插入attend head
				if ($attendId = $AttendHead->add()) {
					//插入attend detail
					if ($this->initAttendDetail($attendId, $_SESSION['questions'])) {
						$closeTime = new DateTime(date('Y-m-d H:i:s', time()));
						$closeTime->add(new DateInterval('PT'.$_SESSION['total_mins'].'M'));
						$_SESSION['closeTime'] = $closeTime;
						$_SESSION['attendId'] = $attendId;
						$_SESSION['qId'] = 0;
					} else {
						$isSuccess = false;
					}
				} else {
					$isSuccess = false;
				}
				
				if ($isSuccess) {
					$AttendHead->commit();
					$this->success();
				} else {
					$AttendHead->rollback();
					$this->error('保存失败');
				}
			} else {
				$this->error($AttendHead->getError());
			}
		}
	}
	
	private function getNotFinishScoreFlag($questions) {
		foreach($questions as $q) {
			if ($q['examinee_score'] === null) {
				return 1;
			}
		}
		return 0;
	}
	
	private function initAttendDetail($attendId, $questions) {
		for ($i = 0; $i < count($questions); $i++) {
			$questions[$i]['attend_id'] = $attendId;
			$questions[$i]['create_at'] = date('Y-m-d H:i:s', time());
		}
		$AttendDetail = M('AttendDetail');
		if ($AttendDetail->addAll($questions)) {
			return true;
		} else {
			return false;
		}
	}
	
	private function isAnsSessionValid() {
		if (empty($_SESSION['attendId'])
			|| !isset($_SESSION['qId'])
			|| empty($_SESSION['questions'])
			|| empty($_SESSION['closeTime'])
			|| empty($_SESSION['totalCount'])) {
			return false;
		} else {
			return true;
		}
	}
	
	private function getLeftTime() {
		$closeTime = $_SESSION['closeTime'];
		$currTime = new DateTime(date('Y-m-d H:i:s', time()));
		return $closeTime->diff($currTime);
	}
	
	public function answer() {
		if (!$this->isAnsSessionValid()) {
			$this->error('页面错误');
		}
		
		//1. 检查考试是否处于开发窗口
		// $closeTime = $_SESSION['closeTime'];
		// $currTime = new DateTime(date('Y-m-d H:i:s', time()));
		$leftTime = $this->getLeftTime();
		if ($leftTime <= 0) {
			redirect(__URL__.'/finish');
		}		
		// $leftTime = $closeTime->diff($currTime);
		$this->assign('leftTime', $leftTime->format('%h小时 %i分钟'));
		
		//2. 取得attend_id, qId, questions, paper_question, question_id
		$attend_id = $_SESSION['attendId'];
		$qId = $_SESSION['qId'];
		$questions = $_SESSION['questions'];
		
		$paper_question = $questions[$qId];
		$question_id = $paper_question['question_id'];		
		
		//3. 取得question_head, qType
		$QuestionHead = M('QuestionHead');
		if ($question_head = $QuestionHead
							->where("question_id = $question_id")
							->field('question_name, question_type')
							->find()) {
			$qType = $question_head['question_type'];
			
			//4. 检查是否已有用户answer，并取得cust_answer, is_mark
			$AttendDetail = M('AttendDetail');
			$attend_detail = $AttendDetail
							->where("attend_id = $attend_id and question_id = $question_id")
							->field('attend_detail_id, examinee_answer, is_mark')
							->find();
			
			$_SESSION['expect_answer'] = '';
			//5. 选择题，取得option_detail, expect_answer，在option_detail中加入cust_value列
			if ($qType == 'radio' || $qType == 'checkbox') {
				$OptionDetail = M('OptionDetail');
				$option_detail = $OptionDetail
								->where("question_id = $question_id")
								->field('item_name, option_detail_id, correct_value, 0 as cust_value')
								->select();
				//把预期结果放入SESSION中
				if (!empty($attend_detail['examinee_answer'])) {
					$ansArr = explode(',', rtrim($attend_detail['examinee_answer'], ','));
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
			//6. 问答题，取得input_detail，在input_detail中加入cust_value列
			} else if ($qType == 'textarea') {
				$InputDetail = M('InputDetail');
				$input_detail = $InputDetail
								->where("question_id = $question_id")
								->field('row_count')
								->find();
				if (!empty($attend_detail['examinee_answer'])) {
					$input_detail['cust_value'] = $attend_detail['examinee_answer'];
				} else {
					$input_detail['cust_value'] = '';
				}
				$this->assign('input_detail', $input_detail);
			}
			$this->assign('paper_question', $paper_question);			
			$this->assign('question_head', $question_head);
			$this->assign('attend_detail', $attend_detail);
			$this->assign('qId', $qId);
			$this->assign('totalCount', $_SESSION['totalCount']);
			$this->assign('browseCount', count($questions));
			
			$this->display();
		} else {
			$this->error('页面错误');
		}
	}
	
	public function addAttendDetail() {
		if ($this->isPost()
			&& $this->isAnsSessionValid()) {
			$questions = $_SESSION['questions'];
			$qId = $_SESSION['qId'];
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
			
			if (!empty($expect_answer)) {
				if ($expect_answer == $examinee_answer) {
					$data['examinee_score'] = $questions[$qId]['question_score'];
				} else {
					$data['examinee_score'] = 0;
				}
			}
			$target = $_POST['submit_btn'];
			
			$data['attend_detail_id'] = $_POST['attend_detail_id'];
			//$data['question_type'] = $_POST['question_type'];
			$data['expect_answer'] = $expect_answer;
			$data['examinee_answer'] = $examinee_answer;
			//$data['examinee_score'] = $examinee_score;
			$data['is_mark'] = $_POST['is_mark'];			
			
			$AttendDetail = M('AttendDetail');
			$AttendDetail->save($data);
			
			if ($target == 'finish') {
				redirect(__URL__.'/review');
			} else if ($target == 'prev') {
				if ($qId > 0) {
					$_SESSION['qId'] = $qId - 1;
					redirect(__URL__.'/answer');
				}
			} else if ($target == 'next') {
				if ($qId < count($questions) - 1) {
					$_SESSION['qId'] = $qId + 1;
					redirect(__URL__.'/answer');
				}
			}
		}
	}
	
	public function review() {
		if (!$this->isAnsSessionValid()) {
			$this->error('页面错误');
		}	
	
		//1. 检查考试是否处于开发窗口
		$leftTime = $this->getLeftTime();
		if ($leftTime <= 0) {
			redirect(__URL__.'/finish');
		}		
		$this->assign('leftTime', $leftTime->format('%h小时 %i分钟'));
		
		//2. 获得考卷头信息
		$attendId = $_SESSION['attendId'];
		
		$Model = M();
		if ($paper = $Model->query("select
								ep.paper_name,
								ep.paper_desc
							from
								attend_head ah
								join
								exam e
								on
									ah.exam_id = e.exam_id
								join
								exam_paper ep
								on
									e.paper_id = ep.paper_id
							where
								ah.attend_id = $attendId
							limit 1")) {
			if ($attend_detail = $Model->query("select
													ad.question_seq,
													qh.question_type,
													ad.question_score,
													ad.is_mark,
													ad.examinee_answer
												from
													attend_detail ad
													join
													question_head qh
													on
														ad.question_id = qh.question_id
												where
													attend_id = $attendId
												order by
													ad.question_seq")) {
				$this->assign('paper', $paper[0]);
				$this->assign('totalCount', $_SESSION['totalCount']);
				$this->assign('attend_detail', $attend_detail);
				
				$this->display();
			}
		}
	}
	
	public function browse() {
		if ($this->isPost() && $this->isAnsSessionValid()) {
			$qGrp = $_POST['qGrp'];
			$qId = $_POST['qId'];
			$attendId = $_SESSION['attendId'];			
			
			$AttendDetail = M('AttendDetail');
			if ($qGrp == 'mark') {
				$questions = $AttendDetail
							->where("attend_id = $attendId and is_mark = 1")
							->order("question_seq")
							->field("question_id, question_seq, question_score")
							->select();
			} else if ($qGrp == 'unanswer') {
				$questions = $AttendDetail
							->where("attend_id = $attendId and examinee_answer = ''")
							->order("question_seq")
							->field("question_id, question_seq, question_score")
							->select();
			} else {
				$questions = $AttendDetail
							->where("attend_id = $attendId")
							->order("question_seq")
							->field("question_id, question_seq, question_score")
							->select();
			}
			
			$_SESSION['questions'] = $questions;
			$_SESSION['qId'] = $qId;
			
			$this->success();
		}
	}
	
	public function finish() {
		if ($this->isAnsSessionValid()) {
			$attendId = $_SESSION['attendId'];
			$data['finish_at'] = date("Y-m-d H:i:s");
			
			$AttendHead = M('AttendHead');
			if ($AttendHead
				->where("attend_id = $attendId and finish_at = '0000-00-00 00:00:00'")
				->save($data)) {
				$this->assign('isSuccess', 1);
			} else {
				$this->assign('isSuccess', 0);
			}
			$this->clearSession();
			$this->display();
		}
	}
	
	private function clearSession() {
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 3600, '/');
		}
		session_destroy();
	}
}
?>