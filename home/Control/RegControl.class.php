<?php

		// 注册控制器
		class RegControl{
			// 显示注册页面的方法
			function show(){

				include './View/zcindex.html';
			}
			// 添加用户的方法
			function add(){
				
				// var_dump($_POST);
				$n='/^[A-Za-z]{6,13}$/';
				$p='/^[a-zA-Z0-9]{6,16}$/';
				if (preg_match($n,$_POST['username'])!=1) {
					echo '<script>alert("用户名不合法");location="./index.php?m=reg&a=show"</script>';
				}
				if (preg_match($p,$_POST['pwd'])!=1) {
					echo '<script>alert("密码不合法");location="./index.php?m=reg&a=show"</script>';
				}
				if ($_POST['pwd']!=$_POST['qrpwd']) {
					echo '<script>alert("两次密码不正确");location="./index.php?m=reg&a=show"</script>';
				}
				try {
					// 链接数据库
					$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
					$pdo= new PDO($dsn,DB_USER,DB_PWD);
					// 设置报错模式（有错误，抛出错误到catch中）
					// $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$pdo->exec('SET NAMES utf8');


					// 先判断用户注册的用户名是否存在
					// 准备预处理对象
					$sql1="SELECT * FROM user WHERE username=?";
					$stmt1=$pdo->prepare($sql1);
					// 绑定变量值
					$stmt1->bindparam(1,$u,PDO::PARAM_STR);
					// 为变量赋值
					$u=$_POST['username'];
					//发送
					$stmt1->execute();
					//判断结果
					// $s=$stmt1->rowCount();
					// var_dump($s);exit;
					if($stmt1->rowCount()){
						// 用户名存在跳回注册页面重新注册
						echo '<script>alert("用户名已存在");location="./index.php?m=reg&a=show"</script>';
					}else{
						// 用户名不存在执行用户添加
						// 准备预处理对象
						$sql='INSERT INTO user(`username`,`pwd`,`addtime`) VALUES(?,?,?)';
						// echo $sql;
						$stmt = $pdo->prepare($sql);
						//绑定变量
						$stmt->bindParam(1,$name,PDO::PARAM_STR);
						$stmt->bindParam(2,$pwd,PDO::PARAM_STR);
						$stmt->bindParam(3,$time,PDO::PARAM_INT);
						// 位变量赋值
						$name=$_POST['username'];
						$pwd=md5($_POST['pwd']);
						$time=time();
						// var_dump($sql);exit;
						//发送
						$stmt->execute();
						//判断结果
						if($stmt->rowCount()){
							echo '<script>alert("注册成功");location="./index.php?m=sign&a=show"</script>';
						}else{
							echo '<script>alert("注册失败");location="./index.php?m=reg&a=show"</script>';
						}
					}
						
				}catch(PDOException $e){
					$errorStr = $e->getMessage();
					//将错误写入到文件中保存
					// file_put_contents('./include/error/error.log',$errorStr);
					//echo $errorStr;
				}
			}
		}