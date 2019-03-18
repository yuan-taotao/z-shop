<?php


	class OrderControl{
		// 显示订单页面
		function submit(){
			session_start();
			include './View/xx_form.html';
		}
		// 将数据插入订单表
		function insert(){
			session_start();
			// var_dump($_POST);
			// var_dump($_SESSION['user']['username']);
			// var_dump($_SESSION['user']['id']);
			// var_dump($_SESSION['cart']);
			// var_dump($_SESSION['total']);
			foreach ($_SESSION['cart'] as $k => $v) {
				$arr=array();
				$arr['linkman']=$_POST['linkman'];
				$arr['phone']=$_POST['phone'];
				$arr['address']=$_POST['address'];
				$arr['uid']=$_SESSION['user']['id'];
				$arr['addtime']=time();
				$arr['total']=$_SESSION['total'];
				$arr['goodsid']=$v['id'];
				$arr['num']=$v['num'];
				$arr['price']=$v['price'];
				$arr['goodsname']=$v['name'];
				$arr['goodspic']=$v['pic'];
				// var_dump($arr);
				$m=new Model('orders');
				$res=$m->insert($arr);
				// var_dump($res);
				if ($res) {
					// 数据插入成功到订单页面
					echo '<script>alert("支付成功");location="./index.php?m=order&a=order"</script>';
				}else{
					// 数据插入失败返回到提交订单页面
					echo '<script>alert("支付失败");location="./index.php?m=order&a=submit"</script>';
				}
			}
		}
		// 显示订单页面
		function order(){
			session_start();
			
			if(isset($_SESSION['user']['islogin']) && $_SESSION['user']['islogin'] == true){
				// 实例化Model类
				$m=new Model('orders');
				// 只查询当前会员的订单
				$res=$m->where('uid='.$_SESSION['user']['id'].' AND sc=0')->select();
				// var_dump($res);
				// var_dump($_SESSION['user']['id']);
				$arr=array('待发货','确认收货','待评价');
				if ($res) {
					// 包含订单页面
				include './View/wddd.html';
				}else{
				// 包含无订单页面
				include './View/wdd.html';
				}
			}else{
				// 没拿 没权利访问
				echo '<meta http-equiv="refresh" content="0;url=./index.php?m=sign&a=show" />';
			}

		}
		// 显示订单详情页的方法
		function details(){
			//显示订单详情页
			session_start();
			$name=$_SESSION['user']['username'];
			// 实例化对象
			$m=new Model('orders');
			$aa='uid='.$_SESSION['user']['id'].' AND goodsid='.$_GET['id'];
			// var_dump($aa);
			$arr=array('待发货','确认收货','待评价');
			$res=$m->where($aa)->select();
			// var_dump($res);
			foreach ($res as $k => $v) {
			}
			// var_dump($v);
			$time=date('Y-m-d:H-i-s',$v['addtime']);
			include './View/ddxq.html';
		}
		// 删除订单的方法
		function delete(){
			session_start();
			// var_dump($_SESSION['user']['id']);
			// var_dump($_GET);
			// 实例化对象
			$m=new Model('orders');
			$arr=array();
			$arr['sc']=1;
			// var_dump($arr);
			$res=$m->where('uid='.$_SESSION['user']['id'].' AND goodsid='.$_GET['id'])->update($arr);
			// var_dump($res);
			if ($res) {
				header('location:./index.php?m=order&a=order');
			}
		}
		// 确认收货后的状态
		function statu(){
			session_start();
			var_dump($_GET);
			if ($_GET['status']==1) {
				$m=new Model('orders');
				// $a='id='.$_GET['id'].' AND status='.$_GET['status'];
				// var_dump($a); 
				$arr=array();
				$arr['status']=2;
				$res=$m->where('id='.$_GET['id'].' AND status='.$_GET['status'] )->update($arr);
				if ($res) {
					header('location:./index.php?m=order&a=order');
				}else{
					header('location:./index.php?m=order&a=order');
				}
			}else{
				header('location:./index.php?m=order&a=order');
			}
		}
	}