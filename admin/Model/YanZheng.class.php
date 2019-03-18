<?php
	class YanZheng{
		//验证用户名
		public function userPattern($pattern,$str){
			return preg_match($pattern,$str);
			//var_dump($a);
		}
		//将用户名输入的所有内容找到<或者>替换对应的实体字符
		public function user_repeat($user){
			$pattern = array('/</','/>/');
			$replace = array('&lt;','&gt;');
			return preg_replace($pattern,$replace,$user);
		}
		//验证密码
		public function repwd($pas1,$pas2){
			//判断传入的密码参数不为空
			if(!empty($pas1) && !empty($pas2)){
				if($pas1 == $pas2){
					return true;
				}else{
					return false;
				}
			}
		}
	}