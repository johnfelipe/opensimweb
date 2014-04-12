<?
// Modified by Christopher Strachan to work with opensimweb
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');

$hostname = $osw->Security->make_safe($_GET['host']);
$port = $osw->Security->make_safe($_GET['port']);
$service = $osw->Security->make_safe($_GET['service']);

if ($hostname != "" && $port != "" && $service == "online")
{
    // Check if there is already a database row for this host
    $checkhost = $osw->SQL->query("SELECT * FROM `{$this->osw->config['search_db']}`.hostsregister WHERE host = '$hostname' AND port = '$port'");

    // Get the request time as a timestamp for later
    $timestamp = $_SERVER['REQUEST_TIME'];

    // if greater than 1, check the nextcheck date
    if ($osw->SQL->num_rows($checkhost) >= 0)
    {
        $runupdate = $osw->SQL->query("UPDATE `{$this->osw->config['search_db']}`.hostsregister SET register = '$timestamp', nextcheck = '0', checked = '0', failcounter = '0' WHERE host = '$hostname' AND port = '$port'");
    }
    else
    {
        $runupdate = $osw->SQL->query("INSERT INTO `{$this->osw->config['search_db']}`.hostsregister VALUES ('$hostname', '$port', '$timestamp', 0, 0, 0)");
    }
}
elseif ($hostname != "" && $port != "" && $service = "offline")
{
        $rundelete = $osw->SQL->query("DELETE FROM `{$this->osw->config['search_db']}`.hostsregister WHERE host = '$hostname' AND port = '$port'");
}
?>
