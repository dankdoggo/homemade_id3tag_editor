<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Upload media</title>

</head>
<body>

	<?php if(isset($error)) echo $error; ?>

	<?php echo form_open_multipart('upload/do_upload'); ?>
	<input type="file" name="userfile">

	<input type="submit" value="upload">
</body>
</html>