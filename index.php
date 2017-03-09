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

//echo date('y-m-d H:i:s',time());
$date= date('H:i:s',time());
if ($date > '17:30:00'){
?>
<h1 class="alert alert-warning"> 不好意思，餐厅已经打烊了！</h1>
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
        <option>送什么我吃什么</option>
<!--
        <option>醋溜土豆丝</option>
        <option>炝圆白菜</option>
        <option>黄焖鸡</option>
        <option>饺子</option>
        <option>重庆小面</option>
        <option>兰州拉面</option>
        <option>馒头</option>
-->
     </select><br /><br />
    <button class="btn btn-large btn-success" onclick="return toVaild();">提交</button>
    <button type="reset" class="btn btn-inverse"  value="提交"> 重置 </button>
</form>
<?php
$name=$_POST['name'];
$love=$_POST['love'];

$sqlx="select name from dingcan where date(shijian) = curdate() and shijian < '24:00:00'";
$q=mysql_query($sqlx);
$a=array();
while($b=mysql_fetch_array($q))
{
    $a[]=$b['name'];
}
if(in_array($name,$a)){
?>
    <script>
    alert("你是猪吗？只能点一份~哈哈哈")
        </script>
<?php
}else{

    $sql1="insert into dingcan (name,love,shijian) values ('$name','$love',now())";
    if($name != "" || $love!=""){

        mysql_query($sql1);
    }else{
    }
}
?>

<?php
$query = mysql_query("select name,love,shijian from dingcan where date(shijian) = curdate() and shijian < '24:00:00'");
$num_rows = mysql_num_rows($query);

#分页
$pagesize=10;

$pages = intval($num_rows / $pagesize);

if ($num_rows % $pagesize)
    $pages ++;

if (isset($_GET['page'])){
    $page=intval($_GET['page']);
}else{
    $page = 1;
}

$offset = $pagesize *($page -1);

$sql2="select name,love,shijian from dingcan where date(shijian) = curdate() and shijian < '24:00:00' limit $offset,$pagesize";
$query2=mysql_query($sql2);
$num2=mysql_num_rows($query2);


if ($num_rows >0){
?>
    <h1>以下是今天的订餐名单,共计<?php echo $num_rows ?> 位</h1>
<table class="table table-striped table-bordered table-hover table-condensed" >
<tr><th>编号</th><th>姓名</th><th>订餐类型（尽量满足）</th><th>订餐时间</th></tr>
<?php
    for($i=0; $i<$pagesize;$i++){
        $row=mysql_fetch_array($query2);

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
<div id="show_page">
    <p>
<?php
$first = 1;
$prev = $page - 1;
$next = $page + 1;
$last = $pages;
if ($page == 1 && $pages > 1) {
    echo "首页&nbsp;|&nbsp;";
    echo "上一页&nbsp;|&nbsp;";
    echo "<a href=\"index.php?page=" . $next . "\">下一页</a>&nbsp;|&nbsp;";
    echo "<a href=\"index.php?page=" . $last . "\">尾页</a>&nbsp;|&nbsp;";
} elseif ($page >= 1 && $page != $pages && $num > 0) {
    echo "<a href=\"index.php?page=" . $first . "\">首页</a>&nbsp;|&nbsp;";
    echo "<a href=\"index.php?page=" . $prev . "\">上一页</a>&nbsp;|&nbsp;";
    echo "<a href=\"index.php?page=" . $next . "\">下一页</a>&nbsp;|&nbsp;";
    echo "<a href=\"index.php?page=" . $last . "\">尾页</a>&nbsp;|&nbsp;";
} elseif ($page == $pages && $page != 1) {
    echo "<a href=\"index.php?page=" . $first . "\">首页</a>&nbsp;|&nbsp;";
    echo "<a href=\"index.php?page=" . $prev . "\">上一页</a>&nbsp;|&nbsp;";
    echo "下一页&nbsp;|&nbsp;";
    echo "尾页&nbsp;|&nbsp;";
} elseif ($page == $pages) {
    echo "首页&nbsp;|&nbsp;";
    echo "上一页&nbsp;|&nbsp;";
    echo "下一页&nbsp;|&nbsp;";
    echo "尾页&nbsp;|&nbsp;";
} else {
    echo "首页&nbsp;|&nbsp;";
    echo "上一页&nbsp;|&nbsp;";
    echo "下一页&nbsp;|&nbsp;";
    echo "尾页&nbsp;|&nbsp;";
}
?>
        共&nbsp;<span><?php echo $pages ?></span>&nbsp;页&nbsp;|&nbsp;当前第&nbsp;<span><?php echo $page ?></span>&nbsp;页&nbsp;|&nbsp;共&nbsp;<span><?php echo $num_rows ?></span>&nbsp个人
    </p>
</div>
<?php
mysql_close ();
?>
</body>
</html>
