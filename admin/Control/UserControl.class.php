<?php
	//会员类
	class UserControl{
		//删除会员方法
		function del(){
			//附表中有图片
			//查询附表图片名称
			$m1 = new Model('user_info');
			$re = $m1 -> where('uid='.$_GET['id'])->find();
			if($re){
				$path = '../public/upload/pic/'.$re['pic'];
				//echo $path;
				//删除图片
				unlink($path);
				//先删除附表
				$m1->where('uid='.$_GET['id'])->delete();
			}
			//删除主表
			$m = new Model('user');
			if($m->where('id='.$_GET['id'])->delete()){
				echo '<script>alert("删除成功");location="./index.php?m=user&a=show"</script>';
			}else{
				echo '<script>alert("删除失败");location="./index.php?m=user&a=show"</script>';
			}
		}
		//编辑会员的方法
		function update(){
			$m = new Model('user');
			$result = $m->where('id='.$_GET['id'])->find();
			//var_dump($result);
			//判断下权限
			$xz = $pu = $vip = $jin = $chao = '';
			switch($result['state']){
				case 0;
					$pu = 'selected';
					break;
				case 1:
					$vip = 'selected';
					break;
				case 2:
					$jin = 'selected';
					break;
				case 3:
					$chao = 'selected';
					break;
				default:
					$xz = 'selected';
			}
			include './View/user_update.html';
		}
		function do_update(){
			//1.验证用户名
				$yz = new YanZheng;
				//1.验证用户名是否符合要求
				//1.1定义要求
				$pattern = '/^[a-zA-Z]{6,13}$/';
				//1.2判断
				if(!$yz->userPattern($pattern,$_POST['username'])){
					echo '<script>alert("用户名不合法");location="./index.php?m=user&a=add"</script>';
					die();
				}
			//2.验证密码是否一致
				if(!empty($_POST['pwd']) && !empty($_POST['repwd'])){
					//用户需要更改密码
					if(!$yz->repwd($_POST['pwd'],$_POST['repwd'])){
					echo '<script>alert("两次密码不一致");location="./index.php?m=user&a=add"</script>';
					die();
					}else{
						//加密密码
						$_POST['pwd'] = md5($_POST['pwd']);
					}
				}else{
					//用户不需要更改密码
					unset($_POST['pwd']);
					unset($_POST['repwd']);

				}
			//var_dump($_POST);

			//3.判断是否选择权限
			if($_POST['state'] == 'xz'){
				echo '<script>alert("请选择会员权限");location="./index.php?m=user&a=add"</script>';
				die();
			}
			$m = new Model('user');
			if($m->where('id='.$_POST['id'])->update($_POST)){
				echo '<script>alert("修改成功");location="./index.php?m=user&a=show"</script>';
				//echo '<script>alert("修改成功");location="./index.php?m=user&a=update&id='.$_POST['id'].'"</script>';
			}else{
				echo '<script>alert("修改失败");location="./index.php?m=user&a=update&id='.$_POST['id'].'"</script>';
			}
		}
		protected function searchUser(){
			var_dump($_GET);
			//帮忙拼接条件语句username like %da% AND state  = 0
			//定义一个所有搜索条件的数组变量
			$wherelist = array();
			if(!empty($_GET['username'])){
				$wherelist[] = "username LIKE '%{$_GET['username']}%'";
			}
			//判断是否选择权限
			if(isset($_GET['state']) && $_GET['state'] != 'xz'){
				$wherelist[] = " state = ".$_GET['state'];
			}
			//判断性别搜索
			if(isset($_GET['sex']) && $_GET['sex'] != 'bxz'){
				//在附表
				$wherelist[] = "id IN(SELECT uid FROM user_info WHERE sex={$_GET['sex']})";
			}
			//判断年龄区间
			if(!empty($_GET['age1']) && !empty($_GET['age2']) && $_GET['age1'] < $_GET['age2']){
				$wherelist[] = "id IN(SELECT uid FROM user_info WHERE age BETWEEN {$_GET['age1']} AND {$_GET['age2']})";
			}
			//age= 18  age = 30
			//$wherelist[] = 'a=a';
			//拼接条件
			if(count($wherelist) > 0){
				return implode(' AND ',$wherelist);
			}else{
				return '';
			}
			//echo $re;
			//var_dump($wherelist);
		}
		//显示会员
		function show(){
			//var_dump($_GET);
			//判断是否加入搜索条件
			if(isset($_GET['biaoshi']) && $_GET['biaoshi'] == 's'){
				//后期需要加入条件
				$search = $this->searchUser();
			}else{
				$search = '';
			}
			//查询信息
			$m = new Model('user');
			//加入分页样式
			//获得总条数
			$p = new Page($m->where($search)->total(),3);

			$result = $m->where($search)->limit($p->limit())->select();
			// echo $m->sql;
			//var_dump($result);
			//echo '显示会员信息';
			include './View/main_list.html';
		}
		//添加会员
		function add(){
			//echo '添加会员	';
			//new数据库对象
			include './View/main_info.html';
		}
		//执行会员添加方法
		function do_add(){
			var_dump($_POST);
			//echo $_POST['username'];
			//创建验证方法
			$yz = new YanZheng;
			//1.验证用户名是否符合要求
				//1.1定义要求
				$pattern = '/^[a-zA-Z]{6,13}$/';
				//1.2判断
				if(!$yz->userPattern($pattern,$_POST['username'])){
					echo '<script>alert("用户名不合法");location="./index.php?m=user&a=add"</script>';
					die();
				}
			//2.验证密码是否一致
				if(!$yz->repwd($_POST['pwd'],$_POST['repwd'])){
					echo '<script>alert("两次密码不一致");location="./index.php?m=user&a=add"</script>';
					die();
				}else{
					//加密密码
					$_POST['pwd'] = md5($_POST['pwd']);
				}
			//3.判断是否选择权限
				if($_POST['state'] == 'xz'){
					echo '<script>alert("请选择会员权限");location="./index.php?m=user&a=add"</script>';
					die();
				}
			//4.调用数据库操作文件
			$m = new Model('user');
			//var_dump($_POST);
			//$m->insert();
			//5.执行添加数据库
			//将当前时间添加到数据中
			$_POST['addtime'] = time();
			//指定添加数据  //6.返回结果
			if($m->insert($_POST)){
				echo '<script>alert("添加[ '.$_POST['username'].' ]会员成功");location="./index.php?m=user&a=show"</script>';
			}else{
				echo '<script>alert("添加[ '.$_POST['username'].' ]会员失败!");location="./index.php?m=user&a=add"</script>';
			}
		}
		//会员详细信息处理方法
		function user_info(){
			//得到传过来的会员id（上会员附表中查询是否有该数据，如有有代表该会员有详细信息，则显示详细信息并且提供修改功能，如果会员没有详细信息，显示添加）
			//var_dump($_GET);
			//查询数据库会员附表中是否有传入当前的id数据
			$result = $this->selectUser_info();
			//定义判断变量
			$nv = $nan = $baomi  = '';
			$dazhuan = $benke = $yan = $xxz = '';
			$yxz = $y1 = $y2 = $y3 = $y4  = '';
			$hxz = $dan = $yi = $li = $sang = '';
			//如果该变量有数据 则 显示修改  如果该变量没有数据 则是添加
			if($result){
				//定义显示变量
				$user_info_str = '修改会员详细信息';
				$method = 'do_user_update';
				//性别判断
				switch($result['sex']){
					case 0:
						$nv = 'checked';
						break;
					case 1:
						$nan = 'checked';
						break;
					case 2:
						$baomi = 'checked';
				}
				//判断学历
				switch($result['xueli']){
					case 0;
						$dazhuan = 'selected';
						break;
					case 1:
						$benke = 'selected';
						break;
					case 2:
						$yan = 'selected';
						break;
					default:
						$xxz = 'checked';
				}
				//判断月收入
				switch($result['ysr']){
					case 0:
						$y1 = 'selected';
						break;
					case 1:
						$y2 = 'selected';
						break;
					case 2:
						$y3 = 'selected';
						break;
					case 3:
						$y4 = 'selected';
						break;
					default:
						$yxz = 'selected';
				}
				//婚姻判断
				switch($result['hunfou']){
					case 0:
						$dan = 'selected';
						break;
					case 1:
						$yi = 'selected';
						break;
					case 2:
						$li = 'selected';
						break;
					case 3:
						$sang = 'selected';
						break;
					default:
						$hxz = 'selected';
				}
				//var_dump($result['hobby']);
				//将从数据库中得到的爱好数组下标再次转换成数组
				$result['hobby'] = explode(',',$result['hobby']);
				//var_dump($result);
				//echo '修改';
				//做修改时头像显示
				$img = '<img src="../public/upload/pic/'.$result['pic'].'" width="100" />';
				$yimg = '<input type="hidden" name="ypic" value="'.$result['pic'].'">';
			}else{
				$user_info_str = '添加会员详细信息';
				$method = 'do_user_add';
				$img = '';
				$yimg = '';
			}
			//定义一个爱好数组
			$hobby = array('篮球','游戏','运动','吃','旅游','看书','玩');
			//查询会员行业表数据库 查询行业
			$m = new Model('user_hangye');
			$hangye = $m->select();
			//var_dump($hangye);
			//echo '查看会员详细信息';
			include './View/user_info.html';
		}
		//修改会员详细信息方法
		function do_user_update(){
			//var_dump($_POST);
			//var_dump($_FILES);
			//1.获取要修改的会员详细信息
			//2.判断是否需要修改会员图像
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
			//var_dump($_POST);
			//3.处理数据
			$_POST['hobby']  = implode(',',$_POST['hobby']);
			//4.进行数据修改
			$m = new Model('user_info');
			$r = $m->where('uid='.$_POST['uid'])->update($_POST);
			echo $m->sql;//exit;
			//5.删除原有图像
			if($bool == true){
				unlink('../public/upload/pic/'.$_POST['ypic']);
			}
			//6.如果成功则返回 (切记 带回数据的id 和 username)
			if($r){
				echo '<script>alert("修改成功");location="./index.php?m=user&a=user_info&id='.$_POST['uid'].'&username='.$_POST['username'].'"</script>';
			}else{
				echo '<script>alert("修改失败");location="./index.php?m=user&a=user_info&id='.$_POST['uid'].'&username='.$_POST['username'].'"</script>';
			}
		}
		//私有方法赋值查询会员详细信息
		private function selectUser_info(){
			//实例化数据库对象
			$m = new Model('user_info');
			return $m->where('uid='.$_GET['id'])->find();
			//var_dump($result);
		}
		//执行添加会员信息信息方法
		function do_user_add(){
			// var_dump($_POST);
			// var_dump($_FILES);
			//1.进行图片上传
			$up = new Upload('pic','../public/upload/pic');
			$res = $up ->do_upload();
			if(is_array($res)){
				$_POST['pic'] = $res['name'];
			}else{
				//var_dump($_GET);
				//echo $res;
				echo '<script>alert("'.$res.'");location="./index.php?m=user&a=user_info&id='.$_POST['uid'].'&username='.$_POST['username'].'"</script>';
				//$_POST['pic'] = 'a.jpg';
			}
			//2.处理数据
			//var_dump($_POST);
			//将爱好拼接成字符串
			$_POST['hobby'] = implode(',',$_POST['hobby']);
			//var_dump($_POST);
			//3.添加数据
			$m = new Model('user_info');
			if($m->insert($_POST)){
				echo '<script>alert("添加成功");location="./index.php?m=user&a=user_info&id='.$_POST['uid'].'&username='.$_POST['username'].'"</script>';
			}else{
				echo '<script>alert("添加失败");location="./index.php?m=user&a=user_info&id='.$_POST['uid'].'&username='.$_POST['username'].'"</script>';
			}
		}
		//显示添加行业信息
		function user_info_hangye(){
			$m = new Model('user_hangye');
			if(!empty($_POST['hname'])){
				//执行添加

				if($m->insert($_POST)){
					echo '<script>alert("添加成功");</script>';
				}else{
					echo '<script>alert("添加失败");</script>';
				}
			}
			//添加分页效果
			$p = new Page($m->total(),5);
			//查询数据 遍历结果
			$result = $m->limit($p->limit())->select();
			//echo '添加行业';
			include './View/user_info_hangye.html';
			//var_dump($_POST);

		}
		// 显示修改的单条行业名称
		function user_hangye_update(){
			// var_dump($_GET);
			// 包含修改行业名称的页面
			include './View/user_hangye_update.html';
		}
		function do_user_hangye_update(){
			// var_dump($_GET);
			// var_dump($_POST);
			$m=new Model('user_hangye');
			$res=$m->where('hid='.$_GET['hid'])->update($_POST);
			// var_dump($res);
			if ($res) {
				echo '<script>alert("修改成功");location="./index.php?m=user&a=user_info_hangye"</script>';
			}else{
				echo '<script>alert("修改失败");location="./index.php?m=user&a=user_hangye_update"</script>';
			}
		}

	}