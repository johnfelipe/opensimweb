<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class forum
{

var $osw;
	
	function forum(&$osw)
	{
		$this->osw = &$osw;
	}

	function countTopics($where)
	{
		$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}forum_topic` $where");
		$c = $this->osw->SQL->num_rows($q);
		return $c;
	}

	function countReplies($where)
	{
		$q = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}forum_replies` $where");
		$c = $this->osw->SQL->num_rows($q);
		return $c;
	}
}
?>