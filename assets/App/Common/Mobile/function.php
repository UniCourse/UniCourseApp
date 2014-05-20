<?php
/**
* Mobile模块的公共函数库
*
* @author wang jilei
* @version 0.1
*/


	/**
	* 判断账号密码是否是学生 
	* @return boolean
	*/
	function studentLogin($usernumber, $password) {
		// 从student表中查询
		$stuModel = new Model();
		$student = $stuModel->query("select spsw from student where sno='". $usernumber."'");
		// 如果是学生
		if ($student) {
			// 学生 登陆成功
			if ($student[0]['spsw']==$password) {
				return true;
			}
			// 学生 密码错误
			else {
				return false;
			}
		}
		else {
		// 如果不是学生
			return false;	
		}
	}

	/**
	* 判断账号密码是否是老师 
	* @return boolean
	*/
	function teacherLogin($usernumber, $password) {
		// 从teacher表中查询
		$teaModel = new Model();
		$teacher = $teaModel->query("select tpsw from teacher where tno='" . $usernumber . "'");
		if ($teacher) {
			if ($teacher[0]['tpsw']==$password) {
				// 老师 登陆成功
				return true;
			}
			else {
				// 老师 密码错误
				return false;//$teacher[0]['tpsw'] . "  " . $password;
			}
		}
		else {
			return false;
		}
	}

	/**
	* 学生登录成功后，获取学生的课程列表
	* @return 返回数据库中获得的数组
	*/
	function getCoursesByUsernumber($usernumber) {
		//查询学生选修课程
		$coursemodel = new Model();
		$course = $coursemodel->query("select stu_course.sno, course.cno, course.cname from stu_course, course where stu_course.cno=course.cno and stu_course.sno=".$usernumber);
		return $course;
	}

	/**
	* 根据学号获取全部新鲜事
	* @return 返回数据库中获得的数组
	*/
	function getNewsByUsernumber($usernumber) {
		$newsmodel = new Model();
		$news = $newsmodel->query("select news.n_sname, news.n_cno, news.n_cname, news.n_content, news.n_type, news.n_contentid from stu_course, news where stu_course.cno=news.n_cno and stu_course.sno=".$usernumber);
		return $news;
	}

	/**
	* 根据学号返回课程列表
	* @return 课程列表
	*/
	function getCourselistByUsernumber($usernumber) {
		$model = new Model();
		$courselist = $model->query("select course.cno, course.cname, teacher.tname from stu_course, course, teacher where stu_course.cno=course.cno and course.tno=teacher.tno and stu_course.sno='".$usernumber."'");
		return $courselist;
	}

	/**
	* 根据课程号返回公告列表
	* @return 公告列表
	*/
	function getNoticesByCno($cno) {
		$model = new Model();
		$notices = $model->query("select ntime, ncontent from notice where cno = '" . $cno . "';");
		return $notices;
	}

	function getHomeworklistByCno($cno) {
		$model = new Model();
		$homeworklist = $model->query("select hno, htime, hcontent, htitle, deadline from homework where cno = '" . $cno . "';");
		foreach ($homeworklist as $key => $value) {
			$homeworkfilemodel = new Model();
			$homeworkfile = $homeworkfilemodel->query("select furl from homeworkfile where hno=".$value['hno']);
			$homeworklist[$key]['furl'] = $homeworkfile[0]['furl'];
		}
		return $homeworklist;	
	}

	function getTeacherInfoByCno($cno) {
		$model = new Model();
		$teacherinfo = $model->query("select teacher.tname tname, teacher.email temail, teacher.phone tphone, checkway, intro, cnotes from course, teacher where course.cno = '" . $cno . "' and course.tno = teacher.tno;");
		return $teacherinfo;
	}

	function getCoursefilelistByCno($cno) {
		$model = new Model();
		$coursefilelist = $model->query("select * from coursefile where cno = '" . $cno . "';");
		return $coursefilelist;
	}

	function getCourselistBySno($sno) {
		$model = new Model();
		$courselist = $model->query("select course.cno, course.cname, teacher.tname from course, stu_course, teacher where stu_course.sno = '" . $sno . "' and course.cno = stu_course.cno and course.tno = teacher.tno;");
		return $courselist;
	}

	/**
	 * 文件下载 与 CommonAction.downloadByContentid 对应
	 * @TODO
	*/
	function fileDownloadByContentid($fname, $furl) {
	    //中文转码
	    //$furl=iconv('UTF-8','GBK',$furl);
	    //$fname=iconv('UTF-8','GBK',$fname);
	    if (!file_exists($furl)){
	        header("Content-type: text/html; charset=UTF-8");
	    } else {
	        $file = fopen($furl,"r");
	        
	        Header("Content-type: application/octet-stream");
	        Header("Accept-Ranges: bytes");
	        Header("Accept-Length: ".filesize($furl));
	        Header("Content-Disposition: attachment; filename=\"".$fname."\";");
	        echo fread($file, filesize($furl));
	        fclose($file);
	        return true;
	    }
	    return false;
	}

	/***
	* 检查是否已登录
	*/
	function checkLogin() {
		$usernumber = session('usernumber');
		if ($usernumber) {
			return true;
		}
		else {
			$data['success'] = 0;
			$data['error'] = C('MB_ERR_UNLOGIN');
			$this->ajaxReturn($data, 'json');
			return false;
		}
	}

?>
