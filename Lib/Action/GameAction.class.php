<?php
class GameAction extends Action {
	public function favoriteFruit() {
		$b = $_GET['b'];
		$s = $_GET['s'];
		
		$seqs = explode(',', $s);
		
		$images = glob("../../Public/images/fruits/*.jpg");
		foreach($images as $img) {
			echo $img;
		}
		
		$this->assign('backName', $b);
		
		$this->display();
	}
}
?>