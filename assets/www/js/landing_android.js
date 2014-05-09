// 登陆按钮
$(document).ready(function() {			
	$("#btn-login").click(function () {
		console.log("login clicked");
		var usernumber = $('#usernumber');
		var password = $('#password');
		var data = {usernumber:usernumber.val(), password:password.val()};
		$.post(APP_PATH + 'Login/login', data, loginCallback, 'json');
	});
});

// 登陆成功的回调函数
function loginCallback(data) {
	console.log("login succeed!");
	$("#section3").text(data.success);
	// 本地存储
	if (data.success) {
		window.localStorage.setItem('usernumber', $('#usernumber').val());
		window.localStorage.setItem('password', $('#password').val());
		window.localStorage.setItem('usertype', data.type);
		location.href="news.html";
	}
}
