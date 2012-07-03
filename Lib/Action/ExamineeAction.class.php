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
	
	public function answer() {
		if (empty($_SESSION['attendId'])
			|| empty($_SESSION['qSeq'])
			|| empty($_SESSION['questions'])) {
			$this->error('页面错误');
		}
		
		$attend_id = $_SESSION['attendId'];
		$qSeq = $_SESSION['qSeq'];
		$questions = $_SESSION['questions'];
		
		$question_id = $questions[$qSeq-1]['question_id'];
		$question_score = $questions[$qSeq-1]['question_score'];
		
		$QuestionHead = M('QuestionHead');
		if ($question_head = $QuestionHead
							->where('question_id = $question_id')
							->field('question_id, question_name, question_type')
							->find()) {
			$qType = $question_head['question_type'];
			if ($qType == 'radio' || $qType == 'checkbox') {
				$OptionDetail = M('OptionDetail');
				$option_detail = $OptionDetail
								->where("question_id = $question_id")
								->field('item_name, correct_value')
								->select();
				foreach ($option_detail as $record) {
					$expect_answer .= $record['correct_value'];
				}
				$_SESSION['expect_answer'] = $expect_answer;
				$this->assign('option_detail', $option_detail);
			} else if ($qType == 'textarea') {
				$InputDetail = M('InputDetail');
				$input_detail = $InputDetail
								->where("question_id = $question_id")
								->field('row_count')
								->find();
				$this->assign('input_detail', $input_detail);
			}
			$this->assign('qSeq', $qSeq);
			$this->assign('total_question_count', count($questions));
			$this->assign('question_score', $question_score);
			$this->assign('qType', $qType);
			$this->assign('question_head', $question_head);
			
			$this->display();
		} else {
			$this->error('页面错误');
		}
	}
}
?>