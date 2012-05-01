<?php
class MajorAction extends Action {
    public function research(){
		$this->display();
    }
	
	public function addMajorResearch(){
		if (isset($_POST['submit'])) {
			if($_SESSION['verify'] != md5($_POST['verify'])){
				$this->error('验证码错误');
			}
			$MajorResearch = D('MajorResearch');
			if ($MajorResearch->create()) {
				if ($MajorResearch->add()) {
					$this->success();
				} else {
					$this->error('写入数据库错误');
				}
			} else {
				$this->error($MajorResearch->getError());
			}
		} else {
			redirect_to(__URL__.'/research');
		}
	}
	
	public function researchResult(){
		$MajorResearch = M('MajorResearch');
		if ($result = $MajorResearch->select()) {
			$male = 0; $female = 0;
			$bachelor = 0; $master = 0; $doctor = 0;
			$workYear0_5 = 0; $workYear6_10 = 0; $workYear11_15 = 0; $workYear16_20 = 0; $workYear21_25 = 0; $workYear26_ = 0;
			foreach($result as $item) {
				if ($item['gender'] == '男') {
					$male++;
				} else {
					$female++;
				}
				
				if ($item['highest_edu'] == '本科') {
					$bachelor++;
				} else if ($item['highest_edu'] == '硕士') {
					$master++;
				} else {
					$doctor++;
				}
				
				if ($item['work_year'] >= 0 && $item['work_year'] <= 5) {
					$workYear0_5++;
				} else if ($item['work_year'] >= 6 && $item['work_year'] <= 10) {
					$workYear6_10++;
				} else if ($item['work_year'] >= 11 && $item['work_year'] <= 15) {
					$workYear11_15++;
				} else if ($item['work_year'] >= 16 && $item['work_year'] <= 20) {
					$workYear16_20++;
				} else if ($item['work_year'] >= 21 && $item['work_year'] <= 25) {
					$workYear21_25++;
				} else {
					$workYear26_++;
				}
			}
			
			$gender = "[['男', $male], ['女', $female]]";
			$highest_edu = "[['本科', $bachelor], ['硕士', $master], ['博士', $doctor]]";
			$work_year = "[$workYear0_5, $workYear6_10, $workYear11_15, $workYear16_20, $workYear21_25, $workYear26_]";
			$work_year_ticks = "['0~5', '6~10', '11~15', '16~20', '21~25', '26~']";
			
			$this->assign('count', count($result)); //总人数
			$this->assign('gender', $gender); //性别
			$this->assign('highest_edu', $highest_edu); //最高学历
			$this->assign('work_year', $work_year); $this->assign('work_year_ticks', $work_year_ticks);//工作年限
			
			$this->display();
		} else {
			redirect_to(__URL__.'/research');
		}
		
	}
	
	public function showVerifyImage() {
		verify();
	}
}
?>