<?php
if($_SERVER['SERVER_NAME']=="localhost" || $_SERVER['SERVER_NAME']=="127.0.0.1" || $_SERVER['SERVER_NAME']=="192.168.50.16" ){
    $host="localhost";
    $username="root";
    $password="";
    $dbname="job"; 
}
else if($_SERVER['SERVER_NAME']=="0.0.0.0"){
    $host="127.0.0.1";
    $username="root";
    $password="";
    $dbname="job";
}
else{
    $host="localhost";
    $username="carglogi_ship";
    $password="WHATTHEFUCKMAN";
    $dbname="carglogi_ship";
}

$sitename="Space Courrier";
$admin_email="support@SpaceCourrier.com";

$conn=mysqli_connect($host,$username,$password,$dbname);

if(!$conn){
    $response = array(
        "error" => "yes",
        "errorMsg" => "Invalid db details"
    );

    echo json_encode($response);
}


?>