<?php
/**
 * 移动端新鲜事控制器
 * 用于与PhoneGap的客户端连接
 * @author wjl
 * 2014.03.21
 */

class HomeAction extends Action {

	public function getNews() {
		$usernumber = session('usernumber');
		if ($usernumber) {
			$data['success'] = 1;
			$data['news'] = getNewsByUsernumber($usernumber);
			$this->ajaxReturn($data, 'json');
		}
		else {
			$data['success'] = 0;
			$data['error'] = C('MB_ERR_UNLOGIN');
			$this->ajaxReturn($data, 'json');
		}
	}

	public function getHomeworklist() {
		if (checkLogin()) {
			$cno = I('cno');
			$data['success'] = 1;
			$data['data'] = getHomeworklistByCno($cno);
			$this->ajaxReturn($data, 'json');
		}
	}

	public function getTeacherInfo() {
		if (checkLogin()) {
			$cno = I('cno');
			$data['success'] = 1;
			$data['data'] = getTeacherInfoByCno($cno);
			$this->ajaxReturn($data, 'json');
		}
	}

	public function getCoursefilelist() {
		if (checkLogin()) {
			$cno = I('cno');
			$data['success'] = 1;
			$data['data'] = getCoursefilelistByCno($cno);
			$this->ajaxReturn($data, 'json');
		}
	}

	public function getCourselist() {
		if (checkLogin()) {
			$sno = session('usernumber');
			$data['success'] = 1;
			$data['cno'] = $cno;
			$data['data'] = getCourselistBySno($sno);
			$this->ajaxReturn($data, 'json');
		}
	}
}


?>