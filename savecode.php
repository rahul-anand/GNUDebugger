<?php
@ob_start();
session_start();
function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
$_SESSION['pos']=$_POST['pos'];
$_SESSION['code']=$_POST['mycode'];
print_r($_POST);
print_r($_GET);
$dir=$_POST['dir'];
$fhist="$dir/".'hist.txt';
$fhist1="$dir/".'hist1.txt';

$file = "$dir/".'code.c';

$current =$_POST['mycode'];
echo $current;
unlink($file);
$fhis = fopen($fhist, 'a') or die("can't open file");
$fhis1 = fopen($fhist1, 'a') or die("can't open file");
$fh = fopen($file, 'w') or die("can't open file");

fwrite($fh, $current);

fclose($fh);
// Write the contents back to the file

#file_put_contents($file, $current);

$file1 = "$dir/".'test.gdb';
$file2 = "$dir/".'test1.gdb';
$debug="break 1 \n run ";
$debug1="break 1 \n run ";
for($i=0;$i<$_POST['pos'];$i++)
$debug=$debug."\n step";
for($i=0;$i<$_POST['pos'];$i++)
$debug1=$debug1."\n step";


$debug1=$debug."\ninfo locals";
file_put_contents($file1, $debug);
file_put_contents($file2, $debug1);
$compile="gcc -g $dir/code.c -o $dir/main";
echo $compile."</br>";
$last_line = system($compile);
$deb="gdb --batch --command=$dir/test.gdb --args $dir/main > $dir/out.txt";
echo $deb."</br>";
$last_line1 = system($deb);
$deb1="gdb --batch --command=$dir/test1.gdb --args $dir/main > $dir/out1.txt";
$last_line2 = system($deb1);




$file = file("$dir/out.txt");
$file = array_reverse($file);
$line = $file[0];;
for($i=1;$i<count($file);$i++){
echo "</br>";
print_r($pieces);
echo "</br>";
$pieces = multiexplode(array(" ","\t"),$file[$i]);
$string = str_replace(' ', '', $pieces[0]);
$string=preg_replace('/\s+/', '', $string);
#print_r($pieces);
echo "</br>pp".$string."pp</br>";
echo "yy".$line."zz";
if(ctype_digit($string))
break;
$line=$line."\n".$file[$i];
}
echo $line;
echo "</br>";
$vars="";
$file = file("$dir/out1.txt");
$file = array_reverse($file);
foreach($file as $f){
    //echo $f."<br />";
$pieces = multiexplode(array(" ","\t"),$f);
$string = str_replace(' ', '', $pieces[0]);
$string=preg_replace('/\s+/', '', $string);
print_r($pieces);
echo "xx".$string."xx"."</br>" ;
if(ctype_digit($string) || (strpos($string,'0x') !== false) )
break;
$vars=$vars."\n".$f;

}

echo $vars;
$pos=$_SESSION['pos'];
fwrite($fhis,"$pos    =>  	".$line);
fwrite($fhis,"\n------------------------------------------\n");

fclose($fhis);

fwrite($fhis1, "$pos    =>  	".$vars);
fwrite($fhis1,"\n------------------------------------------\n");

fclose($fhis1);
echo "</br>";
$ccode=$_POST['mycode'];
$newURL="gdb.php";
$data=file_get_contents("$dir/hist.txt");
echo $data;

$_SESSION['line']=$data;
$data=file_get_contents("$dir/hist1.txt");
$_SESSION['local']=$data;
echo $newURL;
header('Location: '.$newURL);

?>
