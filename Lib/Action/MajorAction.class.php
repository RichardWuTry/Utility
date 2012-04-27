<?php
class MajorAction extends Action {
    public function research(){
		$this->display();
    }
	
	public function addMajorResearch(){
		if (isset($_POST['submit'])) {
			$MajorResearch = M('MajorResearch');
			if ($MajorResearch->create()) {
				if ($MajorResearch->add()) {
					
				} else {
					echo 'add() failed';
				}
			} else {
				echo 'create() failed';
			}
		} else {
			redirect_to(__URL__.'/research');
		}
	}
}
?>