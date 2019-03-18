<?php
	class CartControl{
			// 添加商品到购物车
			function add(){
			session_start();
			// echo session_id();
			if(isset($_SESSION['user']['islogin']) && $_SESSION['user']['islogin'] == true){
				//将当前商品添加到session中(session就是我们的购物车)
						if(isset($_GET['id'])){
								$m=new Model('goods');
								$row=$m->where('id='.$_GET['id'])->select();
								foreach ($row as $key => $val) {
							}
								//修改购买数量
								$val['num'] = 1;
								//var_dump($_SESSION);
								if(isset($_SESSION['cart'][$val['id']])){
									//修改数量
									$_SESSION['cart'][$val['id']]['num'] += 1;
								}else{
									//将当前得到的商品数据放入到session中保存
									$_SESSION['cart'][$val['id']] = $val;
							}
			
						}
								// 显示购物车页面
								include './View/ygwc.html';
					}else{
						// 没拿 没权利访问
						echo '<meta http-equiv="refresh" content="0;url=./index.php?m=sign&a=show" />';
				}
			}
			function show(){
				session_start();
				// echo session_id();
				if(isset($_SESSION['user']['islogin']) && $_SESSION['user']['islogin'] == true){
						// 判断购物车里是否有东西；
						if (empty($_SESSION['cart'])) {
							// 购物车为空包含第一个购物车页面
							include './View/gwcindex.html';
						}else{
							// 购物车不为空
							include './View/ygwc.html';
						}
					}else{
						// 没拿 没权利访问
						echo '<meta http-equiv="refresh" content="0;url=./index.php?m=sign&a=show" />';
					}
				}
			//修改购物车
			function  updateCart(){
				session_start();
				if(isset($_GET['id']) && isset($_GET['num'])){
					$_SESSION['cart'][$_GET['id']]['num'] += $_GET['num'];
					//验证最小值
					if($_SESSION['cart'][$_GET['id']]['num'] <= 1){
						$_SESSION['cart'][$_GET['id']]['num'] = 1;
					}
				}
				header('location:./index.php?m=cart&a=show');
			}
			//删除购车
			function  delCart(){
				session_start();
				if(isset($_GET['id'])){
					//删除商品
					unset($_SESSION['cart'][$_GET['id']]);
				}else{
					//清空购物车
					$_SESSION['cart'] = array();
				}
				echo '<script>alert("删除成功");location="./index.php?m=cart&a=show"</script>';
			}
		}