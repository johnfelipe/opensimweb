<?php
/*
 * Copyright (c) 2007, 2008, 2009 Contributors, http://opensimulator.org/
 * See CONTRIBUTORS for a full list of copyright holders.
 *
 * See LICENSE for the full licensing terms of this file.
 *
*/

// some stuff edited, and/or modified by Christopher Strachan to make the maps more self sustained.
// and to later be integrated into a CMS that i will also make.

##################### System #########################
define("SYSNAME","Opensim Web Map");
define("SYSURL","http://66.23.236.230/");
define("SYSMAIL","your@email.com");


$userInventoryURI="http://66.23.236.230:8003/";
$userAssetURI="http://66.23.236.230:8003/";

############ Delete Unconfirmed accounts ################
// e.g. 24 for 24 hours  leave empty for no timed delete
$unconfirmed_deltime="24";

###################### Money Settings ####################

// Key of the account that all fees go to:
$economy_sink_account="00000000-0000-0000-0000-000000000000";

// Key of the account that all purchased currency is debited from:
$economy_source_account="00000000-0000-0000-0000-000000000000";

// Minimum amount of real currency (in CENTS!) to allow purchasing:
$minimum_real=1;

// Error message if the amount is not reached:
$low_amount_error="You tried to buy less than the minimum amount of currency. You cannot buy currency for less than US$ %.2f.";

// Sets wich Pageeditor should be used:
//$editor_to_use='standard';
$editor_to_use='fckeditor';


################### GridMap Settings  #####################
//Allowing Zoom on your Map
$ALLOW_ZOOM=TRUE;

//Default StartPoint for Map
$mapstartX=8000;
$mapstartY=8000;

//Direction where Info Image has to stay ex.: dr = down right ; dl =down left ; tr = top right ; tl = top left ; c = center 
$display_marker="dr";

################ Database Tables #########################
define("C_ADMIN_TBL","admin");
define("C_WIUSR_TBL","users");
define("C_USRBAN_TBL","banned");
define("C_CODES_TBL","codetable");
define("C_ADM_TBL","adminsetting");
define("C_COUNTRY_TBL","country");
define("C_NAMES_TBL","lastnames");
define("C_CURRENCY_TBL","economy_money");
define("C_TRANSACTION_TBL","economy_transactions");
define("C_INFOWINDOW_TBL","startscreen_infowindow");
define("C_NEWS_TBL","startscreen_news");
define("C_PAGE_TBL","pagemanager");
// REGION MANAGER 
define("C_MANAGEMENT_PAGE_TBL","management_pagemanager");
define("C_MAP_REGIONS_TBL", "regions"); // dis one
// OFFLINE IM'S
define("C_OFFLINE_IM_TBL", "offline_msgs");
// STATISTICS
define("C_STATS_REGIONS_TBL", "statistics");

//OPENSIM DEFAULT TABLES (NEEDED FOR LOGINSCREEN & MONEY SYSTEM)
define("C_USERS_TBL","opensim.useraccounts"); // dis one
define("C_AGENTS_TBL","opensim.agents");
define("C_REGIONS_TBL","opensim.regions"); // dis one
define("C_APPEARANCE_TBL", "opensim.avatarappearance");

//GROUPS DEFAULT TABLES (NEEDED FOR THE GROUP PARTS)
define("G_MEMBERSHIP_TBL", "opensim.osgroupmembership");
define("G_MEMBERSHIP_ROLES_TBL", "opensim.osgrouprolemembership");
define("G_NAMES_TBL", "opensim.osgroup");
define("G_ROLES_TBL", "opensim.osgrouprole");

?>
