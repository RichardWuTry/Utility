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
			
			$very_useful = 0; $some_useful = 0; $little_useful = 0; $useless = 0;
			$very_useful_name = '很有作用'; $some_useful_name = '有些作用'; $little_useful_name = '比没有强'; $useless_name = '完全没用/无指导';
			
			$parent_advice = 0; $student_discuss = 0; $school_guide = 0; $self_research = 0;
			$parent_advice_name = '父母的意见'; $student_discuss_name = '同学之间讨论'; $school_guide_name = '学校组织的指导'; $self_research_name = '自己查资料研究';
			
			$understand = 0; $some_understand = 0; $little_understand = 0; $not_understand = 0;
			$understand_name = '很清楚这个专业'; $some_understand_name = '较为了解'; $little_understand_name = '不太了解'; $not_understand_name = '不了解';
			
			$same = 0; $some_diff = 0; $very_diff = 0; $diff = 0;
			$same_name = '基本一致'; $some_diff_name = '有些不同'; $very_diff_name = '很不一样'; $diff_name = '完全不一样';
			
			$match = 0; $some_match = 0; $little_match = 0; $unmatch = 0;
			$match_name = '非常匹配'; $some_match_name = '较为匹配'; $little_match_name = '很少匹配'; $unmatch_name = '完全没关系';
			
			$important = 0; $some_important = 0; $little_important = 0; $unimportant = 0;
			$important_name = '非常重要'; $some_important_name = '较为重要'; $little_important_name = '不太重要'; $unimportant_name = '完全不重要';
			
			$current_major = 0; $other_major = 0;
			$current_major_name = '是'; $other_major_name = '否';
			
			$not_like = 0; $suit_other = 0; $bad_market = 0; $other_reason = 0;
			$not_like_name = '不喜欢原专业'; $suit_other_name = '觉得更适合另一专业'; $bad_market_name = '原专业市场不好'; $other_reason_name = '其他原因';
			
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
				
				if ($item['school_help'] == $very_useful_name) {
					$very_useful++;
				} else if ($item['school_help'] == $some_useful_name) {
					$some_useful++;
				} else if ($item['school_help'] == $little_useful_name) {
					$little_useful++;
				} else {
					$useless++;
				}
				
				if ($item['info_source'] == $parent_advice_name) {
					$parent_advice++;
				} else if ($item['info_source'] == $student_discuss_name) {
					$student_discuss++;
				} else if ($item['info_source'] == $school_guide_name) {
					$school_guide++;
				} else {
					$self_research++;
				}
				
				if ($item['understand_level'] == $understand_name) {
					$understand++;
				} else if ($item['understand_level'] == $some_understand_name) {
					$some_understand++;
				} else if ($item['understand_level'] == $little_understand_name) {
					$little_understand++;
				} else {
					$not_understand++;
				}
				
				if ($item['major_imagine_diff'] == $same_name) {
					$same++;
				} else if ($item['major_imagine_diff'] == $some_diff_name) {
					$some_diff++;
				} else if ($item['major_imagine_diff'] == $very_diff_name) {
					$very_diff++;
				} else {
					$diff++;
				}
				
				if ($item['job_major_match'] == $match_name) {
					$match++;
				} else if ($item['job_major_match'] == $some_match_name) {
					$some_match++;
				} else if ($item['job_major_match'] == $little_match_name) {
					$little_match++;
				} else {
					$unmatch++;
				}
				
				if ($item['major_important'] == $important_name) {
					$important++;
				} else if ($item['major_important'] == $some_important_name) {
					$some_important++;
				} else if ($item['major_important'] == $little_important_name) {
					$little_important++;
				} else {
					$unimportant++;
				}
				
				if ($item['choose_current_major'] == $current_major_name) {
					$current_major++;
				} else {
					$other_major++;
				}
				
				if ($item['change_reason'] == $not_like_name) {
					$not_like++;
				} else if ($item['change_reason'] == $suit_other_name) {
					$suit_other++;
				} else if ($item['change_reason'] == $bad_market_name) {
					$bad_market++;
				} else {
					$other_reason++;
				}
			}
			
			$gender = "[['男', $male], ['女', $female]]";
			$highest_edu = "[['本科', $bachelor], ['硕士', $master], ['博士', $doctor]]";
			$work_year = "[$workYear0_5, $workYear6_10, $workYear11_15, $workYear16_20, $workYear21_25, $workYear26_]";
			$work_year_ticks = "['0~5', '6~10', '11~15', '16~20', '21~25', '26~']";
			$school_help = "[['$very_useful_name', $very_useful], ['$some_useful_name', $some_useful], 
							['$little_useful_name', $little_useful], ['$useless_name', $useless]]";
			$info_source = "[['$parent_advice_name', $parent_advice], ['$student_discuss_name', $student_discuss],
							['$school_guide_name', $school_guide], ['$self_research_name', $self_research]]";
			$understand_level = "[['$understand_name', $understand], ['$some_understand_name', $some_understand], 
								['$little_understand_name', $little_understand], ['$not_understand_name', $not_understand]]";
			$major_imagine_diff = "[['$same_name', $same],['$some_diff_name', $some_diff],
									['$very_diff_name', $very_diff],['$diff_name', $diff]]";
			$job_major_match = "[['$match_name', $match], ['$some_match_name', $some_match],
								['$little_match_name', $little_match], ['$unmatch_name', $unmatch]]";
			$major_important = "[['$important_name', $important], ['$some_important_name', $some_important],
								['$little_important_name', $little_important], ['$unimportant_name', $unimportant]]";
			$choose_current_major = "[['$current_major_name', $current_major], ['$other_major_name', $other_major]]";
			$change_reason = "[['$not_like_name', $not_like], ['$suit_other_name', $suit_other], 
							['$bad_market_name', $bad_market], ['$other_reason_name', $other_reason]]";
			
			$this->assign('count', count($result)); //总人数
			$this->assign('gender', $gender); //性别
			$this->assign('highest_edu', $highest_edu); //最高学历
			$this->assign('work_year', $work_year); $this->assign('work_year_ticks', $work_year_ticks);//工作年限
			$this->assign('school_help', $school_help); //学校帮助
			$this->assign('info_source', $info_source); //信息来源
			$this->assign('understand_level', $understand_level); //了解程度
			$this->assign('major_imagine_diff', $major_imagine_diff); //想象差异
			$this->assign('job_major_match', $job_major_match); //工作匹配
			$this->assign('major_important', $major_important); //专业重要
			$this->assign('choose_current_major', $choose_current_major); //选现专业
			$this->assign('change_reason', $change_reason); //换专业原因
			
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