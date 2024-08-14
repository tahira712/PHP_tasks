<?php
if(isset($_FILES['files'])){
    $folder = "uploads/";

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];

        $unique_filename = uniqid() . "_" . time() . "_" . $file_name;

        $destination = $folder . $unique_filename;



$fileExtension=strtolower(explode("/",$_FILES['files']["type"][$key])[1]);
$allowedExtension=["jpg","jpeg","avif","webp","png"];
// print_r($fileExtension);
if(in_array($fileExtension,$allowedExtension)){
	if (move_uploaded_file($tmp_name, $destination)) {
		echo '<h2 style="color: #4e82b8; padding: 10px; ; width: 100%; box-sizing: border-box;height:60px; " >File \'' . $file_name . '\' successfully uploaded as \'' . $unique_filename . '\'</h2><br>';
	} else {
		echo "Error uploading '$file_name'.<br>";
	}
}else {
    echo '<h2 style="color: red; padding: 10px; margin-top: 50px; width: 100%;box-sizing: border-box; height:60px ; ">File type not supported.</h2><br>';
}

echo "<br>";

        
    }
}
?>
