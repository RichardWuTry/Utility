<?php
class ExamAction extends Action {
	function __construct() {
		parent::__construct();
		if (!isLogin()) {
			redirect_to(__APP__.'/User/login/');
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
			redirect_to(__URL__.'/manage/');
		}
		
		$paperId = $_GET['p'];
		$Model = M();
		if ($Papers = $Model->query("select
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
			$this->assign('paper', $Papers[0]);
			$this->assign('user_name', $_SESSION['user_name']);
			$this->display();
		} else {
			redirect_to(__URL__.'/manage/');
		}
	}
}
?>