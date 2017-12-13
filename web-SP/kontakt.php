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
    head("KHR - kontakt");
    
    //společný kontakt pro přihlášené i nepřihlášené uživatele  
?>                  
        
        <center>
            <b>
                <h2>Kontakty</h2>
                <br><br>
                
                administrator@seznam.cz
                      
            </b>
        </center>

<?php
    // patička
    foot();
?>
             