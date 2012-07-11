<?php
class ExamAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect(__APP__.'/User/login/');
		}
	}
	
	public function manage() {
		$userId = $_SESSION['user_id'];
		$Model = M();
		if ($Papers = $Model->query("select
						p.paper_id,
						p.paper_name,
						p.total_score,
						p.total_mins,
						case when
							sum(q.question_score) = p.total_score
						then
							1
						else
							0
						end as is_score_balance,
						count(q.question_id) as question_count
					from
						exam_paper p
						join
						user_paper u
						on
							p.paper_id = u.paper_id
						join
						paper_question q
						on
							p.paper_id = q.paper_id
					where
						u.user_id = $userId						
					group by
						p.paper_id,
						p.paper_name,
						p.total_score,
						p.total_mins
					order by
						p.modify_at desc")) {
			$this->assign('papers', $Papers);			
		}
		
		$this->assign('user_name', $_SESSION['user_name']);
		$this->display();
	}
	
	public function arrange() {
		if (!isset($_GET['p'])) {
			redirect(__URL__.'/manage/');
		}
		
		$paperId = $_GET['p'];
		$Model = M();
		if ($papers = $Model->query("select
						p.paper_id,
						p.paper_name,
						p.total_mins,
						count(q.question_id) as question_count
					from
						exam_paper p
						join
						paper_question q
						on
							p.paper_id = q.paper_id
					where
						p.paper_id = $paperId						
					group by
						p.paper_id,
						p.paper_name,
						p.total_mins")) {
			$userId = $_SESSION['user_id'];
			$Exam = M('Exam');
			if ($exams = $Exam
						->where("user_id = $userId and paper_id = $paperId and close_datetime > now() and is_active = 1")
						->field('open_datetime, close_datetime, link')
						->select()) {
				$this->assign('exams', $exams);
			}		
						
			$this->assign('paper', $papers[0]);
			$this->assign('user_name', $_SESSION['user_name']);
			$this->assign('user_id', $userId);
			$this->assign('serverName', $_SERVER["SERVER_NAME"]);
			$this->display();
		} else {
			redirect(__URL__.'/manage/');
		}
	}
	
	public function addExam() {		
		if ($this->isPost()) {
			$paperId = $_POST['paper'];
			$userId = $_POST['user'];
		
			$Exam = M('Exam');			
			$examData['open_datetime'] = $_POST['open'];
			$examData['close_datetime'] = $_POST['close'];
			$examData['paper_id'] = $paperId;
			$examData['user_id'] = $userId;
			$examData['create_at'] = date('Y-m-d H:i:s');
			
			$Exam->startTrans();
			$isSuccess = true;
			if ($examId = $Exam->add($examData)) {
		
				$link = $this->genLink($examId, $paperId, $userId);
				$linkData['exam_id'] = $examId;
				$linkData['link'] = $link;
				if (false === $Exam->save($linkData)) {
					$isSuccess = false;
				}
			} else {
				$isSuccess = false;
			}
			
			if ($isSuccess) {
				$Exam->commit();
				$this->success($link);
			} else {
				$Exam->rollback();
				$this->error('保存失败');
			}
		}
	}
	
	private function genLink($examId, $paperId, $userId) {
		$secretExamId = $this->encryptExamId($examId);
		$shaStr = sha1($paperId.$userId);
		$beginStr = substr($shaStr, 7, 10);
		$endStr = substr($shaStr, 23, 10);
		return $beginStr.$secretExamId.$endStr;
	}
	
	private function encryptExamId($examId) {
		$strExamId = (string)$examId;
		$len = strlen($strExamId);
		if ($len > 1) {
			$loopCount = rand(1, $len);
			for ($i = 0; $i < $loopCount; $i++) {
				$poz = rand(0, $len - 1);
				$strExamId[$poz] = encryptNumToAlphabet($strExamId[$poz]);
			}
		}		
		return $strExamId;
	}
	
	public function review() {
		$userId = $_SESSION['user_id'];
		$Model = M();
		if ($exams = $Model->query("select
									  e.exam_id,
									  ep.paper_name,
									  e.open_datetime,
									  e.close_datetime,
									  count(ah.attend_id) as answer_count,
									  ifnull(sum(ah.not_finish_score),0) as not_all_score
									from
									  exam e
									  join
									  exam_paper ep
									  on
										  e.paper_id = ep.paper_id
									  left join
									  attend_head ah
									  on
										  e.exam_id = ah.exam_id
									where
									  e.user_id = $userId
									group by
									  ep.paper_name,
									  e.open_datetime,
									  e.close_datetime
									order by
									  e.close_datetime desc")) {
			$this->assign('exams', $exams);
			$this->assign('user_name', $_SESSION['user_name']);
		}	
		
		$this->display();
	}
	
	public function answers() {
		$examId = $_GET['e'];
		$userId = $_SESSION['user_id'];
		
		$Model = M();
		$examinees = $Model->query("select
									ah.examinee_id,
									ah.examinee_name,
									ah.mobile,
									ah.id_card,
									ah.not_finish_score,
									sum(case when qh.question_type in ('radio', 'checkbox') then ad.examinee_score else 0 end) as obj_score,
									sum(case when qh.question_type not in ('radio', 'checkbox') then ad.examinee_score else 0 end) as subj_score,
									sum(ad.examinee_score) total_score
								from
									attend_head ah
									join
									exam e
									on
										ah.exam_id = e.exam_id
									join
									attend_detail ad
									on
										ah.attend_id = ad.attend_id
									join
									question_head qh
									on
										ad.question_id = qh.question_id
								where
									ah.exam_id = $examId
									and
									e.user_id = $userId
								group by
									ah.examinee_id,
									ah.examinee_name,
									ah.mobile,
									ah.id_card");
		$this->assign('examinees', $examinees);
		$this->assign('user_name', $_SESSION['user_name']);
		
		$this->display();
	}
}
?>