<?php
	
	$uptypes = array(
		'image/jpg',
		'image/png',
		'image/gif',
		'image/bmp');
	$max_file_size = 20000000;
	$file = $_FILES["file"];
	$fileName = $file['name'];
	$filetype = $file['type'];
	$filesize = $file['size'];
	if(!in_array($filetype, $uptypes))
	{
		return "文件类型不符";
		exit;
	}
	if($filesize>max_file_size)
	{
		return "文件太大";
		exit;
	}
	if(!is_dir("upload/")){
		mkdir("upload/");
	}
	$url = "upload/";
	if(file_exists($url.$fileName)){
		return array("data"=>$url.$fileName);
	}
	else{
		$url = $url.$fileName;
		move_uploaded_file($_FILES["file"]["tmp_name"], $url);
		return array("data"=>$url.$fileName);
	}
?>