<?php
$submit = $osw->Security->make_safe($_POST['submit']);
$title = $osw->Security->make_safe($_POST['title']);
$message = $osw->Security->make_safe($_POST['message']);
$tags = $osw->Security->make_safe($_POST['tags']);
$editid = $osw->Security->make_safe($_POST['editid']);
$delid = $osw->Security->make_safe($_POST['delid']);
$edit = $osw->Security->make_safe($_GET['edit']);

if ($submit == "Send") {
	if ($title) {
		if ($message) {
		$insrt = $osw->SQL->query("INSERT INTO `{$osw->config['db_prefix']}news` (title, message, tags, time, postedby) VALUE ('$title', '$message', '$tags', '$time', '$user_uuid')");
			if ($insrt == true) {
			echo $osw->site->displayalert('NEWS ADDED');
			}else if ($insrt == false) {
			echo $osw->site->displayalert('News not added');
			}
		}
	}
}else if ($submit == "Edit") {
		$updateq = $osw->SQL->query("UPDATE `{$osw->config['db_prefix']}news` SET title = '$title', message = '$message', tags = '$tags' WHERE id = '$editid'");
			if ($updateq) {
			echo $osw->site->displayalert('NEWS UPDATED');
			}else if ($insrt == false) {
			echo $osw->site->displayalert('News not updated');
			}
}else if ($submit == "Delete") {
$dq1 = $osw->SQL->query("DELETE FROM `{$osw->config['db_prefix']}news` WHERE id = '$delid'");
	if ($dq1) {
	echo $osw->site->displayalert('News and all comments for that news post have been deleted.');
	}else{
	echo $osw->site->displayalert('Error with deleting news post');
	}
}
if ($edit) {
$editq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}news` WHERE id = '$edit'");
$editrow = mysql_fetch_array($editq);
	$nid = $editrow['id'];
	$title = $editrow['title'];
	$message = $editrow['message'];
	$ntags = $editrow['tags'];

	$message = htmlspecialchars_decode($message, ENT_NOQUOTES);
	$message = html_entity_decode($message);
	echo "<form method='post' action='' class='form-horizontal'>
<input type='hidden' name='editid' value='$edit'>
<input type='text' name='title' value='$title' class='input-xlarge form-control' placeholder='Title'><br>
<textarea class='input-xlarge form-control' rows='10' name='message'>$message</textarea><br>
<input type='text' name='tags' data-provide='tag' value='$ntags' id='tags' class='input-xlarge form-control' placeholder='Tag example: fart, poop, roflmao'><br>
<input type='submit' name='submit' value='Edit' class='btn btn-success'>
</form>";
}else{
?>
<form method="post" action="" class="form-horizontal">
<input type="text" name="title" class="input-xlarge form-control" placeholder="Title"><br>
<textarea class="input-xlarge form-control" rows="10" name="message"></textarea><br>
<input type='text' name='tags' data-provide='tag' id='tags' class='input-xlarge form-control' placeholder='Tag example: fart, poop, roflmao'><br>
<input type="submit" name='submit' value="Send" class="btn btn-success">
</form>
<?php
}

$q = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}news` ORDER BY `id` DESC LIMIT 0,10");
while ($r = $osw->SQL->fetch_array($q))
{
$nid = $r['id'];
$title = $r['title'];
$message = $r['message'];
$postedby = $r['postedby'];
$time = $r['time'];
$date = $osw->site->time2date($time);

$postedname = $osw->grid->uuid2name($postedby);

$message = str_replace(chr(13),"<br>".chr(13),$message);
$message = htmlspecialchars_decode($message, ENT_NOQUOTES);
$message = html_entity_decode($message);

echo "<p align='left'>
<form method='post' action='' class='form-horizontal'>
<input type='hidden' name='delid' value='$nid'>
<a href='$address/news.php?id=$nid'><B>$title</B></a> - <small><i>Posted by: $postedname</i></small><br>
$message<br>
<small><i>Posted $date</i></small><br><a href='addnews.php?edit=$nid' class='btn btn-info'>Edit</a> <input type='submit' name='submit' value='Delete' class='btn btn-warning'>
</form>
</p>
<hr>
";

		++$i;
		}
?>