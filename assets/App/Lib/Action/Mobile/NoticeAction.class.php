<?php
/**
 * 移动端公告控制器
 * 用于与PhoneGap的客户端连接
 * 暂时只考虑学生
 * @author wjl
 * 2014.04.27
 */

class NoticeAction extends Action {

	/**
	* 课程页面用于获取公告列表的ajax返回接口
	为什么要用 I('get.cno')才能获取get参数
	angular初始化需要改成  var app=angular.module('MyApp',[],http_patch);
	*/
	public function getNoticelist() {
/*		$usernumber = session('usernumber');
		$cno = I('cno');
		if ($usernumber) {
			$data['success'] = 1;
			$data['cno'] = $cno;
			$data['data'] = getNoticesByCno($cno);
			$this->ajaxReturn($data, 'json');
		}
		else {
			$data['success'] = 0;
			$data['error'] = C('MB_ERR_UNLOGIN');
			$this->ajaxReturn($data, 'json');
		}
*/	
		if (checkLogin()) {
			$cno = I('cno');
			$data['success'] = 1;
			$data['data'] = getNoticesByCno($cno);
			$this->ajaxReturn($data, 'json');
		}
	}

	

}


?>