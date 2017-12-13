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
    head("KHR - pravidla");
    
    // pravidla pro přihlášené i nepřihlášené uživatele   
?>     

        <center>
            <h2>Pravidla</h2>
            <br><br>
            Tyto stránky slouží k předávání informací mezi registrovanými uživateli. Pokud bude uživatel opakovaně vkládat nevhodný obsah, může to vést k jeho smazání.  
            
        </center>
        
<?php
    // patIčka
    foot();
?>
             