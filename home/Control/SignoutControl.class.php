<?php




		// 退出登录控制器
	class SignoutControl{
		// 实现退出登录的方法
		function signout(){
			session_start();
	   		var_dump($_SESSION);
			//退出登录操作
			// //将卡片设置过期   islogin  username  sex
			// setcookie('islogin',null,time()-1,'/');
			// setcookie('username',null,time()-1,'/');
			// setcookie('sex',null,time()-1,'/');

			// //跳转到登录页面
			// header('location:login.html');
			//通过函数自动获取存储sessionid的名称
			echo session_name();
			// 退出操作
			//1.使客户端COOKIE过期，让SESSIONID失效
			setcookie(session_name(),'',time()-1,'/');
			//2.清除当前页面SESSION数组中的值
			unset($_SESSION);
			//3.摧毁服务器的session文件
			session_destroy();

			header('location:./index.php');
		}
	}