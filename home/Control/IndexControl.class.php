<?php

	class IndexControl{
		
		function index(){
			session_start();
			// echo session_id();
			$id=isset($_GET['id'])?$_GET['id']:'';
			// var_dump($_SESSION['user']['username']);
			// var_dump($_SESSION);
			//var_dump($_COOKIE);
			//1.需要判断是否登录 如果没有登录则无权看本页面
			//var_dump($_POST);
			//2.需要使用会话  COOKIE
			// if(isset($_SESSION['user']['islogin']) && $_SESSION['user']['islogin'] == true){
				
			// }else{
			// 	//没拿 没权利访问
			// 	echo '<meta http-equiv="refresh" content="3;url=./index.php" />';
			// }
			//链接数据库 查询分类表中的数据
			try{
				//链接数据库
				$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
				$pdo  = new PDO($dsn,DB_USER,DB_PWD);
				//设置报错模式（有错误 抛出错误到catch中）/
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$pdo->exec('SET NAMES '.CHARSET);
				$sql = "SELECT * FROM ".DB_PREFIX."type ORDER BY id ASC";
				//echo $sql;
				$stmt = $pdo->prepare($sql);
				//发送
				$stmt->execute();
				//获取数据
				$types = $stmt->fetchAll(PDO::FETCH_ASSOC);
				// var_dump($types);
				

			}catch(PDOException $e){
				$errorStr = $e->getMessage();
				//将错误写入到文件中保存
				file_put_contents('./include/error/error.log',$errorStr);
				//echo $errorStr;
			}
			// 显示网站首页
			include './View/index.html';
		}
		
	}