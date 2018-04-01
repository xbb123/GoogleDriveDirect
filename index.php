<?php
	include('fetch.php');
	if(empty($_GET['id'])){
		exit('no file id');
	}
	$id = $_GET['id'];
	
	//get confirm
	$resp = fetch::get('https://drive.google.com/uc?export=download&id='.$id);
	//  <25M
	if(!empty($resp->headers['Location'])){
		header('location: '.$resp->headers['Location']);
		echo $resp->content;
	}
	list($tmp, $confirm) = explode('download&amp;confirm=', $resp->content);
	list($confirm, $tmp) = explode('&amp;id=', $confirm);
    if(empty($confirm)){
		exit('get confirm error');
	}
	
	//get download link
	$url = "https://drive.google.com/uc?export=download&confirm={$confirm}&id={$id}";
	$resp = fetch::get($url);
	if(!empty($resp->headers['Location'])){
		header('location: '.$resp->headers['Location']);
		echo $resp->content;
	}else{
	    exit('no download link');
	}