
window.APP_URL = "";
var app = angular.module('UniCourse', [], function() {
    console.log("Welcome to UniCourse!");
});
app.controller('FeedCtrl', function($scope, $http) {
/*$scope.feedlist的样子就是服务器返回的东西的一部分，其中\u开关的utf-8编码是我直接复制下来的，实际上就是汉字，我懒得换了，在控制台里可以看到feedlist的结构，很简单
    console.log($scope.feedlist);*/

    function fetchData() {
        $http({
            url: APP_PATH + 'Home/getNews',
            method: 'POST'
        }).success(function(data) {
            //console.log(data);
            if (data.success == 1) {
                $scope.feedlist = data.news
                renderData()
            }
        });
    }

    function renderData() {
        for (var i = 0; i < $scope.feedlist.length; i++) {
            switch ($scope.feedlist[i].n_type) {
            case '1':
                $scope.feedlist[i].eventstr = "提了新问题";
                break;
            case '2':
                $scope.feedlist[i].eventstr = "发布了新公告";
                break;
            case '3':
                $scope.feedlist[i].eventstr = "布置了新作业";
				break;
            case '4':
                $scope.feedlist[i].eventstr = "上传了课件";
                break;
            default:
                $scope.feedlist[i].eventstr = "";
            }
        }
    }
    fetchData();
    $scope.delFeed = function(feed) {
        for (var i in $scope.feedlist) {
            if (feed == $scope.feedlist[i]) {
                $scope.feedlist.splice(i, 1);
                return;
            }
        }
    }
    // 点击了课程名称后 跳转到对应的课程页面
    $scope.goto_course = function(feed) {
    	console.log("goto course " + feed.n_cno);
    }
    // 点击了具体内容后，分类跳转
    $scope.goto_content = function(feed) {
    	console.log("goto content " + feed.n_contentid);
    	switch (feed.n_type) {
            case '1':
                //"提了新问题";
                break;
            case '2':
                //"发布了新公告";
                break;
            case '3':
                //"布置了新作业";
				break;
            case '4':
                //"上传了课件";
				window.localStorage.setItem('download_contentid', feed.n_contentid);
				window.localStorage.setItem('download_filename', feed.n_content);
				location.href="file_download.html";
                break;
            //default:
                //;
        }
    }
    $scope.zai = "在";
});
