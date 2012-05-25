<?php
class QuestionAction extends Action {	
	public function add() {
		if (!isset($_GET['p'])) {
			redirect_to(__APP__.'/Paper/create');
			return;
		}
		$paper_id = $_GET['p'];
		
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
		
		$this->assign('currQ', $currQ);
		$this->assign('totalQ', $totalQ);
		$this->assign('prevQ', $prevQ);
		$this->display();
	}
}
?>