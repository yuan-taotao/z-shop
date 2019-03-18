<?php


		// 商品列表控制器
		class GoodsControl{
			// 遍历商品的方法
			function select(){
				session_start();
				// echo session_id();
				// if(!isset($_SESSION['user']['islogin']) && !$_SESSION['user']['islogin'] == true){
				// 	//没拿 没权利访问
				// 	echo '<meta http-equiv="refresh" content="3;url=./index.php" />';
				// }
				// 链接数据库 查询商品表中的数据
				try {
					// 链接数据库
					$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
					$pdo= new PDO($dsn,DB_USER,DB_PWD);
					// 设置报错模式（有错误，抛出错误到catch中）
					$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$pdo->exec('SET NAMES utf8');
					// 准备预处理对象
					$sql='SELECT * FROM goods WHERE typeid=65 ORDER BY id ASC LIMIT 3';
					// echo $sql;
					$stmt = $pdo->prepare($sql);
					//发送
					$stmt->execute();
					//获取数据
					$goods = $stmt->fetchAll(PDO::FETCH_ASSOC);
					// var_dump($goods);
				}catch(PDOException $e){
					$errorStr = $e->getMessage();
					//将错误写入到文件中保存
					file_put_contents('./include/error/error.log',$errorStr);
					//echo $errorStr;
				}
				// 显示商品列表页
				include './View/splb.html';
			}
			// 显示商品详情页的方法
			function details(){
				// var_dump($_GET);
				session_start();
				// echo session_id();
				// echo "<br>";
				// if(!isset($_SESSION['user']['islogin']) && !$_SESSION['user']['islogin'] == true){
				// 	//没拿 没权利访问
				// 	echo '<meta http-equiv="refresh" content="3;url=./index.php" />';
				// }
			
				$m=new Model('goods');
				$res=$m->where('id='.$_GET['id'].'')->select();
				// var_dump($res[0]);
				// 显示商品详情页面
				include './View/spxq.html';
			}
		}