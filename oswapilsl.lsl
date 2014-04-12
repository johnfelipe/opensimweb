string url = "http://localhost/oswlslapi.php?"; // Address to OpenSimWeb and oswlslapi.php
string ownername;

key owner;
key primkey;

integer localchan;
integer gListener;

key http_usercounts;
key http_profile;

default
{
    state_entry()
    {
        owner = llGetOwner();
        ownername = llKey2Name(owner);
        primkey = llGetKey();
        localchan = (integer)("0x80000000"+llGetSubString((string)primkey,-8,-1));
        llSetTimerEvent(3600); // refresh the usual user count every 1 hour. 60 seconds times 60 minutes = 3600 seconds aka 1 hour
    }

    touch_end(integer num_detected)
    {
        key toucher = llDetectedKey(0);
        gListener = llListen(localchan, "", toucher, "");
        llDialog(owner, "Which example would you like to see in action?", ["Profile", "UserCounts"], localchan);
    }

    listen(integer chan, string name, key id, string msg)
    {
            llListenRemove(gListener);
            if (chan == localchan) {
                if (msg == "UserCounts") {
                    http_usercounts = llHTTPRequest(url + "t=usercounts", [HTTP_METHOD, "GET"], ""); // lets get the usual count
                    llOwnerSay("Fetching the usual user and region count from OpenSimWeb.");
                }else if (msg == "Profile") {
                    gListener = llListen(localchan, "", owner, "");
                    llTextBox(owner, "Please enter the avatar's name in the box below.\nYes a space between first and last is fine.\nIf the person only has a first name then please just type that.", localchan);
                }else{
                    http_profile = llHTTPRequest(url + "t=profile&u=" + llEscapeURL(msg), [HTTP_METHOD, "GET"], ""); // lets get your profile :D
                    llOwnerSay("Fetching " + msg + " from OpenSimWeb.");
                }
            }
    }

    http_response(key rid, integer status, list metadata, string body)
    {
        // We receive what oswlslapi.php echo's for us and turn it into a list by storing data seperated by a ~ with llParseString2List()
        list bodylist = llParseString2List(llUnescapeURL(body), ["~"], []);
        // We then break down that list into usable parts using llList2String()
        string msg0 = llList2String(bodylist, 0);
        string msg1 = llList2String(bodylist, 1);
        string msg2 = llList2String(bodylist, 2);
        string msg3 = llList2String(bodylist, 3);
        if (rid == http_usercounts) {
            string online = msg0;
            string total = msg1;
            string latest = msg2;
            string regions = msg3;
            llSay(0, "There are (" + online + ") users currently in world of a total of (" + total + ") total registered avatars\nOut of that many there has been a total of (" + latest + ") that have been active for the past month.\nThere are a total of (" + regions + ") regions currently online.");
            llSetText("Online: "+online+"\nTotal: "+total+"\nLatest: "+latest+"\nRegions: "+regions, <1.0,1.0,1.0>, 1.0);
        }
        if (rid == http_profile) {
            string msg4 = llList2String(bodylist, 4);
            string msg5 = llList2String(bodylist, 5);
            string msg6 = llList2String(bodylist, 6);
            string msg7 = llList2String(bodylist, 7);

            string mykey = msg0;
            string fakepic = msg1;
            string realpic = msg3;
            string aboutme = msg2;
            string realme = msg4;
            string mypartner;
            if (msg5 != "No one") {
            	mypartner = llKey2Name((key)msg5); // ONLY use llKey2Name() on Second Life.
            	// string mypartner = osKey2Name((key)msg5); // use this ONLY if llKey2Name fails to display the person's name. Its a bug with Opensim.
            }else{
            	mypartner = msg5;
            }
            string mywebsite = msg6;
            string uname = msg7;

            llSetTexture(fakepic, 0);
            llSetTexture(realpic, 1);
            llSay(0, uname + " key is " + mykey +"\nProfile of " + ownername + "\nInworld Life: " + aboutme + "\nReal Life: " + realme + "\nPartnered with: " + mypartner + "\nWebsite: " + mywebsite);
        }
    }

    timer()
    {
    	http_usercounts = llHTTPRequest(url + "t=usercounts", [HTTP_METHOD, "GET"], "");
    }
}

// Yes it is that easy.
// Why? Because I hate complex coding, way to confusing for me so therefor would be very confusing for those who either dont know lsl or just starting out.
// K.I.S.S. > Keep It Stupidly Simple
// Also complex code just generates unneeded lag
// I just realize that this script can be used in Second Life. Great way to promote your grid in SL ;)
// just leave osKey2Name() commented and you wont get errors in SL.