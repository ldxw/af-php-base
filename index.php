<?php
/*
@ 作者:浪人
@ 感谢 657207 和 郑锋 的协助修改
@ 写于2012-10-29
@ 最后更新于2013-01-11
@ 版本:1.3
@ 详情请访问Hu60.cn
@ 转载请保留版权信息，谢谢。
*/
error_reporting(0); header("Content-Type: text/html; charset=UTF-8");
echo '<html>
<head>
<style type="text/css">
.tp
{
background-color:#2F4F4F;
color:#7FFFD4;
}
</style>
<title>便携式ZIP解压工具 - Powered by 浪人!</title>
</head>
<body>
<div class="tp">ZIP解压－当前路径</div>';
echo dirname(__FILE__);
if(isset($_POST['upload'])){
echo '<div class="tp">文件上传－上传结果</div>';
if(file_put_contents($_POST['upname'],file_get_contents($_POST['upfile']))){
echo '文件 '.$_POST['upname'].' 上传成功。';
}else{
echo '文件 '.$_POST['upname'].' 上传失败。';
}
}
if(isset($_POST['extract'])){
echo '<div class="tp">文件解压－解压结果</div>';
if(!file_put_contents('pclzip.lib.php',file_get_contents('http://hu60.cn/wap/0wap/addown.php/pclzip.lib.php.gz'))){
echo '文件 pclzip.lib.php 远程下载失败，无法解压，程序终止！<br/>';
}else{
echo '文件 pclzip.lib.php 下载成功！<br/>';
require 'pclzip.lib.php';
$zip=$_POST['zip'];
$archive=new PclZip($zip);
if($archive->extract(PCLZIP_OPT_PATH,$_POST['root'])==0){
echo '解压失败，错误信息: <br/>'.$archive->errorInfo(true);
}else{
echo '文件 '.$zip.' 解压成功!';
}
}
}
echo '
<form action=" " method="post">
<div class="tp">解压文件－文件名称</div><br/>
<select name="zip">
<option value="" selected>--------- 请选择ZIP文件 --------</option>';
$fdir=opendir('./');
while($file=readdir($fdir)){
if(!is_file($file))
continue;
if(preg_match('/\.zip$/mis',$file)){
echo '<option value="'.$file.'">'.$file.'</option>';
}
}
echo '</select>
<div class="tp">文件解压－解压路径</div>
(支持多级目录，格式为:<span style="color:red">root/root2</span>，支持相对路径和绝对路径，解压到当前目录请不要填写此项)<br/>
<input type="text" name="root">
<br/><input type="submit" name="extract" value="解压!" />
<div class="tp">文件上传－文件地址</div>
<input type="text" name="upfile" value="http://"/><br/>
<div class="tp">文件上传－保存名称</div>
<input type="text" name="upname"/><br/>
<input type="submit" name="upload" value="上传!" />
</form>
<div class="tp">Powered By 浪人!</div>
</body>
</html>';
@unlink('pclzip.lib.php');
?>
