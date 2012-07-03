<?php
class AttendHeadModel extends Model {
	protected $_validate = array(
		array('examinee_name', 'require', '姓名 不能为空', 1),
		array('mobile', 'require', '手机 不能为空', 1),
		array('id_card', 'require', '身份证 不能为空', 1),		
	);	
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>