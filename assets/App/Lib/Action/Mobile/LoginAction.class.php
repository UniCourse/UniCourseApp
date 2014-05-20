<?php
/**
 * 移动端登录验证控制器
 * 用于与PhoneGap的客户端连接
 * @author wjl
 * 2014.03.21
 */

class LoginAction extends Action {

	/**
	* 用于处理登录信息
	* @param usernumber	in port
	* @param password 	in post
	* @return success 	in ajax 	1 - success or 0 - fail
	* @return info 		in ajax 	1 - teacher or 0 
	*/
	public function login()
	{
		// 获得用户名 密码
		$usernumber = I('usernumber');
		$password = I('password','','md5');
		$len_user = strlen($usernumber);

		// 如果是学生
		if ($len_user == 10) {
			if (studentLogin($usernumber, $password)) {
				session_start();
				$_SESSION['type'] = C('MB_STUDENT'); // 表示学生
				$_SESSION['usernumber'] = $usernumber;
				// 返回数据
				$data['success'] = 1;
				$data['type'] = C('MB_STUDENT'); // 表示学生
				$data['session'] = session_id();
				$this->ajaxReturn($data,'json');
			}
			else {
				// 登录失败
				$data['success'] = 2;
				$this->ajaxReturn($data,'json');
			}
		}
		// 如果是老师
		else if ($len_user == 8) {
			if (teacherLogin($usernumber, $password)) {
				session_start();
				$_SESSION['type'] = C('MB_TEACHER'); // 表示老师
				$_SESSION['usernumber'] = $usernumber;
				// 返回数据
				$data['success'] = 1;
				$data['type'] = C('MB_TEACHER'); // 表示老师
				$data['session'] = session_id();
				$this->ajaxReturn($data,'json');
			}
			else {
				// 登录失败
				$data['success'] = 3;
				$this->ajaxReturn($data,'json');
			}
		}
		else {
			$data['success'] = 0;
			$this->ajaxReturn($data,'json');
		}
	}

	/**
	* 登出，清空session
	*/
	public function logout()
	{
		session_unset();
		session_destroy();
	}
}
?>
