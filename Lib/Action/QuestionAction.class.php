<?php
class QuestionAction extends Action {	
	public function add() {
		if(!isset($_GET['paper'])) {
			redirect_to(__URL__.'/create');
			return;
		}
		
		$this->display();
	}
}
?>