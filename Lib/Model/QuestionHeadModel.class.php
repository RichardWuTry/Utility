<?php
class QuestionHeadModel extends Model {
	protected $_validate = array(
		array('question_name', 'require', '考题 不能为空', 1),
		array('question_type', 'require', '题型 必选', 1),
	);
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>