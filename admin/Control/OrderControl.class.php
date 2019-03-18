<?php




	class OrderControl{
		// 显示订单的方法
		function show(){
			// 实例化对象
			$m=new Model('orders');
			$res=$m->select();
			// var_dump($res);
			$arr=array('已支付','已发货','已完成');
			$array=array('否','是');
			//包含订单页面
			include './View/order/order_list.html';
		}
		// 改变状态的方法
		function status(){
			// var_dump($_GET['id']);
			// 实例化对象
			if ($_GET['statu']==0) {
				$m=new Model('orders');
				$arr=array();
				$arr['status']=1;
				$res=$m->where('id='.$_GET['id'])->update($arr);
				// var_dump($res);
				header('location:index.php?m=order&a=show');
			}else{
				header('location:index.php?m=order&a=show');
			}
			
		}
	}