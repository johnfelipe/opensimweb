<?php
define('OSW_IN_SYSTEM', true);
require_once('../inc/header.php');
?>
Open this page in a html editor,<br>
Add the three lines of code below into any html page and set where oswapi.js is at on the computer<br>
It is usually in the api folder of opensimweb<br>
And away you go, ill add more to the system soon with better improvements.<br>
For now for testings and learning i just quickly wrote it in javascript.<br>
ENJOY!<br>
<div id="UsersOnline"></div>
<div id="TotalUsers"></div>
<script type="application/javascript" src="oswapi.js"></script>
<?php
include('../inc/footer.php');
?>