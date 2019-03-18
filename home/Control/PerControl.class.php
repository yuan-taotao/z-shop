<?php


// var_dump($_GET['id']);

		class PerControl{
			// 查看个人中心的方法
			function show(){
				// 打开回话
				session_start();
				
				// 查询主表信息
				$m=new Model('user');
				$result=$m->where('id='.$_SESSION['user']['id'])->select();
				foreach ($result as $k => $v) {
				}
				 // var_dump($v);
				$time=date("Y-m-d H:i:s",$v['addtime']);
				// var_dump($time);
				// var_dump($result);
				
				//查询附表信息
				$m1=new Model('user_info');
				$res=$m1->where('uid='.$_SESSION['user']['id'])->select(); 
				// var_dump($res);
				foreach ($res as $key => $val) {
				}
				// var_dump($val);
				$sex=array('女','男','保密');
				$hf=array('单身','已婚','离异','丧偶');
				$qx=array('普通会员','VIP会员','禁用','超级管理员');
				// 显示个人中心
				include './View/grzx.html';
			}
			function update(){
				session_start();
				// var_dump($_GET);
				include './View/update.html';
			}
			function do_update(){
			// var_dump($_POST);
			// var_dump($_FILES);
			//1.获取要修改的会员详细信息
			//2.判断是否需要修改会员图像
			session_start();
			$bool = false;
			if(!empty($_FILES['pic']['name'])){
				//修改图像
				$up = new Upload('pic','../public/upload/pic');
				$res = $up->do_upload();
				if(is_array($res)){
					//拼接图片新名称
					$_POST['pic'] = $res['name'];
					$bool = true;
				}else{
					//图片名称没有更改
					$_POST['pic'] = $_POST['ypic'];
				}
			}else{
				//图片名称没有更改
				$_POST['pic'] = $_POST['ypic'];
			}
			// var_dump($_POST);
			//4.进行数据修改
			$m = new Model('user_info');
			$r = $m->where('uid='.$_SESSION['user']['id'])->update($_POST);
			echo $m->sql;//exit;
			//5.删除原有图像
			if($bool == true){
				unlink('../public/upload/pic/'.$_POST['ypic']);
			}
			//6.如果成功则返回 (切记 带回数据的id 和 username)
			if($r){
				echo '<script>alert("修改成功");location="./index.php?m=per&a=show"</script>';
			}else{
				echo '<script>alert("修改失败");location="./index.php?m=per&a=update"</script>';
			}
		}
		}