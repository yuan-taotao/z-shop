<?php
	
	//包含数据库配置文件
	include '../public/dbconfig.php';
	//定义访问的规则
	//判断是否传入类名参数
	$class = !empty($_GET['m'])?ucfirst(strtolower($_GET['m'])):'Index';
	//判断是否传入方法名参数
	$method = !empty($_GET['a'])?strtolower($_GET['a']):'index';

	//自动加载类
	function  __autoload($className){
		//判断文件是否存储
		if(file_exists('./control/'.$className.'.class.php')){
			include './control/'.$className.'.class.php';
		}elseif(file_exists('./Model/'.$className.'.class.php')){
			include './Model/'.$className.'.class.php';
		}elseif(file_exists('../public/org/'.$className.'.class.php')){
			//以下加载公共类库中的文件上传或者验证码类
			require('../public/org/'.$className.'.class.php');
		}else{
			include './org/'.$className.'.class.php';
		}
	}
	//拼接类名
	$class.='Control';
	//实例化对象
	$one = new $class;
	//调用方法
	$one->$method();