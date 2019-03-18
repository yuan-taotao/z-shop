<?php
	// 登录控制器
	class SignControl{
		function show(){

			// 显示登录界面
			include './View/dlindex.html';
		}
		function select(){
					//手动开启session
					session_start();
					// 链接数据库
				try{
					$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
					$pdo= new PDO($dsn,DB_USER,DB_PWD);
					// 设置报错模式（有错误，抛出错误到catch中）
					// $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$pdo->exec('SET NAMES utf8');
					// 准备预处理对象
					$sql='SELECT * FROM user WHERE username=?';
					// echo $sql;
					$stmt = $pdo->prepare($sql);
					//绑定变量
					$stmt->bindParam(1,$name,PDO::PARAM_STR);
					// 位变量赋值
					$name=$_POST['username'];
					//发送
					$stmt->execute();
					//判断结果
					if($stmt->rowCount()){
						//获取所有查询结果
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						// var_dump($result);exit;
						foreach($result as $v){
							// var_dump($_POST);
							// var_dump($v);
							if ($v['username'] == $_POST['username'] && $v['pwd'] == md5($_POST['pwd'])) {
								// 回话
								$_SESSION['user']['islogin'] = true;
								$_SESSION['user']['username'] = $_POST['username'];
								$_SESSION['user']['id'] = $v['id'];
								// var_dump($_SESSION);
								echo '<script>alert("登录成功");location="./index.php?id='.$v['id'].'"</script>';
							}else{
								echo '<script>alert("密码错误请重新输入");location="./index.php?m=sign&a=show"</script>';
							}
						}
					}else{
						echo '<script>alert("用户名错误请重新输入");location="./index.php?m=sign&a=show"</script>';
					}
				}catch(PDOException $e){
					$errorStr = $e->getMessage();
					//将错误写入到文件中保存
					file_put_contents('./include/error/error.log',$errorStr);
					//echo $errorStr;
				}
		}
	}