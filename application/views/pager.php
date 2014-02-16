<?php
echo <<< OUT
			<div align="center" style="margin-top: 30px; width: 980px; margin-left: auto; margin-right: auto; padding-bottom: 60px;">
OUT;
/*
		if(($currentPage != 1) && ($currentPage > 1000)) echo '
			<button style="background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'. ($currentPage - 1000) .'\';"
			>&#9668;1000</button> 
		';
	
		if(($currentPage != 1) && ($currentPage > 100)) echo '
			<button style="background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'. ($currentPage - 100) .'\';"
			>&#9668;100</button> 
		';
	
		if(($currentPage != 1) && ($currentPage > 10)) echo '
			<button style="background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'. ($currentPage - 10) .'\';"
			>&#9668;10</button> 
		';
			if(($currentPage != 1) && ($numberOfPages > 10)) echo '
			<button style="background-color: #009a9a; color: white; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'. $previousPage .'\';"
			>&#9668;</button> 
		';
		else echo '
			<button style="background-color: #009a9a; color: white; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			> <b style="font-family: Georgia;">H</b> </button> 
		';


		if($numberOfPages < 10)
		{
			$startPage = 1;
			$lastPage = $numberOfPages;
		}
		else if(($currentPage + 6) > $numberOfPages)
		{
			$startPage = $numberOfPages - 10;
			$lastPage = $numberOfPages;
		}
		else if($currentPage < 6)
		{
			$startPage = 1;
			$lastPage = $currentPage + (10 - $currentPage);
		}
		else
		{
			$startPage = $currentPage -4;
			$lastPage = $currentPage + 4;
		}


		for($pn=$startPage;$pn <= $lastPage;$pn++)
		{
			if($pn == $currentPage) echo '<a style="color: #f95a19;" href="'.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'.$pn.'"> <span style="font-family: Georgia; padding: 3px; background-color: #f95a19; color: #ffffff;"> '.$pn.' </span> </a> ';
			else echo '<a href="'.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'.$pn.'"> <span style="font-family: Georgia; padding: 3px;"> '.$pn.' </span></a> ';
		}

		if(($currentPage != $numberOfPages) && ($numberOfPages > 10)) echo '
			&nbsp;<button style="background-color: #009a9a; color: white; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'.$nextPage.'\';"
			>&#9658;</button> 
		';
		else if(($currentPage == $numberOfPages) || ($numberOfPages < 10)) echo '
			&nbsp;<button style="background-color: #009a9a; color: white; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			> <em style="font-family: Georgia;">s</em> </button> 
		';

		if(($currentPage != $numberOfPages) && (($numberOfPages - $currentPage) > 10)) echo '
			<button style="background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'. ($currentPage + 10) .'\';"
			>10&#9658;</button> 
		';

		if(($currentPage != $numberOfPages) && (($numberOfPages - $currentPage) > 100)) echo '
			<button style="background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'. ($currentPage + 100) .'\';"
			>100&#9658;</button> 
		';

		if(($currentPage != $numberOfPages) && (($numberOfPages - $currentPage) > 1000)) echo '
			<button style="background-color: #009a9a; color: white; font-size: 11px; font-weight: bold; border-collapse: collapse; border: 1px solid #009a9a;"
			onclick="location.href=\''.$siteUrl.'search/searchResults/'.$searchType.'/'.$keyword.'/'. ($currentPage + 1000) .'\';"
			>1000&#9658;</button> 
		';
*/
		echo '
			</div>
				<div id="pagination" class="pagination">'. $pagination.'</div>
				
			<!--
			<div style="clear: both; padding-bottom: 50px; margin-top: 10px; width: 900px;">
				<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
				<fb:like show_faces="false" width="800" action="recommend" font="verdana"></fb:like>
			</div>
			-->
		';
?>
