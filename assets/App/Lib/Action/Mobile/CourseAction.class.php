<?php
/**
 * 移动端课程控制器
 * 用于与PhoneGap的客户端连接
 * 暂时只考虑学生
 * @author wjl
 * 2014.03.21
 */

class CourseAction extends Action {

	public function getCourselist() {
		$usernumber = session('usernumber');
		if ($usernumber) {
			$data['success'] = 1;
			$data['courses'] = getCourselistByUsernumber($usernumber);
			$this->ajaxReturn($data, 'json');
		}
		else {
			$data['success'] = 0;
			$data['error'] = C('MB_ERR_UNLOGIN');
			$this->ajaxReturn($data, 'json');
		}
		//$this->ajaxReturn($data,'json');
	}

}


?>