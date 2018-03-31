<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Upload media</title>

</head>
<body>

	<h3> File uploaded </h3>

	<ul>
		<?php foreach($upload_data as $k => $v) : ?>
			<li><?php echo $k; ?> - <?php echo $v; ?></li>
		<?php endforeach; ?>
	</ul>
</body>
</html>