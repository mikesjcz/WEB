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
    
    // jméno stránky
    head("KHR - odkazy");

    // nepřihlášený uživatel
    if(!$PDOObj->isUserLoged()){
           
?>       
        <center>
            <h2>Odkazy</h2><br>
            K navštívení obsahu této stránky je nutné se nejdříve <a href="index.php?page=0">přihlásit</a>.
        </center>    
        
<?php
    // přihlášený uživatel
    } else {
               
?>  
   
        <center>
            <h2>Pro doplňující informace můžete navštívit tyto stránky:</h2><br>
    
            <a href="http://jihoceskykraj.cslh.cz/">Český svaz ledního hokeje jihočeského kraje</a> 
            <br><br>
      
            <a href="http://www.jchokej.cz/">JIHOČESKÝ HOKEJ portál pro hokejové fanouškz v kraji</a>
            <br><br>
        
            <a href="https://www.hosys.cz/Uvodni-slovo.htm">Český svaz ledního hokeje HoSys</a>   
        </center>
        
<?php            
    }

    // patička  
    foot();
?>
              