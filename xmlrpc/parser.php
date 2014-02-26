<?
// Modified by Christopher Strachan to work with opensimweb
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');

$now = time();

function GetURL($host, $port, $url)
{
    $url = "http://$host:$port/$url";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $data = curl_exec($ch);
    if (curl_errno($ch) == 0)
    {
        curl_close($ch);
        return $data;
    }

    curl_close($ch);
    return "";
}

function CheckHost($hostname, $port)
{
    global $now;

    $xml = GetURL($hostname, $port, "?method=collector");
    if ($xml == "")	//No data was retrieved? (CURL may have timed out)
        $failcounter = "failcounter + 1";
    else
        $failcounter = "0";

    //Update nextcheck to be 10 minutes from now. The current OS instance
    //won't be checked again until at least this much time has gone by.
    $next = $now + 600;

    $osw->SQL->query("UPDATE hostsregister SET nextcheck = '$next', checked = '1', failcounter = '$failcounter'  WHERE host = '$hostname' AND port = '$port'");

    if ($xml != "") 
        parse($hostname, $port, $xml);
}

function parse($hostname, $port, $xml)
{
    global $now;

    ///////////////////////////////////////////////////////////////////////
    //
    // Search engine sim scanner
    //

    //
    // Load XML doc from URL
    //
    $objDOM = new DOMDocument();
    $objDOM->resolveExternals = false;

    //Don't try and parse if XML is invalid or we got an HTML 404 error.
    if ($objDOM->loadXML($xml) == False)
        return;

    //
    // Get the region data to update
    //
    $regiondata = $objDOM->getElementsByTagName("regiondata");

    //If returned length is 0, collector method may have returned an error
    if ($regiondata->length == 0)
        return;

    $regiondata = $regiondata->item(0);

    //
    // Update nextcheck so this host entry won't be checked again until after
    // the DataSnapshot module has generated a new set of data to be parsed.
    //
    $expire = $regiondata->getElementsByTagName("expire")->item(0)->nodeValue;
    $next = $now + $expire;

    $updater = $osw->SQL->query("UPDATE hostsregister SET nextcheck = '$next' WHERE host = '$hostname' AND port = '$port'");

    //
    // Get the region data to be saved in the database
    //
    $regionlist = $regiondata->getElementsByTagName("region");

    foreach ($regionlist as $region)
    {
        $regioncategory = $region->getAttributeNode("category")->nodeValue;

        //
        // Start reading the Region info
        //
        $info = $region->getElementsByTagName("info")->item(0);

        $regionuuid = $info->getElementsByTagName("uuid")->item(0)->nodeValue;

        $regionname = $info->getElementsByTagName("name")->item(0)->nodeValue;

        $regionhandle = $info->getElementsByTagName("handle")->item(0)->nodeValue;

        $url = $info->getElementsByTagName("url")->item(0)->nodeValue;

        //
        // First, check if we already have a region that is the same
        //
        $check = $osw->SQL->query("SELECT * FROM regions WHERE regionuuid = '$regionuuid'");

        if (mysql_num_rows($check) > 0)
        {
            $osw->SQL->query("DELETE FROM regions WHERE regionuuid = '$regionuuid'");
            $osw->SQL->query("DELETE FROM parcels WHERE regionuuid = '$regionuuid'");
            $osw->SQL->query("DELETE FROM allparcels WHERE regionUUID = '$regionuuid'");
            $osw->SQL->query("DELETE FROM parcelsales WHERE regionUUID = '$regionuuid'");
            $osw->SQL->query("DELETE FROM objects WHERE regionuuid = '$regionuuid'");
        }

        $data = $region->getElementsByTagName("data")->item(0);
        $estate = $data->getElementsByTagName("estate")->item(0);

        $username = $estate->getElementsByTagName("name")->item(0)->nodeValue;
        $useruuid = $estate->getElementsByTagName("uuid")->item(0)->nodeValue;

        $estateid = $estate->getElementsByTagName("id")->item(0)->nodeValue;

        //
        // Second, add the new info to the database
        //
        $sql = "INSERT INTO regions VALUES('$regionname','$regionuuid','$regionhandle','$url','$username','$useruuid')";

        $osw->SQL->query($sql);

        //
        // Start reading the parcel info
        //
        $parcel = $data->getElementsByTagName("parcel");

        foreach ($parcel as $value)
        {
            $parcelname = $value->getElementsByTagName("name")->item(0)->nodeValue;

            $parceluuid = $value->getElementsByTagName("uuid")->item(0)->nodeValue;

            $infouuid = $value->getElementsByTagName("infouuid")->item(0)->nodeValue;

            $parcellanding = $value->getElementsByTagName("location")->item(0)->nodeValue;

            $parceldescription = $value->getElementsByTagName("description")->item(0)->nodeValue;

            $parcelarea = $value->getElementsByTagName("area")->item(0)->nodeValue;

            $parcelcategory = $value->getAttributeNode("category")->nodeValue;

            $parcelsaleprice = $value->getAttributeNode("salesprice")->nodeValue;

            $dwell = $value->getElementsByTagName("dwell")->item(0)->nodeValue;

            $owner = $value->getElementsByTagName("owner")->item(0);

            $owneruuid = $owner->getElementsByTagName("uuid")->item(0)->nodeValue;

            // Adding support for groups

            $group = $value->getElementsByTagName("group")->item(0);
            
            if ($group != "")
            {
                $groupuuid = $group->getElementsByTagName("groupuuid")->item(0)->nodeValue;
            }
            else
            {
                $groupuuid = "00000000-0000-0000-0000-000000000000";
            }

            //
            // Check bits on Public, Build, Script
            //
            $parcelforsale = $value->getAttributeNode("forsale")->nodeValue;
            $parceldirectory = $value->getAttributeNode("showinsearch")->nodeValue;
            $parcelbuild = $value->getAttributeNode("build")->nodeValue;
            $parcelscript = $value->getAttributeNode("scripts")->nodeValue;
            $parcelpublic = $value->getAttributeNode("public")->nodeValue;

            //
            // Save
            //
            $sql = "INSERT INTO allparcels VALUES('$regionuuid','$parcelname','$owneruuid','$groupuuid','$parcellanding','$parceluuid','$infouuid','$parcelarea' )";

            $osw->SQL->query($sql);

            if ($parceldirectory == "true")
            {
                $sql = "INSERT INTO parcels VALUES('$regionuuid','$parcelname','$parceluuid','$parcellanding','$parceldescription','$parcelcategory','$parcelbuild','$parcelscript','$parcelpublic','$dwell','$infouuid','$regioncategory')";

                $osw->SQL->query($sql);
            }

            if ($parcelforsale == "true")
            {
                $sql = "INSERT INTO parcelsales VALUES('$regionuuid','$parcelname','$parceluuid','$parcelarea','$parcelsaleprice','$parcellanding','$infouuid', '$dwell', '$estateid', '$regioncategory')";

                $osw->SQL->query($sql);
            }
        }

        //
        // Handle objects
        //
        $objects = $data->getElementsByTagName("object");

        foreach ($objects as $value)
        {
            $uuid = $value->getElementsByTagName("uuid")->item(0)->nodeValue;

            $regionuuid = $value->getElementsByTagName("regionuuid")->item(0)->nodeValue;

            $parceluuid = $value->getElementsByTagName("parceluuid")->item(0)->nodeValue;

            $location = $value->getElementsByTagName("location")->item(0)->nodeValue;

            $title = $value->getElementsByTagName("title")->item(0)->nodeValue;

            $description = $value->getElementsByTagName("description")->item(0)->nodeValue;

            $flags = $value->getElementsByTagName("flags")->item(0)->nodeValue;

            $osw->SQL->query("INSERT INTO objects VALUES('$uuid','$parceluuid','$location','$title','$description','$regionuuid')");
        }
    }
}

$sql = "SELECT host, port FROM hostsregister WHERE nextcheck < $now AND checked = 0 LIMIT 0,10";

$jobsearch = $osw->SQL->query($sql);

//
// If the sql query returns no rows, all entries in the hostsregister
// table have been checked. Reset the checked flag and re-run the
// query to select the next set of hosts to be checked.
//
if ($osw->SQL->num_rows($jobsearch) == 0)
{
    $osw->SQL->query("UPDATE hostsregister SET checked = 0");
    $jobsearch = $osw->SQL->query($sql);
}

while ($jobs = $osw->SQL->fetch_row($jobsearch))
    CheckHost($jobs[0], $jobs[1]);
?>
