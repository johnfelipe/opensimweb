<?PHP
// Modified by Christopher Strachan to work with opensimweb
define('OSW_IN_SYSTEM', true);
require_once('../inc/headerless.php');

$zeroUUID = "00000000-0000-0000-0000-000000000000";
$xmlrpc_server = xmlrpc_server_create();
 
xmlrpc_server_register_method($xmlrpc_server, "avatarclassifiedsrequest", "avatarclassifiedsrequest");
 
function avatarclassifiedsrequest($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $uuid           = $req['uuid'];
 
 
    $result = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_classifieds WHERE creatoruuid = '$uuid'");
 
    $data = array();
 
    while ($row = $osw->SQL->fetch_array($result))
    {
        $data[] = array(
                "classifiedid" => $row["classifieduuid"],
                "name" => $row["name"]);
    }
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}

# Classifieds Update
 
xmlrpc_server_register_method($xmlrpc_server, "classified_update", "classified_update");
 
function classified_update($method_name, $params, $app_data)
{
    global $zeroUUID;
 
    $req            = $params[0];
 
    $classifieduuid = $req['classifiedUUID'];
    $creator        = $req['creatorUUID'];
    $category       = $req['category'];
    $name           = $req['name'];
    $description    = $req['description'];
    $parceluuid     = $req['parcelUUID'];
    $parentestate   = $req['parentestate'];
    $snapshotuuid   = $req['snapshotUUID'];
    $simname        = $req['sim_name'];
    $globalpos      = $req['globalpos'];
    $parcelname     = $req['parcelname'];
    $classifiedflag = $req['classifiedFlags'];
    $priceforlist   = $req['classifiedPrice'];
 
    // Check if we already have this one in the database
    $check = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_classifieds WHERE classifieduuid = '$classifieduuid'");
 
    while ($row = $osw->SQL->num_rows($check))
    {
        $ready = $row[0];
    }
 
    if ($ready == 0)
    {
        // Doing some late checking
        // Should be done by the module but let's see what happens when
        // I do it here
 
        if($parcelname == "")
            $parcelname = "Unknown";
 
        if($parceluuid == "")
            $parceluuid = $zeroUUID;
 
        if($description == "")
            $description = "No Description";
 
        if($classifiedflag == 2)
        {
            $creationdate = time();
            $expirationdate = time() + (7 * 24 * 60 * 60);
        }
        else
        {
            $creationdate = time();
            $expirationdate = time() + (365 * 24 * 60 * 60);
        }
 
        $insertquery = "INSERT INTO `{$this->osw->config['profile_db']}`.profile_classifieds VALUES ('$classifieduuid', '$creator', '$creationdate', '$expirationdate', '$category', '$name', '$description', '$parceluuid', '$parentestate', '$snapshotuuid', '$simname', '$globalpos', '$parcelname', '$classifiedflag', '$priceforlist')";
 
        // Create a new record for this classified
        $result = $osw->SQL->query($insertquery);
    }
    else
    {
 
    }
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}

# Classifieds Delete
 
xmlrpc_server_register_method($xmlrpc_server, "classified_delete", "classified_delete");
 
function classified_delete($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $classifieduuid = $req['classifiedID'];
 
    $result = $osw->SQL->query("DELETE FROM `{$this->osw->config['profile_db']}`.profile_classifieds WHERE classifieduuid = '$classifieduuid'");
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}

#
# Picks
#
 
# Avatar Picks Request
 
xmlrpc_server_register_method($xmlrpc_server, "avatarpicksrequest", "avatarpicksrequest");
 
function avatarpicksrequest($method_name, $params, $app_data)
{
    $req            = $params[0];
    $uuid           = $req['uuid'];
    $data = array();
    $result = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_picks WHERE creatoruuid = '$uuid'");
 
    while ($row = $osw->SQL->fetch_array($result))
    {
        $data[] = array(
                "pickid" => $row["pickuuid"],
                "name" => $row["name"]);
    }
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}
 
# Request Picks for User
 
xmlrpc_server_register_method($xmlrpc_server, "pickinforequest", "pickinforequest");
 
function pickinforequest($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
    $pick           = $req['pick_id'];
 
    $data = array();
 
    $result = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_picks WHERE creatoruuid = '$uuid' AND pickuuid = '$pick'");
 
    $row = $osw->SQL->fetch_array($result);
    if ($row != False)
    {
        if ($row["description"] == null || $row["description"] == "")
            $row["description"] = "No description given";
 
        $data[] = array(
                "pickuuid" => $row["pickuuid"],
                "creatoruuid" => $row["creatoruuid"],
                "toppick" => $row["toppick"],
                "parceluuid" => $row["parceluuid"],
                "name" => $row["name"],
                "description" => $row["description"],
                "snapshotuuid" => $row["snapshotuuid"],
                "user" => $row["user"],
                "originalname" => $row["originalname"],
                "simname" => $row["simname"],
                "posglobal" => $row["posglobal"],
                "sortorder"=> $row["sortorder"],
                "enabled" => $row["enabled"]);
    }
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}
 
# Picks Update
 
xmlrpc_server_register_method($xmlrpc_server, "picks_update", "picks_update");
 
function picks_update($method_name, $params, $app_data)
{
    global $zeroUUID;
 
    $req            = $params[0];
 
    $pickuuid       = $req['pick_id'];
    $creator        = $req['creator_id'];
    $toppick        = $req['top_pick'];
    $name           = $req['name'];
    $description    = $req['desc'];
    $parceluuid     = $req['parcel_uuid'];
    $snapshotuuid   = $req['snapshot_id'];
    $user           = $req['user'];
    $simname        = $req['sim_name'];
    $posglobal      = $req['pos_global'];
    $sortorder      = $req['sort_order'];
    $enabled        = $req['enabled'];
 
    if($parceluuid == "")
        $parceluuid = $zeroUUID;
 
    if($description == "")
        $description = "No Description";
 
    // Check if we already have this one in the database
    $check = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_picks WHERE  pickuuid = '$pickuuid'");
 
    $row = $osw->SQL->num_rows($check);
 
    if ($row[0] == 0)
    {
        if($user == null || $user == "")
            $user = "Unknown";
 
        //The original parcel name is the same as the name of the
        //profile pick when a new profile pick is being created.
        $original = $name;
 
        $query = "INSERT INTO `{$this->osw->config['profile_db']}`.profile_picks VALUES ('$pickuuid','$creator','$toppick','$parceluuid','$name','$description','$snapshotuuid','$user','$original','$simname','$posglobal','$sortorder','$enabled')";
    }
    else
    {
        $query = "UPDATE `{$this->osw->config['profile_db']}`.profile_picks SET parceluuid = '$parceluuid', name = '$name', description = '$description', snapshotuuid = '$snapshotuuid' WHERE pickuuid = '$pickuuid'";
    }
 
    $result = $osw->SQL->query($query);
    if ($result != False)
        $result = True;
 
    $response_xml = xmlrpc_encode(array(
        'success' => $result,
        'errorMessage' => "MySQLi Error"
    ));
 
    print $response_xml;
}
 
# Picks Delete
 
xmlrpc_server_register_method($xmlrpc_server, "picks_delete", "picks_delete");
 
function picks_delete($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $pickuuid       = $req['pick_id'];
 
    $result = $osw->SQL->query("DELETE FROM `{$this->osw->config['profile_db']}`.profile_picks WHERE pickuuid = '$pickuuid'");
 
    if ($result != False)
        $result = True;
 
    $response_xml = xmlrpc_encode(array(
        'success' => $result,
        'errorMessage' => mysql_error()
    ));
 
    print $response_xml;
}
 
#
# Notes
#
# Avatar Notes Request

xmlrpc_server_register_method($xmlrpc_server, "avatarnotesrequest", "avatarnotesrequest");
 
function avatarnotesrequest($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
    $targetuuid     = $req['uuid'];
 
    $result = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_notes WHERE useruuid = '$uuid' AND targetuuid = '$targetuuid'");
    $num = $osw->SQL->num_rows($result);
    $row = $osw->SQL->fetch_array($result);
    if (!$num)
        $notes = "";
    else
        $notes = $row['notes'];
 
    $data[] = array(
            "targetid" => $targetuuid,
            "notes" => $notes);
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}
 
# Avatar Notes Update
 
xmlrpc_server_register_method($xmlrpc_server, "avatar_notes_update", "avatar_notes_update");
 
function avatar_notes_update($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
    $targetuuid     = $req['target_id'];
    $notes          = $req['notes'];
 
    // Check if we already have this one in the database
 
    $check = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_notes WHERE useruuid = '$uuid' AND targetuuid = '$targetuuid'");
    $num = $osw->SQL->num_rows($check);
    $row = $osw->SQL->fetch_array($check);
 
    if (!$num)
    {
        // Create a new record for this avatar note
        $result = $osw->SQL->query("INSERT INTO `{$this->osw->config['profile_db']}`.profile_notes VALUES ('$uuid','$targetuuid','$notes')");
    }
    else if ($notes)
    {
        // Delete the record for this avatar note
        $result = $osw->SQL->query("DELETE FROM `{$this->osw->config['profile_db']}`.profile_notes WHERE useruuid = '$uuid' AND targetuuid = '$targetuuid'");
    }
    else
    {
        // Update the existing record
        $result = $osw->SQL->query("UPDATE `{$this->osw->config['profile_db']}`.profile_notes SET notes = '$notes' WHERE useruuid = '$uuid' AND targetuuid = '$targetuuid'");
    }
 
    $response_xml = xmlrpc_encode(array(
        'success' => $result,
        'errorMessage' => 'MySQLi Error'
    ));
 
    print $response_xml;
}
 
# Profile bits
 
xmlrpc_server_register_method($xmlrpc_server, "avatar_properties_request", "avatar_properties_request");
 
function avatar_properties_request($method_name, $params, $app_data)
{
    global $zeroUUID;
 
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
 
    $result = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile WHERE useruuid = '$uuid'");
    $row = $osw->SQL->fetch_array($result);
 
    if ($row != False)
    {
        $data[] = array(
                "ProfileUrl" => $row["profileURL"],
                "Image" => $row["profileImage"],
                "AboutText" => $row["profileAboutText"],
                "FirstLifeImage" => $row["profileFirstImage"],
                "FirstLifeAboutText" => $row["profileFirstText"],
                "Partner" => $row["profilePartner"],
 
                //Return interest data along with avatar properties
                "wantmask"   => $row["profileWantToMask"],
                "wanttext"   => $row["profileWantToText"],
                "skillsmask" => $row["profileSkillsMask"],
                "skillstext" => $row["profileSkillsText"],
                "languages"  => $row["profileLanguages"]);
    }
    else
    {
        //Insert empty record for avatar.
        //FIXME: Should this only be done when asking for ones own profile?
        $sql = "INSERT INTO `{$this->osw->config['profile_db']}`.profile VALUES ('$uuid', '$zeroUUID', 0, 0, '', 0, '', 0, '', '', '$zeroUUID', '', '$zeroUUID', '')";
        $result = $osw->SQL->query($sql);
 
        $data[] = array(
                "ProfileUrl" => "",
                "Image" => $zeroUUID,
                "AboutText" => "",
                "FirstLifeImage" => $zeroUUID,
                "FirstLifeAboutText" => "",
                "Partner" => $zeroUUID,
 
                "wantmask"   => 0,
                "wanttext"   => "",
                "skillsmask" => 0,
                "skillstext" => "",
                "languages"  => "");
    }
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}
 
xmlrpc_server_register_method($xmlrpc_server, "avatar_properties_update", "avatar_properties_update");
 
function avatar_properties_update($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
    $profileURL     = $req['ProfileUrl'];
    $image          = $req['Image'];
    $abouttext      = $req['AboutText'];
    $firstlifeimage = $req['FirstLifeImage'];
    $firstlifetext  = $req['FirstLifeAboutText'];
 
    $result=$osw->SQL->query("UPDATE `{$this->osw->config['profile_db']}`.profile SET profileURL='$profileURL', profileImage='$image', profileAboutText='$abouttext', profileFirstImage='$firstlifeimage', profileFirstText='$firstlifetext' WHERE useruuid='$uuid'");
 
    $response_xml = xmlrpc_encode(array(
        'success' => $result,
        'errorMessage' => mysql_error()
    ));
 
    print $response_xml;
}

// Profile Interests

xmlrpc_server_register_method($xmlrpc_server, "avatar_interests_update", "avatar_interests_update");

function avatar_interests_update($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
    $wanttext       = $req['wanttext'];
    $wantmask       = $req['wantmask'];
    $skillstext     = $req['skillstext'];
    $skillsmask     = $req['skillsmask'];
    $languages      = $req['languages'];
 
    $result = $osw->SQL->query("UPDATE `{$this->osw->config['profile_db']}`.profile SET profileWantToMask = '$wantmask',profileWantToText = '$wanttext',profileSkillsMask = '$skillsmask',profileSkillsText = '$skillstext',profileLanguages = '$languages' WHERE useruuid = '$uuid'");
 
    $response_xml = xmlrpc_encode(array(
        'success' => True
    ));
 
    print $response_xml;
}
 
// User Preferences
 
xmlrpc_server_register_method($xmlrpc_server, "user_preferences_request", "user_preferences_request");
 
function user_preferences_request($method_name, $params, $app_data)
{
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
 
    $result = $osw->SQL->query("SELECT * FROM `{$this->osw->config['profile_db']}`.profile_settings WHERE useruuid = '$uuid'");
 
    $row = $osw->SQL->fetch_array($result);
 
    if ($row != False)
    {
        $data[] = array(
                "imviaemail" => $row["imviaemail"],
                "visible" => $row["visible"],
                "email" => $row["email"]);
    }
    else
    {
        //Insert empty record for avatar.
        //NOTE: The 'false' values here are enums defined in database
        $sql = "INSERT INTO `{$this->osw->config['profile_db']}`.profile_settings VALUES ('$uuid', 'false', 'false', '')";
        $result = $osw->SQL->query($sql);
 
        $data[] = array(
                "imviaemail" => False,
                "visible" => False,
                "email" => "");
    }
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}
 
xmlrpc_server_register_method($xmlrpc_server, "user_preferences_update", "user_preferences_update");
 
function user_preferences_update($method_name, $params, $app_data)
{
 
    $req            = $params[0];
 
    $uuid           = $req['avatar_id'];
    $wantim         = $req['imViaEmail'];
    $directory      = $req['visible'];
 
    $result = $osw->SQL->query("UPDATE `{$this->osw->config['profile_db']}`.profile_settings SET imviaemail = '$wantim', visible = '$directory' WHERE useruuid = '$uuid'");
 
    $response_xml = xmlrpc_encode(array(
        'success' => True,
        'data' => $data
    ));
 
    print $response_xml;
}
 
#
# Process the request
#
 
$request_xml = $HTTP_RAW_POST_DATA;
xmlrpc_server_call_method($xmlrpc_server, $request_xml, '');
xmlrpc_server_destroy($xmlrpc_server);
?>