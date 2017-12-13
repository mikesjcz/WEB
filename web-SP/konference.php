<?php 
    // načtení souboru s funkcemi 
    include("database.class.php");
    $PDOObj = new Database();

 
    // nacteni hlavičky stránky
    if(!$PDOObj->isUserLoged()){
        include("zaklad.php");
    }else{
        include("zakladP.php");
    }
    
    // jméno stránky
    head("Konference hokejových rozhodčích");
    
    // nepřhlášený uživatel
    if(!$PDOObj->isUserLoged()){       
?>                    
      
        <center>
        
    <b><h2>Vítejte ná stránkách  konference hokejových rozhodčích.</h2> </b>           
        </center>
                             
<?php
    // přihlášený uživatel
    } else {               
?>    
                
        <center>
           
            
            <b><h2>Vítejte na stránkách konference hokejových rozhodčích.</h2> </b>
                <br><br>
            
             Jako přihlášený uživatel máte možnost přidávat nové články a naopak číst články ostatních uživatelů.
        </center>
        
<?php             
    }

    // patička
    foot();
?>
                  