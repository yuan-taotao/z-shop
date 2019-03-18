<?php
	class TypeControl{
		function show(){
			$m = new Model('type');
			$result = $m->select();
			//调用无限分类的类 来处理数据
			$t = new Cattree($result);
			$res = $t->getTree();
			//var_dump($res);
			//显示分类信息页
			include('./View/type/type_list.html');
		}
		function add(){
			$m = new Model('type');
			$result = $m->select();
			$t = new Cattree($result);
			// var_dump($t);exit;
			$res = $t->getTree();
			// var_dump($res);exit;
			include ('./View/type/type_info.html');
		}
		function do_add(){
			if ($_POST['pid']!=0) {
				$_POST['path']='0,'.$_POST['pid'].',';
			}else{
				$_POST['path']=$_POST['pid'].',';
			}
			// var_dump($_POST);
			$m = new Model('type');
			 // $m->insert($_POST);
			// echo $m->sql;exit;
			if($m->insert($_POST)){
				echo '<script>alert("添加成功");location="./index.php?m=type&a=show"</script>';
			}else{
				echo '<script>alert("添加失败");location="./index.php?m=type&a=add"</script>';

			}
		}
		function paixu(){
			//var_dump($_POST);
			$m = new Model('type');
			$num = 0;
			foreach($_POST as $k=>$v){
				if($_POST[$k] != 0){
					$num += $m->where('id='.$k)->update(array('ord'=>$v));
				}
			}
			if($num > 0){
				header('location:./index.php?m=type&a=show');
			}
		}
		function delete(){
			var_dump($_GET);
			$m=new Model('type');
			$res=$m->where('id='.$_GET['id'])->delete();
			// exit;
			if ($res) {
				echo '<script>alert("删除成功");location="./index.php?m=type&a=show"</script>';
			}else{
				echo '<script>alert("删除失败");location="./index.php?m=type&a=show"</script>';
			}
		}
		// 修改分类
		function update(){
			// var_dump($_GET);
			$m=new Model('type');
			$res=$m->where('id='.$_GET['id'])->select();
			// var_dump($res);
			foreach ($res as $k => $v) {
				
			}
			// 显示修改页面
			include './View/type/type_update.html';
		}
		// 执行修改的方法
		function do_update(){
			// var_dump($_GET);
			// var_dump($_POST);
			$m=new Model('type');
			$res=$m->where('id='.$_GET['id'])->update($_POST);
			// var_dump($res);
			if ($res) {
				echo '<script>alert("修改成功");location="./index.php?m=type&a=show"</script>';
			}else{
				echo '<script>alert("修改失败");location="./index.php?m=type&a=update&id='.$_GET['id'].'"</script>';
		}
	}
}