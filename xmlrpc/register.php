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
    $checkhost = $osw->SQL->query("SELECT register FROM hostsregister WHERE " .
            "host = '" . mysql_escape_string($hostname) . "' AND " .
            "port = '" . mysql_escape_string($port) . "'");

    // Get the request time as a timestamp for later
    $timestamp = $_SERVER['REQUEST_TIME'];

    // if greater than 1, check the nextcheck date
    if ($osw->SQL->num_rows($checkhost) > 0)
    {
        $update = "UPDATE hostsregister SET " .
                "register = '" . mysql_escape_string($timestamp) . "', " . 
                "nextcheck = '0', checked = '0', " .
                "failcounter = '0' " .  
                "WHERE host = '" . mysql_escape_string($hostname) . "' AND " .
                "port = '" . mysql_escape_string($port) . "'";

        $runupdate = $osw->SQL->query($update);
    }
    else
    {
        $register = "INSERT INTO hostsregister VALUES ".
                    "('" . mysql_escape_string($hostname) . "', " .
                    "'" . mysql_escape_string($port) . "', " .
                    "'" . mysql_escape_string($timestamp) . "', 0, 0, 0)";

        $runupdate = $osw->SQL->query($register);
    }
}
elseif ($hostname != "" && $port != "" && $service = "offline")
{
        $delete = "DELETE FROM hostsregister " .
                "WHERE host = '" . mysql_escape_string($hostname) . "' AND " .
                "port = '" . mysql_escape_string($port) . "'";

        $rundelete = $osw->SQL->query($delete);
}
?>
