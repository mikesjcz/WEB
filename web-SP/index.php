<?php 
// stranka s funkci rozcestniku

// na�tu z�kladn� nastaven�
include("settings.inc.php");
    

// nastav�m zobrazen� po�adovan� str�nky
if(isset($_GET["page"]) && $_GET["page"]>=0 && $_GET["page"]<=count($web_pages)){
    $pageId = $_GET["page"];
} else {
    $pageId = 0;
}

// vyp�u zvolenou str�nku
include($web_pages[$pageId].$web_pagesExtension);

?>