<?php 
// stranka s funkci rozcestniku

// naètu základní nastavení
include("settings.inc.php");
    

// nastavím zobrazení požadované stránky
if(isset($_GET["page"]) && $_GET["page"]>=0 && $_GET["page"]<=count($web_pages)){
    $pageId = $_GET["page"];
} else {
    $pageId = 0;
}

// vypíšu zvolenou stránku
include($web_pages[$pageId].$web_pagesExtension);

?>