<?php
class MajorResearchModel extends Model {
	protected $_validate = array(
		array('gender', 'require', '请选择您的性别', 1),
		array('major', 'require', '请填写您的本科专业', 1),
		array('highest_edu', 'require', '请填写最高学历', 1),
		
		array('work_year', 'require', '请填写工作年限', 1),
		array('work_year', 'verifyWorkYear', '工作年限填写有误', 1, 'function'),
		
		array('job', 'require', '请填写您的职业', 1),
		array('school_help', 'require', '您遗漏了第1个调查问题', 1), //1
		array('info_source', 'require', '您遗漏了第2个调查问题', 1), //2
		array('understand_level', 'require', '您遗漏了第3个调查问题', 1),//3
		array('major_imagine_diff', 'require', '您遗漏了第4个调查问题', 1), //4
		array('job_major_match', 'require', '您遗漏了第5个调查问题', 1), //5
		array('major_important', 'require', '您遗漏了第6个调查问题', 1), //6
		array('choose_current_major', 'require', '您遗漏了第7个调查问题', 1), //7
	);
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
	
	private function verifyWorkYear($workYear) {		
		if (is_int($workYear)) {
			if ($workYear >= 0 && $workYear <= 60) {
				return true;
			}
		}	
		return false;
	}
}
?>