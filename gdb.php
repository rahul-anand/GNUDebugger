<?php
@ob_start();

session_start();

#print "1";
#print_r($_GET);

if(!isset($_SESSION['pos']))
{
$_SESSION['pos']=0;
}

$rand_num=rand();

if(!isset($_SESSION['dir']))
{
mkdir($rand_num);
$_SESSION['dir']=$rand_num;
$dir=$rand_num;
#echo $dir;
}
else
{
$path=$_SESSION['dir'];
if (!is_dir($path))
    mkdir($path);
}



print_r($_SESSION);
?>
<html>
<head>
	<meta charset="UTF-8">

	<title>Input Number Incrementer</title>

	<link rel="stylesheet" href="css/style.css">
<script  type="text/javascript"
        src="http://code.jquery.com/jquery-1.10.2.js">
    </script>

<script type="text/javascript">
  
$(document).ready(function(){
    $('#hist').scrollTop($('#hist')[0].scrollHeight);
 $('#hist1').scrollTop($('#hist1')[0].scrollHeight);
});
  </script> 



<link rel="stylesheet" href="highlight/styles/default.css">
<script src="highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

</head>
<body >
<h1> GNU Debugger </h1>

<form  id="myForm" name="myForm"  action="savecode.php" method="post">
<table>
<tr>
<td>Code</td>
<td>Debug</td>
<td>Variables</td>
</tr>

<tr>
<td>

<textarea id="mycode" name="mycode" cols="50" rows="30">
<?php
 $dir=$_SESSION['dir'];
$data=file_get_contents("$dir/code.c");
echo $data;
?>

</textarea>

</td>
<td>

<textarea  id ="hist" name="hist" cols="50" rows="30">
<?php
echo $_SESSION['line'];
?>

</textarea>



</td>
<td>

<textarea id ="hist1" name="hist1"  cols="50" rows="30">
<?php
echo $_SESSION['local'];
?>

</textarea>



</td>
</tr>
</table>
 <input  name="dir" type="hidden" value="<?php echo $_SESSION['dir'];?>"/>
 <input  id='pos' name="pos" type="number" value="<?php echo $_SESSION['pos'];?>"  onChange="this.form.submit();" autofocus/>
</br>
</br>




<input type="submit" value="Submit">

</form>



</body>

</html>
