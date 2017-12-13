<?php 
    // načtení souboru s funkcemi 
    include("database.class.php");
    $PDOObj = new Database();

 
    // načtení hlavičky stránky
    if(!$PDOObj->isUserLoged()){
        include("zaklad.php");
    }else{
        include("zakladP.php");
    }
    head("KHR - školení");


    
    
    // nepřhlášený uživatel
    if(!$PDOObj->isUserLoged()){ 
            
?>       
        <center>
        <h2>Školení</h2>
        <br><br>
            <b>K navštívení obsahu této stránky je nutné se nejdříve <a href="prihlaseni">přihlásit</a>.</b>           
        </center>
        
<?php
    // přihlášený uživatel
    } else {              
?> 

        <center>
            <b><h2>Školení</h2> </b>
            <br><br>
            Datum školení bude upřesněn.
        </center>
        
<?php               
    }

    // patička
    foot();
?>
              