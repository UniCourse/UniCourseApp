<?php
/**
 * 移动端公共接口控制器
 * 用于与PhoneGap的客户端连接
 * 暂时只考虑学生
 * @author wjl
 * 2014.04.17
 */

class CommonAction extends Action {

	/**
	* 对应手机端的 file_download页面
	* 用于根据 news 表中的 n_contentid 来下载文件
	*/
	public function downloadByContentid() {
		// 先判断是否已经登录
		$usernumber = session('usernumber');
		if ($usernumber) {		
			$temp = M()->query("select fname, furl from coursefile where fno=".I('contentid'));
			$fname = $temp[0]['fname'];
			$furl = $temp[0]['furl'];
			if(fileDownloadByContentid($fname, $furl)){
			}else{
				//$this->error("文件不存在");
				$data['fname'] = $fname;
				$data['furl'] = $furl;
				$this->ajaxReturn($data, 'json');
			}
		}
		else {
			$data['success'] = 0;
			$data['error'] = C('MB_ERR_UNLOGIN');
			$this->ajaxReturn($data, 'json');
		}
	}

}


?>