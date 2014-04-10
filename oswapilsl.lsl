string url = "http://localhost/oswlslapi.php?"; // Address to OpenSimWeb and oswlslapi.php
string ownername;

key owner;
key primkey;

integer localchan;
integer textboxchan;
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
		textboxchan = (integer)("0x80000000"+llGetSubString((string)primkey,-4,-1));
	}

	touch_end(integer num_detected)
	{
		key toucher = llDetectedKey(0);
		if (toucher == owner) {
			gListener = llListen(localchan, "", owner, "");
			llDialog(owner, "Which example would you like to see in action?", ["Profile", "UserCounts"], localchan);
		}
	}

	listen(integer chan, string name, key id, string msg)
	{
		if (id == owner)
		{
			llListenRemove(gListener);
			if (chan == localchan) {
				if (msg == "UserCounts") {
					http_usercounts = llHTTPRequest(url + "t=usercounts", [HTTP_METHOD, "GET"], ""); // lets get the usual count
					llOwnerSay("Fetching the usual user and region count from OpenSimWeb.");
				}
				if (msg == "Profile") {
					gListener = llListen(textboxchan, "", owner, "");
					llTextBox(owner, "Please enter the avatar's name in the box below.\nYes a space between first and last is fine.\nIf the person only has a first name then please just type that.", textboxchan);
				}
			}
			if (chan == textboxchan) {
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
			llSay(0, "There are (" + online + ") users currently in world of a total of (" + total + ") total registered avatars\n
				Out of that many there has been a total of (" + latest + ") that have been active for the past month.\n
				There are a total of (" + regions + ") regions currently online.");
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
	        string mypartner = msg5; // This MAY print off the person's UUID, if it does simply wrap msg5 with llKey2Name() or osKey2Name()
	        // string mypartner = llKey2Name((key)msg5); // ONLY use llKey2Name() on Second Life.
	        // string mypartner = osKey2Name((key)msg5); // use this ONLY if llKey2Name fails to display the person's name. Its a bug with Opensim.
	        string mywebsite = msg6;
	        string uname = msg7;

	        llSetTexture(fakepic, 0);
	        llSetTexture(realpic, 1);
	        llSay(0, uname + " key is " + mykey +"\n
	        	Profile of " + ownername + "\n
	        	Inworld Life: " + aboutme + "\n
	        	Real Life: " + realme + "\n
	        	Partnered with: " + mypartner + "\n
	        	Website: " + mywebsite);
		}
	}
}

// Yes it is that easy.
// Why? Because I hate complex coding, way to confusing for me so therefor would be very confusing for those who either dont know lsl or just starting out.
// K.I.S.S. > Keep It Stupidly Simple
// Also complex code just generates unneeded lag
// I just realize that this script can be used in Second Life. Great way to promote your grid in SL ;)
// just leave osKey2Name() commented and you wont get errors in SL.