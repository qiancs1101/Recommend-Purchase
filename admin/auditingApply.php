<?php 
// error_reporting(E_ALL^E_NOTICE);
require_once '../include.php';
$rows=listApply();


// if(!$rows){
// 	alertMes("sorry,你没有过申请历史","apply.php");
// 	exit;
// }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<center>
	<h3>所有申请状态</h3>
	<table width="90%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<thead>
		<tr>
			<th width="10%">申请编号</th>
			<th width="20%">物品名称</th>
			<th width="15%">联系电话</th>
			<th width="25%">联系地址</th>
			<th width="15%">申请状态</th>
			<th width="15%">操作</th>

			
		</tr>
		
	</thead>

	<tbody>
		     <?php  foreach($rows as $row):
		     if($row['app_status']==1001) $app_status = "待审核";
else if($row['app_status']==1010) $app_status = "通过审核，等待工作人员联系您";
else if($row['app_status']==1011) $app_status = "未通过审核";
else if($row['app_status']==1100) $app_status = "已结算完成";
else if($row['app_status']==1101) $app_status = "上架售卖中";
else if($row['app_status']==1110) $app_status = "物品已卖出";

?>
                            <tr>
                                <td><?php echo $row['id'];?></td>
                                <td><?php echo $row['pro_name'];?></td>
                                <td><?php echo $row['app_phone'];?></td>
                                <td><?php echo $row['app_address'];?></td>
                                <td><?php echo $app_status;?></td>
                                <td align="center"><input type="button" value="通过审核" class="btn" onclick="auditingApply(<?php echo $row['id'];?>,1)"><input type="button" value="拒绝申请" class="btn" onclick="auditingApply(<?php echo $row['id'];?>,0)"></td>
                            </tr>
                            <?php endforeach;?>
                           
	</tbody>
		

</center>


<script type="text/javascript">

	function auditingApply(id,flag){
		if(flag==1){
			if(window.confirm("您确定要同意这个申请吗？")){
				window.location="doAdminAction.php?act=passApply&id="+id;
			}
		}
		else{
			if(window.confirm("您确定要拒绝这个申请吗？")){
				window.location="doAdminAction.php?act=refuseApply&id="+id;
			}
		}
	}
</script>
</body>
</html>