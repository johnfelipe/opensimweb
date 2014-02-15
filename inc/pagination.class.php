<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

class pagination
{

var $osw;

function pagination(&$osw)
{
	$this->osw = &$osw;
}

function paging($tbl_name, $targetpage, $limit) {

	// How many adjacent pages should be shown on each side?
	$adjacents = 1;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = $this->osw->SQL->query("SELECT COUNT(*) AS num FROM $tbl_name");
	$total_pages = $this->osw->SQL->fetch_assoc($query);
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */

	$page = $_GET['page'];
	if($page) {
		$start = ($page - 1) * $limit; 			//first item to display on this page
	}else{
		$start = 0;								//if no page var is given, set start to 0
	}

	/* Get data. */
	$sql = "SELECT * FROM $tbl_name LIMIT $start, $limit";
	$result = $this->osw->SQL->query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) { $page = 1; }					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"pagination pagination-lg\">";
		//previous button
		if ($page > 1) {
			$pagination.= "<li><a href=\"$targetpage&page=$prev\">&laquo; prev</a></li>";
		}else{
			$pagination.= "<li class=\"disabled\"><a href=\"#\">&laquo; prev</a></li>";
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
				else
					$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
			}
		}
		else if($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			else if($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$targetpage&page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=2\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$targetpage&page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage&page=2\">2</a></li>";

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"$targetpage&page=$counter\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) {
			$pagination.= "<li><a href=\"$targetpage&page=$next\">next &raquo;</a></li>";
		}else{
			$pagination.= "<li class=\"disabled\"><a href=\"#\">next &raquo;</a></li>";
		}
		$pagination.= "</ul>\n";		
	}
return $pagination;
}

}
?>