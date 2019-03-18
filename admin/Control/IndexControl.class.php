<?php
	class IndexControl{
		//默认显示后台登录页面
		function show(){
			include './View/login.html';
		}
		function yanzhen(){
			
				try {
						$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
						$pdo= new PDO($dsn,DB_USER,DB_PWD);
						// 设置报错模式（有错误，抛出错误到catch中）
						// $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						$pdo->exec('SET NAMES utf8');
						// 准备预处理对象
						$sql='SELECT * FROM user WHERE username=? AND state=?';
						// echo $sql;
						$stmt = $pdo->prepare($sql);
						//绑定变量
						$stmt->bindParam(1,$name,PDO::PARAM_STR);
						$stmt->bindParam(2,$state,PDO::PARAM_INT);
						// 为变量赋值
						$name=$_POST['username'];
						$state=3;
						// var_dump($name);
						//发送
						$stmt->execute();
						$a=$stmt->rowCount();
						// var_dump($_POST);
						 // var_dump($a);exit;
						//判断结果
						if($stmt->rowCount()){
							//获取所有查询结果
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							// var_dump($result);exit;
							foreach($result as $v){
								 // var_dump($_POST);
								// var_dump($v);exit;
								if ($v['username'] == $_POST['username'] && $v['pwd'] == md5($_POST['pwd'])) {
									// var_dump($_SESSION);
									echo '<script>alert("登录成功");location="./index.php?m=index&a=sy&name='.$_POST['username'].'"</script>';
								}else{
									echo '<script>alert("密码错误请重新输入");location="./index.php?m=index&a=show"</script>';
								}
							}
						}else{
							echo '<script>alert("用户名错误请重新输入");location="./index.php?m=index&a=show"</script>';
						}
					}catch(PDOException $e){
					$errorStr = $e->getMessage();
					//将错误写入到文件中保存
					file_put_contents('./include/error/error.log',$errorStr);
					//echo $errorStr;
				}
		}
		function sy(){
			
			// 显示后台首页
			include './View/index.html';
		}
		function out(){
			// 到后台登录界面
			header('location:index.php');
		}
	}