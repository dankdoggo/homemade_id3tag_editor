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

	<p> Now it's time to edit your file. You can get manually edit the information or you can select a musicbrainz suggestion below</p>

	<ul>
		<?php foreach($upload_data as $k => $v) : ?>
			<li><?php echo $k; ?> - <?php echo $v; ?></li>
		<?php endforeach; ?>
	</ul>

	<?php echo form_open('upload/edit_media'); ?>

	<?php foreach($upload_data as $k => $v) : ?>
		<label for="<?php echo $k; ?>"><?php echo $k; ?></label><br>
		<input id="<?php echo $k; ?>" type="text" name="<?php echo $k; ?>" value="<?php echo $v; ?>">
		<br><br>
	<?php endforeach; ?>
	<input type="submit" value="edit">


</body>
</html>