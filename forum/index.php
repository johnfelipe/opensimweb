<?php
$page_title = "Forums";
$hide_sidebars = true;
define('OSW_IN_SYSTEM', true);
require_once('../inc/header.php');

$catq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}forum_cat` ORDER BY `sort` ASC LIMIT 0,100");
while ($catr = $osw->SQL->fetch_array($catq)) {
	$catid = $catr['id'];
	$catname = strtoupper($catr['title']);
	echo "<div class='table-responsive'>
	<table class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<th>" . $catname . "</th>
				<th>TOPICS</th>
				<th>POSTS</th>
				<th>LAST POST</th>
			</tr>
		</thead>
		<tbody>";
		$boardq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}forum_board` WHERE catid = '$catid' ORDER BY `sort` ASC LIMIT 0, 100");
		while ($boardr = $osw->SQL->fetch_array($boardq)) {
			$board_id = $boardr['id'];
			$board_name = $boardr['name'];
			$board_desc = $boardr['desc'];

			$topicc = $osw->forum->countTopics("WHERE board_id = '$board_id'");
			$replyc = $osw->forum->countReplies("WHERE board_id = '$board_id'");

			if ($replyc == 0) {
				$replyer = "";
			}else{
				$lastreplyq = $osw->SQL->query("SELECT * FROM `{$osw->config['db_prefix']}forum_replies` WHERE board_id = '$board_id' ORDER BY `id` DESC LIMIT 0,1");
				$lastreplyr = $osw->SQL->fetch_array($lastreplyq);
				$lastreply_id = $lastreplyr['id'];
				$lastreply_user = $lastreplyr['user'];
				$lastreply_date = $osw->site->time2date($lastreplyr['time']);
				$replyer = "<a href='topic.php?id=" . $lastreply_id . "'>" . $lastreply_user . "</a><br><small>". $lastreply_date . "</small>";
			}

			echo "<tr>
			<td><a href='board.php?b=" . $board_id . "'><B>" . $board_name . "</B></a><br><small>" . $board_desc . "</small></td>
			<td>". $topicc . "</td>
			<td>". $replyc . "</td>
			<td>". $replyer . "</td>
			</tr>";
		}
echo "</tbody>
	</table>
</div>
";
}

include ('../inc/footer.php');
?>
