<?php
$page_title = "User Settings";
define('OSW_IN_SYSTEM', true);
require_once('inc/header.php');

if ($user) {
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
  <li><a href="#profile" data-toggle="tab">Profile</a></li>
  <li><a href="#messages" data-toggle="tab">Messages</a></li>
  <li><a href="#inv" data-toggle="tab">Inventory</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

  <div class="tab-pane active" id="settings">
<?php

?>
  </div>

  <div class="tab-pane" id="profile">
<?php

?>
  </div>

  <div class="tab-pane" id="messages">
<?php

?>
  </div>

  <div class="tab-pane" id="inv">
  	<table class='table'>
  		<thead>
  			<tr>
  				<th>Folder/Item name</th>
  				<th>Type</th>
  				<th>Action</th>
  			</tr>
  		</thead>
  		<tbody>
  		<?php
 		$ifq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.InventoryFolders WHERE agentID = '$user_uuid' ORDER BY `folderName` ASC LIMIT 0,100");
 		while ($ifr = $osw->SQL->fetch_array($ifq)) {
 			$folderName = $ifr['folderName'];
 			$folderID = $ifr['folderID'];
      if ($folderName == "Trash") {
        $fbuttons = "<input type='submit' name='emptytrash' value='Empty Trash' class='btn btn-primary'>";
      }else{
        $fbuttons = "<input type='submit' name='movefolder' value='Move Folder' class='btn btn-primary'>";
      }
echo "
    <tr>
      <td>".$folderName."</td>
      <td></td>
      <td>".$fbuttons."</td>
    </tr>
    ";
 			$iiq = $osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.InventoryItems WHERE parentFolderID = '$folderID' ORDER BY `inventoryName` ASC LIMIT 0,100");
      $iin = $osw->SQL->num_rows($iiq);
      if ($iin) {
        while ($iir = $osw->SQL->fetch_array($iiq)) {
          $invName = $iir['inventoryName'];
          $invDesc = $iir['inventoryDescription'];
          $invType = $iir['invType'];
          if ($invName == "") {
            $ibuttons = "<input type='submit' name='emptytrash' value='Empty Trash' class='btn btn-primary'>";
          }else{
            $ibuttons = "<input type='submit' name='moveitem' value='Move Item' class='btn btn-primary'>";
          }
          echo "
           <tr>
             <td> - ".$invName."</td>
             <td></td>
             <td>".$ibuttons."</td>
          </tr>
          ";
        }
      }else{

      }

 		}
  		?>
  		</tbody>
  	</table>
  </div>

</div>

<?php
}
include ('inc/footer.php');
?>