<?php

session_set_cookie_params(31536000);
session_start();

$reciever=NULL;
$message=NULL;
$password=NULL;

if (isset($_POST["reciever"]) && isset($_POST["message"])) {
    $reciever=$_POST['reciever'];
    $message=$_POST['message'];
    $password=$_POST['password'];
}else{  
    header("Location: messages.php");
}


$success=0;



// $dbServer = 'localhost'; //Define database server host
// $dbUsername = 'root'; //Define database username
// $dbPassword = ''; //Define database password
// $dbName = 'crypten'; //Define database name



$dbServer = 'mysql.hostinger.in'; //Define database server host
$dbUsername = 'u131693756_admin'; //Define database username
$dbPassword = 'biappanwar'; //Define database password
$dbName = 'u131693756_crypt'; //Define database name

// $dbServer = 'mysql.hostinger.in'; //Define database server host
// $dbUsername = 'u554972518_admin'; //Define database username
// $dbPassword = 'bhaijaan'; //Define database password
// $dbName = 'u554972518_youth'; //Define database name

$conn=mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
if (!$conn) 
{
	header("Location : messages.php");
}

$sender=$_SESSION['email'];
$sendername=$_SESSION['name'];

if($sender==NULL)
{
 header("Location: messages.php");
}


function Encrypt($password, $data)
{

    $salt = substr(md5(mt_rand(), true), 8);

    $key = md5($password . $salt, true);
    $iv  = md5($key . $password . $salt, true);

    $ct = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);

    return base64_encode('Salted__' . $salt . $ct);
}


$message= Encrypt($password, $message);

$LoginQuery="INSERT INTO `". $reciever ."` (username, fname, message, senddate, isunread) values ('$sender', '$sendername', '$message', now(), 1) ";

$result=mysqli_query($conn, $LoginQuery);

header("Location: messages.php");

// while ($r=mysqli_fetch_assoc($result)) 
// {
// 	$data = $r['pass'];
//         if($data==$pass)
//         {
//         $success=1;
//         $_SESSION['name']=$r['fname'];
//         $_SESSION['email']=$r['email'];
//         }
// }

// echo "$success";

// if ($success==1) {
// 	header("Location: messages.php");
// }

// else
// {
// 	header("Location: index.html");
// }

?>	