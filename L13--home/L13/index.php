<?php require("script.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
	<title>Multiple files</title>

</head>
<body>
	
	<form action="" method="post" enctype="multipart/form-data">
		<h1> Select the files you want to upload </h1>
		<input type="file" name="files[]" multiple >

		<button type="submit" name="upload">Upload files</button>
	</form>
	

</body>
</html>