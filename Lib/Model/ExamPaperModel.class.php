<?php
class ExamPaperModel extends Model {
	protected $_validate = array(
		array('paper_name', 'require', '考卷名称 不能为空', 1),
		array('total_score', '1, 1440', '满分 输入无效', 1, 'between'),
		array('total_mins', '1, 1440', '时间 输入无效', 1, 'between'),		
		array('paper_desc', 'require', '考卷说明 不能为空', 1),
	);	
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>