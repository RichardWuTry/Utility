<?php
class MajorAction extends Action {
    public function research(){
		$MajorResearch = M('MajorResearch');
		if ($tagBtnRecords = $MajorResearch
						->field("major, job, choose_major")
						->select()) {
			$origMajorBtnArray = $this->genTagArray($tagBtnRecords, 'major');
			$jobBtnArray = $this->genTagArray($tagBtnRecords, 'job');
			$chooseMajorBtnArray = $this->genTagArray($tagBtnRecords, 'choose_major');
			
			$this->assign('origMajorBtnArray', $origMajorBtnArray);
			$this->assign('jobBtnArray', $jobBtnArray);
			$this->assign('chooseMajorBtnArray', $chooseMajorBtnArray);
		}		
		
		$this->display();
    }
	
	private function genTagArray($records, $colName) {
		$tagBtnArray = array();
		foreach ($records as $r) {
			foreach ($r as $key => $value) {
				if ($key == $colName && !in_array($value, $tagBtnArray)) {
					array_push($tagBtnArray, $value);
				}
			}
		}
		return $tagBtnArray;
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
			redirect(__URL__.'/research');
		}
	}
	
	public function researchResult(){
		$MajorResearch = M('MajorResearch');
		if ($result = $MajorResearch->select()) {
			$workYear0_5 = 0; $workYear6_10 = 0; $workYear11_15 = 0; $workYear16_20 = 0; $workYear21_25 = 0; $workYear26_ = 0;
			
			$resultArray = array('gender' => array('男' => 0,
													'女' => 0),
								'highest_edu' => array('专科' => 0,
														'本科' => 0,
														'硕士' => 0,
														'博士' => 0),
								'school_help' => array('很有作用' => 0,
														'有些作用' => 0,
														'比没有强' => 0,
														'完全没用' => 0),
								'info_source' => array('父母的意见' => 0,
														'同学之间讨论' => 0,
														'学校组织的指导' => 0,
														'自己查资料研究' => 0),
								'understand_level' => array('很清楚这个专业' => 0,
															'较为了解' => 0,
															'不太了解' => 0,
															'不了解' => 0),
								'major_imagine_diff' => array('基本一致' => 0,
															'有些不同' => 0,
															'很不一样' => 0,
															'完全不一样' => 0),
								'job_major_match' => array('非常匹配' => 0,
															'较为匹配' => 0,
															'很少匹配' => 0,
															'完全没关系' => 0),
								'major_important' => array('非常重要' => 0,
															'较为重要' => 0,
															'不太重要' => 0,
															'完全不重要' => 0),
								'choose_current_major' => array('是' => 0,
																'否' => 0),
								'change_reason'=>array('不喜欢原专业' => 0,
														'觉得更适合另一专业' => 0,
														'原专业市场不好' => 0,
														'其他原因' => 0),								
								);
			
			$origMajorFreqArray = array();
			$jobFreqArray = array();
			$currMajorFreqArray = array();
			
			foreach($result as $record) {			
				if ($record['work_year'] >= 0 && $record['work_year'] <= 5) {
					$workYear0_5++;
				} else if ($record['work_year'] >= 6 && $record['work_year'] <= 10) {
					$workYear6_10++;
				} else if ($record['work_year'] >= 11 && $record['work_year'] <= 15) {
					$workYear11_15++;
				} else if ($record['work_year'] >= 16 && $record['work_year'] <= 20) {
					$workYear16_20++;
				} else if ($record['work_year'] >= 21 && $record['work_year'] <= 25) {
					$workYear21_25++;
				} else {
					$workYear26_++;
				}				
				
				$this->calTagFreq($origMajorFreqArray, $record['major']);
				$this->calTagFreq($jobFreqArray, $record['job']);
				$this->calTagFreq($currMajorFreqArray, $record['choose_major']);
				
				$this->calResultArray($resultArray, $record);
			}
			
			$work_year = "[$workYear0_5, $workYear6_10, $workYear11_15, $workYear16_20, $workYear21_25, $workYear26_]";
			$work_year_ticks = "['0~5年', '6~10年', '11~15年', '16~20年', '21~25年', '26年以上']";
			
			$origMajorCloudHtml = $this->genTagCloud($origMajorFreqArray);
			$jobCloudHtml = $this->genTagCloud($jobFreqArray);
			$currMajorCloudHtml = $this->genTagCloud($currMajorFreqArray);
			
			$this->assign('count', count($result)); //总人数
			$this->assign('work_year', $work_year); $this->assign('work_year_ticks', $work_year_ticks);//工作年限
			$this->assignPlotData($resultArray);
			
			$this->assign('origMajorCloudHtml', $origMajorCloudHtml);
			$this->assign('jobCloudHtml', $jobCloudHtml);
			$this->assign('currMajorCloudHtml', $currMajorCloudHtml);
			
			$this->display();
		} else {
			redirect(__URL__.'/research');
		}
		
	}
	
	private function genTagCloud($tagFreqArray) {
		$colorPool = array('Green', 'Blue', 'Salmon', 'Orange', 'Red');
		$tagCloudHtml = "";
		foreach($tagFreqArray as $key => $value) {
			$tagColor = $colorPool[rand(0, 4)];
			$tagFontSize = log10($value) <= 1.0 ? 1.0 : log10($value);
			$tagCloudHtml .= "<span style=\"color:{$tagColor}; font-size:{$tagFontSize}em; padding:5px; font-weight:bold;\">$key</span>";
		}
		return $tagCloudHtml;
	}
	
	private function calTagFreq(&$tagFreqArray, $tagName) {
		if (array_key_exists($tagName, $tagFreqArray)) {
			$tagFreqArray[$tagName]++;
		} else {
			$tagFreqArray[$tagName] = 1;
		}
	}
	
	private function assignPlotData($resultArray) {
		foreach($resultArray as $colName => $itemArray) {
			$plotDataStr = $this->genPlotData($itemArray);
			$this->assign("$colName", $plotDataStr);
		}
	}
	
	private function calResultArray(&$resultArray, $record) {
		foreach($resultArray as $colName => &$itemArray) {
			if (array_key_exists($colName, $record)) {
				if (array_key_exists($record[$colName], $itemArray)) {
					$itemArray[$record[$colName]]++;
				}
			}
		}
	}
	
	private function genPlotData($itemArray) {
		$resultStr = "[";
		
		foreach($itemArray as $key => $value) {
			$resultStr = $resultStr . "['" . $key . "'," . $value . "],";
		}
		$resultStr .= "]";
		return $resultStr;
	}
	
	public function showVerifyImage() {
		verify();
	}
}
?>