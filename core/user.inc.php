<?php 
function reg(){
	$arr=$_POST;

	$arr['password']=md5($_POST['password']);
	$arr['regTime']=time();
	$uploadFile=uploadFile();
	
	//print_r($uploadFile);
	if($uploadFile&&is_array($uploadFile)){
		$arr['face']=$uploadFile[0]['name'];
	}else{
		return "注册失败";
	}
//	print_r($arr);exit;
	if(insert("imooc_user", $arr)){
		$mes="注册成功!<br/>3秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='3;url=login.php'/>";
	}else{
		$filename="uploads/".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$mes="注册失败!<br/><a href='reg.php'>重新注册</a>|<a href='index.php'>查看首页</a>";
	}
	return $mes;
}
function login(){
	$username=$_POST['username'];
	//addslashes():使用反斜线引用特殊字符
	//$username=addslashes($username);
	$username=mysql_escape_string($username);
	$password=md5($_POST['password']);
	$sql="select * from imooc_user where username='{$username}' and password='{$password}'";
	//$resNum=getResultNum($sql);
	$row=fetchOne($sql);
	//echo $resNum;
	if($row){
		$_SESSION['loginFlag']=$row['id'];
		$_SESSION['id']=$row['id'];
		$_SESSION['username']=$row['username'];
		$mes="登陆成功！<br/>3秒钟后跳转到首页<meta http-equiv='refresh' content='3;url=index.php'/>";
	}else{
		$mes="登陆失败！<a href='login.php'>重新登陆</a>";
	}
	return $mes;
}
function checkUserLogined(){

	if($_SESSION['username']==""&&$_COOKIE['username']==""){

		alertMes("请先登陆","login.php");
	}
}

function userOut(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}

	session_destroy();
	header("location:index.php");
}

function userApply(){
	$arr = $_POST;
	$arr['app_status'] = 1001;
	if($a = insert("apply",$arr)) {
		$mes="申请成功!<br/><a href='apply.php'>继续添加</a>|<a href='listApply.php'>查看申请状态</a>";
	}
	else{
		$mes="申请失败!<br/><a href='apply.php'>重新申请</a>";
	}
	return $mes;
}

function listApply(){
	$sql="select * from apply";
	$rows = fetchAll($sql);
	return $rows;
}

function cancelApply($id){
	if(delete("apply","id={$id}")){
		$mes="取消申请成功!<br/><a href='listApply.php'>查看申请列表</a>";
	}else{
		$mes="取消申请失败!<br/><a href='listApply.php'>请重新操作</a>";
	}
	return $mes;
}


