<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class site {

var $osw;

	function site(&$osw) {
	$this->osw = &$osw;
	}

	function time2date($time) {
	$r = date('M d Y g:ia T', $time);
	return $r;
	}

	function getage($then) {
	$then = date('Ymd', strtotime($then));
	$diff = date('Ymd') - $then;
	return substr($diff, 0, -4);
	}

	function avg($currentcount, $totalcount) {
	$count1 = $currentcount / $totalcount;
	$count = $count1 * 100;
	return $count;
	}

	function ago($tm) {
	    $rcs = time();
	    $cur_tm = time();
	    $dif = $cur_tm-$tm;
	    $pds = array('second','minute','hour','day','week','month','year','decade');
	    $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
	    for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
   
	    $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
	    if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
	    return $x;
	}

	function banners($type) {
		$offset_result = $this->osw->SQL->query("SELECT FLOOR(RAND() * COUNT(*)) AS `offset` FROM `bannerads` WHERE type = '$type'");
		$offset_row = $this->osw->SQL->fetch_object($offset_result);
		$offset = $offset_row->offset;
		$result = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}bannerads` WHERE type = '$type' LIMIT $offset, 1");
		$row = $this->osw->SQL->fetch_array($result);
		$id = $row['id'];
		$linkurl = $row['linkurl'];
		$imgurl = $row['imgurl'];
		$alt = $row['alt'];
		$code = $row['code'];

		if ($type == "h") {
		$style = "max-width: 1000px; max-height: 100px;";
		}else if ($type == "v") {
		$style = "max-width: 100px; max-height: 800px;";
		}else if ($type == "b") {
		$style = "max-width: 300px; max-height: 300px;";
		}
			if (!$code) {
			$return = "<a href='$linkurl' target='_blank'><img src='$imgurl' border='0' alt='$alt' style='$style'></a>";
			}else if ($code) {
			$return = "$code";
			}
	return $return;
	}

	function useronline($uuid, $address) {
	$q = $this->osw->SQL->query("SELECT * FROM `{$osw->config['robust_db']}`.GridUser WHERE UserID = '$uuid'");
	$r = $this->osw->SQL->fetch_array($q);
	$l = $r['Online'];
		if ($online == True) {
		$o = "<img src='$address/img/onlinedot.png' border='0'>";
		}else if ($online == False) {
		$o = "<img src='$address/img/offlinedot.png' border='0'>";
		}
	return $o;
	}

	function getnewuuid($input) {
	$uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
		mt_rand( 0, 0x0fff ) | 0x4000,
		mt_rand( 0, 0x3fff ) | 0x8000,
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
	return $uuid;
	}

	function randcode($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ';
		for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, (strlen($characters)-1))];
		}
	return $string;
	}

	function commentcount($type, $tid) {
	$cq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}comments` WHERE type = '$type' AND tid = '$tid'");
	$count = $this->osw->SQL->num_rows($cq);
	return $count;
	}

	// needs to be fixed for better customization
	function sendemail($remail, $esubject, $emessage) {
	$headers = "From: ".$this->osw->config['SiteEmail'];
	$emailsent = @mail($remail, $esubject, $emessage, $headers);
		if ($emailsent) {
		$return = TRUE;
		}else{
		$return = FALSE;
		}
	return $return;
	}

	function disqus($page, $id, $title) {
	$address = $this->osw->config['SiteAddress'];
	$return = "<div id=\"disqus_thread\"></div>
    <script type=\"text/javascript\">
        var disqus_shortname = '".$osw->config['DisqusShortName']."';
    	 var disqus_url = '".$address."/".$page."".$id."';
        var disqus_identifier = '".$id." ".$address."/".$page."".$id."';
        var disqus_container_id = 'disqus_thread';
        var disqus_domain = 'disqus.com';
        var disqus_title = '".$title."';

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href=\"http://disqus.com/?ref_noscript\">comments powered by Disqus.</a></noscript>
    <a href=\"http://disqus.com\" class=\"dsq-brlink\">comments powered by <span class=\"logo-disqus\">Disqus</span></a>";
	return $return;
	}

	function selectcomments($page, $id, $title) {
	$disqus = $this->disqus($page, $id, $title);
	$return = "
<ul class='nav nav-tabs'>
  <li><a href='#ltc' data-toggle='tab'>".$this->osw->config['GridName']."</a></li>
  <li class='active'><a href='#disqus' data-toggle='tab'>Disqus</a></li>
</ul>
<div class='tab-content'>
  <div class='tab-pane fade' id='ltc'>OpenSimWeb's own commenting system coming soon</div>
  <div class='tab-pane fade in active' id='disqus'>".$disqus."</div>
</div>
";
	return $return;
	}

	function getNews($id, $style = "") {
		if ($id == "0") {
			$where = "ORDER BY `time` DESC LIMIT 0, 10";
		}else{
			$where = "WHERE id = '$id'";
		}
		echo "
		<div class='table-responsive'>
  			<table class='table table-condensed ".$style."'>
  				<tr>
  					<td>
  					";
  						$newsq = $this->osw->SQL->query("SELECT * FROM `{$this->osw->config['db_prefix']}news` $where");
  						while ($r = $this->osw->SQL->fetch_array($newsq)) {
  							$nid = $r['id'];
  							$title = $r['title'];
  							$msg = $r['msg'];
  							$time = $r['time'];
  							$poster = $r['poster'];
  							$date = $this->time2date($time);
  							$postername = $this->osw->id_to_username($poster);
  							if ($id == "0") {
  								echo "
  								<h4><a href='".$this->osw->config['SiteAddress']."/news.php?id=".$nid."'>".$title."</a></h4><small>".$date."</small><br><hr><br>
  								";
  							}else{
  								echo "
  								<p><h3>".$title."</h3>".$msg."<br><small>Posted by ".$postername." on ".$date."</small></p>
  								";
  							}
  						}
  						if ($id == "0") {
						}else{
							echo "<p>".$this->selectcomments('news.php?id=', $id, $title)."</p>";
						}
  						echo "
  					</td>
  				</tr>
  			</table>
  		</div>";
	}
}
?>