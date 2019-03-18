<?php
	//商品模块
	class GoodsControl{
		//显示商品
		function show(){
			// echo '1111';
			//查看是否按照点击量排序
			if(isset($_GET['biaozhi']) && $_GET['biaozhi'] == 'a'){
				//需要按照点击量从低到高排序
				$order = 'clicknum ASC';
			}elseif(isset($_GET['biaozhi']) && $_GET['biaozhi'] == 'b'){
				//需要按照点击量从低到高排序
				$order = 'clicknum DESC';
			}else{
				$order = '';
			}
			//做一个点击 点击一次从低到高 在点击一次 从高到底
			if(isset($_GET['biaozhi']) && $_GET['biaozhi'] == 'c'){
				$num = 1;
				//判断做计数的文件是否存在
				if(file_exists('./include/num.txt')){
					$num = file_get_contents('./include/num.txt');
				}else{
					file_put_contents('./include/num.txt',$num);
				}
				//判断$num 是奇数还是偶数
				if($num % 2 == 0){
					$order = 'clicknum ASC';
				}else{
					$order = 'clicknum DESC';
				}
				//改变$num
				$num ++;
				//将$num 在写会文件做保存
				file_put_contents('./include/num.txt',$num);
			}

			//查询商品
			$m = new Model('goods');
			$result = $m->order($order)->select();
			// var_dump($result);
			//定义商品状态数组
			$state = array('新添加','<font color="green">在售</font>','<font color="red">下架</font>');
			// 查询商品类别
			$m1= new Model('type');
			$typea=$m1->select();
			// var_dump($typea);
			//echo $m->sql;
			include './view/goods/goods_list.html';
		}
		//添加商品
		function add(){
			//修改和添加都执行到该页面(goods_info.html)
			//获取商品类别
			$m = new Model('type');
			$result = $m->order('CONCAT(path,id) ASC')->select();
			// var_dump($result);
			include './view/goods/goods_info.html';
		}
		//执行添加
		function do_add(){
			
			//判断是否选择商品类别
			if($_POST['typeid'] == 'xz'){
				echo '<script>alert("请选择商品分类");location="./view/goods/goods_info.html"</script>';
				die();
			}
			//var_dump($_FILES);
			//执行文件上传
			$upload = new Upload('pic','../public/upload/goods',5000000);
			$result = $upload->do_upload();
			//var_dump($result);
			if(is_array($result)){
				$_POST['pic'] = $result['name'];
			}else{
				echo '<script>alert("'.$result.'");location="./view/goods/goods_info.html"</script>';
				die();
			}

			//链接数据库 执行添加商品
			$m = new Model('goods');
			//获取当前时间
			$_POST['addtime'] = time();
			// var_dump($_POST);
			// $aa =$m->insert($_POST);
			// var_dump($aa);
			// echo '1';exit;
			if($m->insert($_POST)){
				echo '<script>alert("添加商品成功");location="./index.php?m=goods&a=show"</script>';
			}else{
				//echo $m->sql;
				//如果添加失败，删除上传成功的图片
				unlink($result['pathinfo']);
				echo '<script>alert("添加失败");location="./View/goods/goods_info.html"</script>';
			}
		}
		// 删除商品的方法
		function delete(){
			$m=new Model('goods');
			$result=$m->where('id='.$_GET['id'])->delete();
			// var_dump($result);
			if ($result) {
				echo '<script>alert("删除商品成功");location="index.php?m=goods&a=show"</script>';
			}else{
				echo '<script>alert("删除商品失败");location="index.php?m=goods&a=show"</script>';
			}
		}
		// 修改商品的方法
		function update(){
			// var_dump($_GET);
			$m=new Model('goods');
			$res=$m->where('id='.$_GET['id'])->select();
			foreach ($res as $k => $val) {
				
			}
			//获取商品类别
			$m = new Model('type');
			$result = $m->order('CONCAT(path,id) ASC')->select();
			// var_dump($val);
			$x= $z = $x = '';
			//性别判断
				switch($val['state']){
					case 0:
						$x = 'checked';
						break;
					case 1:
						$z = 'checked';
						break;
					case 2:
						$x = 'checked';
				}
			// 显示商品修改页面
			include './View/goods/goods_update.html';
		}
		// 执行商品信息修改的方法
		function do_update(){
			// var_dump($_POST);
			// var_dump($_GET);
			// var_dump($_FILES);//exit;
			//1.获取要修改的会员详细信息
			//2.判断是否需要修改会员图像
			$bool = false;
			if(!empty($_FILES['pic']['name'])){
				//修改图像
				$up = new Upload('pic','../public/upload/goods');
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
			//var_dump($_POST);
			//4.进行数据修改
			$m = new Model('goods');
			$r = $m->where('id='.$_GET['id'])->update($_POST);
			// echo $m->sql;//exit;
			//5.删除原有图像
			if($bool == true){
				unlink('../public/upload/goods/'.$_POST['ypic']);
			}
			//6.如果成功则返回 (切记 带回数据的id 和 username)
			if($r){
				echo '<script>alert("修改成功");location="./index.php?m=goods&a=show"</script>';
			}else{
				echo '<script>alert("修改失败");location="./index.php?m=goods&a=show"</script>';
			}
		}
	}
