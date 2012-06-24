<?php
class UserModel extends Model {
	protected $_validate = array(
		array('user_name', 'require', '姓名 不能为空', 1),
		array('password', 'require', '密码 不能为空', 1),
		array('email', '', '该邮箱已被注册', 1, 'unique'),
		array('email', 'email', '请输入有效的邮箱', 1),
	);
	
	protected $_auto = array(
		array('create_at', 'date("Y-m-d H:i:s")', 1, 'function'),
	);
}
?>