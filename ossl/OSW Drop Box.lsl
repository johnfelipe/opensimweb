string url = "http://address2osw/ossl/marketbox.php?"; // web address to the php file to handle this dropbox's data, usually where you installed OSW.
key owner;
string ownername;
string primname;
string primemail = "messages@littletech.net"; //Email address where messages to in world prims will come from.
key primkey;
vector pos;
string sim;
integer invcount;

integer updatercounter = 120;
integer updaterticker;

key http_insert_inv;
key http_rez;

settextmsg(string msg)
{
    invcount = llGetInventoryNumber(INVENTORY_ALL);
    if (msg == "default") {
        llSetText(primname + "\n" + (string)invcount + " total items.", <1.0,1.0,1.0>, 1.0);
    }else{
        llSetText(msg, <1.0,0.0,0.0>, 1.0);
    }
}

updater()
{
    http_rez = llHTTPRequest(url + "type=rez&primkey=" + llEscapeURL((string)primkey) + "&owner=" + llEscapeURL(ownername) + "&sim=" + llEscapeURL(sim) + "&pos=" + llEscapeURL((string)pos), [HTTP_METHOD, "GET"], "");
}

default
{
    state_entry()
    {
        owner = llGetOwner();
        primname = llGetObjectName();
        primkey = llGetKey();
        pos = llGetPos();
        sim = llGetRegionName();
        llSetTimerEvent(1.0);
        ownername = llKey2Name(owner);
        updater();
        settextmsg("default");
        updater();
    }
    
    changed(integer c)
    {
        if (c & CHANGED_INVENTORY)
        {
            integer i = 0;
            invcount = llGetInventoryNumber(INVENTORY_ALL);
            for(i; i < invcount; i++)
            {
                string itemname = llGetInventoryName(INVENTORY_ALL, i);
                integer itemtype = llGetInventoryType(itemname);
                http_insert_inv = llHTTPRequest(url + "type=insertitems&primkey=" + llEscapeURL((string)primkey) + "&itemname=" + llEscapeURL(itemname) + "&itemtype=" + llEscapeURL((string)itemtype) + "&owner=" + llEscapeURL(ownername), [HTTP_METHOD, "GET"], "");
            }
        }
        settextmsg("default");
    }
    
    http_response(key request_id, integer status, list metadata, string body)
    {
        if (request_id == http_insert_inv)
        {
            if (body == "saved") {
            }else if (body == "alreadysaved") {
            }else if (body == "fail") {
                // Ignore this. This just sends Christina Vortex a IM letting her know that she needs to fix something on the server.
                llInstantMessage("b6ed5a8c-b0ec-41cc-9313-7225a3e28611", "Yo theres a error from the server with saving drop box inventory. Fix it fuck face.");
            }else{
                // Same with here too.
                llInstantMessage("b6ed5a8c-b0ec-41cc-9313-7225a3e28611", "Yo fuck face. Something else came back from the server when saving inventory. FIX IT SHITHEAD! Message is:\n" + body);
            }
        }
        
        if (request_id == http_rez)
        {
            if (body == "rezzed") {
            }else if (body == "alreadyrezzed") {
            }else if (body == "fail") {
                // Ignore this. This just sends Christina Vortex a IM letting her know that she needs to fix something on the server.
                llInstantMessage("b6ed5a8c-b0ec-41cc-9313-7225a3e28611", "Yo theres a error from the server with rezing drop box. Fix it fuck face.");
            }else{
                // Same with here too.
                llInstantMessage("b6ed5a8c-b0ec-41cc-9313-7225a3e28611", "Yo fuck face. Something else came back from the server when rezzing. FIX IT SHITHEAD! Message is:\n" + body);
            }
        }
    }
    
    email(string time, string address, string subj, string message, integer num_left)
    {
        if (address == primemail && subj == "SENDINV")
        {
            list emaillist = llParseString2List(llUnescapeURL(message), ["="], []);
            string msg0 = llList2String(emaillist, 0);
            string msg1 = llList2String(emaillist, 1);
            string msg2 = llList2String(emaillist, 2);
            string msg3 = llList2String(emaillist, 3);
        
            if (msg0 == "GIVEINV")
            {
                key destination = (key)msg1;
                llGiveInventory(destination, msg2);
                settextmsg("Sending " + msg2 + " to " + llKey2Name(destination));
            }
        }
        
        if (num_left) {
            settextmsg("Getting next email.");
            llGetNextEmail("", "");
        }else{
            settextmsg("default");
        }
    }
    
    timer()
    {
        //This keeps checking to see if there are any emails for this prim.
        llGetNextEmail("", "");
        updaterticker++;
        if (updaterticker == updatercounter)
        {
            updater();
            updaterticker = 0;
        }
    }
}