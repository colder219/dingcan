<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>小禾外卖</title>
<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<script language="javascript">
    function toVaild(){
            var val1 = document.getElementById("firstname").value;
            var val2 = document.getElementById("lastname").value;
            if(val1 == null || val1 =="" || val2 == null || val2 ==""){
                alert("填写不完整，请重新填写!");
                return false;
            }
            else{
                return true;
            }
        }
</script>
</head>
<body class="container">

<div class="page-header">
    <h1>小禾订餐系统
        <small>小禾外卖</small>
    </h1>
</div>

<?php
$conn=@mysql_connect("127.0.0.1","root","123456")or die("连接错误");
mysql_select_db("test");
mysql_query("set names utf8");

//echo date('y-m-d h:i:s',time());
$date= date('h:i:s',time());
if ($date > '15:30:00'){
?>
<h1 class="alert alert-warning"> 不好意思，餐厅已打烊了！</h1>
<form method="post" action="index.php" class="form-horizontal" target="id_iframe" hidden="hidden">
<?php
}else{
?>
<form method="post" action="index.php" class="form-horizontal" target="id_iframe">
<?php
}
?>
    <label class="control-label">请输入您的姓名:</label>
    <input  id="firstname" type="text" name="name" ><br>
    <label class="control-label">请输入想吃的菜:</label>
    <select id="lastname" class="custom-select" name="love">
        <option>天津大麻花</option>
        <option>红烧肉</option>
        <option>饺子</option>
        <option>重庆小面</option>
        <option>兰州拉面</option>
     </select><br /><br />
    <button class="btn btn-large btn-success" onclick="return toVaild();">提交</button>
    <button type="reset" class="btn btn-inverse"  value="提交"> 重置 </button>
</form>
<?php
    $name=$_POST['name'];
    $love=$_POST['love'];

    $sql1="insert into dingcan (name,love,shijian) values ('$name','$love',now())";
    if($name != "" || $love!=""){

    mysql_query($sql1);
    }else{
    }
?>

<?php
$query = mysql_query("select name,love,shijian from dingcan where date(shijian) = curdate() and shijian < '24:00:00'");
$num_rows = mysql_num_rows($query);


if ($num_rows >0){
?>
    <h1>以下是今天的订餐名单,共计<?php echo $num_rows ?> 位</h1>
<table class="table table-striped table-bordered table-hover table-condensed" >
<tr><th>编号</th><th>姓名</th><th>订餐类型（尽量满足）</th><th>订餐时间</th></tr>
<?php
    for($i=0; $i<$num_rows;$i++){
    $row=mysql_fetch_array($query);

    if($i % 2 == 0){
?>
<tr class="success">
<?php
}else{
?>
<tr class="error">
<?php
}
?>
    <td><?php echo $i+1 ?></td>
    <td><?php echo $row['name'] ?></td>
    <td><?php echo $row['love'] ?></td>
    <td><?php echo $row['shijian'] ?></td>
<tr>
<?php
    }
}
?>
</table>
<?php
mysql_close ();
?>
</body>
</html>
