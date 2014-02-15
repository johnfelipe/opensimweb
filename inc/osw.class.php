<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class osw
{

	function osw()
	{
		require_once('Security.class.php');
		$this->Security = new Security($this);

		Require_once('SQL.class.php');
		$this->SQL = new SQL($this);

		Require_once('pagination.class.php');
		$this->pagination = new pagination($this);

		Require_once('other.class.php');
		$this->other = new other($this);

		$cq = $this->SQL->query("SELECT * FROM `{$this->config['db_prefix']}settings`");
		while ($crow = $this->SQL->fetch_array($cq)) {
			$this->config[$crow['name']] = $crow['value'];
		}
	}

	function redirect($url) {
		switch ($this->config['redirect_type']) {
			default:
                header('Location: ' . $url);
                exit;
			break;
			case 2:
			    echo <<<META
<html><head><meta http-equiv="Refresh" content="0;URL={$url}" /></head><body></body></html>
META;
			    break;
			case 3:
			    echo <<<SCRIPT
<html><body><script>location="{$url}";</script></body></html>
SCRIPT;
			    break;
		}
	}
}
?>