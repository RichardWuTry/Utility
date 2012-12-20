<?php
class GameAction extends Action {
	public function favoriteFruit() {
		$b = $_GET['b'];
		$s = $_GET['s'];
		
		$seqs = explode(',', $s);
		$seqCnt = count($seqs);
		shuffle($seqs);
				
		$imgPaths = glob("Public/images/fruits/*.jpg");
		$randNums = array_rand($imgPaths, $seqCnt);
		
		$imgs = array();
		for ($i = 0; $i < $seqCnt; $i++) {
			$img = array("id"=>$seqs[$i],
						"path"=>basename($imgPaths[$randNums[$i]]));
			array_push($imgs, $img);
		}
		
		
		$this->assign('msg', $b);
		$this->assign('imgs', $imgs);
		
		$this->display();
	}
}
?>