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
			if ($currExam['link'] != $token) {
				$this->error('页面错误');
			}
			
			$today = date("Y-m-d H:i:s");
			if ($today < $currExam['open_datetime']) {
				$this->error('考试还未开放，请确认开考时间');
			} else if ($today > $currExam['close_datetime']) {
				$this->error('考试已关闭');
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