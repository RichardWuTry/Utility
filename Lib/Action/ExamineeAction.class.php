<?php
class ExamineeAction extends Action {
	public function attend() {
		if (!isset($_GET['token'])) {
			$this->error('页面错误');
		}
		
		$token = $_GET['token'];
		$tokenData = $this->parseLink($token);
		$Exam = M('Exam');
		if ($currExam = $Exam
						->where('exam_id = '.$tokenData['examId'])
						->field('exam_id, paper_id, open_datetime, close_datetime, link')
						->find()) {
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
						->where('paper_id = '.$currExam['paper_id'])
						->field('paper_id, paper_name, total_score, total_mins, paper_desc')
						->find()) {
				//存储问题到Session中						
				
						
				$this->assign('paper', $paper);
				$this->display();
			} else {
				$this->error('页面错误');
			}
		} else {
			$this->error('页面错误');
		}
	}
	
	private function parseLink($token) {
		$begin = substr($token, 0, 10);
		$examId = decryptAlphabetToNum(substr($token, 10, strlen($token)-20));
		$end = substr($token, -10);
		$tokenData['begin'] = $begin;
		$tokenData['examId'] = $examId;
		$tokenData['end'] = $end;
		
		return $tokenData;
	}
}
?>