<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		if(isObsoleteIE()) {
			$this->error("浏览器不兼容，请选用Chrome，FireFox，Safari或IE9。<br>若您已使用IE9，请关闭兼容模式。");
		} else {
			redirect(__APP__.'/Exam/manage');
		}
    }
}