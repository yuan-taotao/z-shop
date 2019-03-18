<?php
	//后台主入口文件
	//判断是否传入类名参数 以及 方法名参数
	$class = !empty($_GET['m'])?ucfirst($_GET['m']):'Index';
	//echo $class;
	//判断是否传入方法名参数
	$method = !empty($_GET['a'])?$_GET['a']:'show';

	//包含数据库文件
	include '../public/dbconfig.php';
	//echo $class.'类名'.'<br/>';
	//echo $method.'方法名';


	//调用
	//1.将需要的类文件包含进来   魔术方法：autoload
	function __autoload($className){
		//echo '1';
		//包含需要的类文件
		if(file_exists('./Control/'.$className.'.class.php')){
			//加载控制器类
			require('./Control/'.$className.'.class.php');
		}elseif(file_exists('./Model/'.$className.'.class.php')){
			//加载数据库模型类
			require('./Model/'.$className.'.class.php');
		}elseif(file_exists('./org/'.$className.'.class.php')){
			//加载后台扩展类库中的类
			require('./org/'.$className.'.class.php');
		}elseif(file_exists('../public/org/'.$className.'.class.php')){
			//以下加载公共类库中的文件上传或者验证码类
			require('../public/org/'.$className.'.class.php');
		}else{
			die('错误，没有找到对应'.$className.'类');
		}
	}

	//2.必须得到类名以及方法名
	//拼接类名
	$name = $class.'Control';
	//实例化对象
	$one = new $name;
	//调用方法
	$one->$method();