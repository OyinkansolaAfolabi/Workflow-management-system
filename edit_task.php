<?php
include 'db_connect.php';
if(isset($_GET['id'])){
	$id = $_GET['id'];
	echo "$id";
}
include 'manage_task.php';
?>