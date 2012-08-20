<?php
class ContactUsModel extends Model {
	protected $_validate = array(
		array('contact_name', 'require', '姓名不能为空', 1),
		array('email', 'email', '邮箱输入不正确', 1),
		array('content', 'require', '留言不能为空', 1),
	);
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>