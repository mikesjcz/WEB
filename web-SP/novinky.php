  <?php 
    // načtení souboru s funkcemi 
    include("database.class.php");
    $PDOObj = new Database();

 
    // nactení hlavičky stránky
    if(!$PDOObj->isUserLoged()){
        include("zaklad.php");
    }else{
        include("zakladP.php");
    }
    
    //jméno stránky
    head("KHR - novinky");

    // nepřhlášený uživatel
    if(!$PDOObj->isUserLoged()){ 
      
?>       

        <center>
            <b>
                <h2>Novinky</h2>
            </b>           
        </center>
        
 <?php

    //přihlášený uživatel
    } else {
               
?> 
        <center>
            <b>
                <h2>Novinky</h2>
            </b>
                
            <br>
            <a href="index.php?page=10">Vložit nový článek.</a>.  
        </center>
        
<?php
               
    }
?>
    <br><br>
   <center>
      <table border="0">
<?php  
                // zobrazení článků        
                $clanky = $PDOObj->allClankyInfo();
                      foreach($clanky as $u){
                          if($u["schvaleno"]==1){
                              echo "<tr>
                                        <td>&nbspNázev:&nbsp</td>
                                        <td>&nbsp$u[nazev]&nbsp</td>
                                    </tr>
                                    <tr>
                                        <td>&nbspAutoři:&nbsp</td>
                                        <td>&nbsp$u[autori]&nbsp</td>
                                    </tr>
                                    <tr>
                                        <td>&nbspAbstract:&nbsp</td>
                                        <td>&nbsp$u[clanek]&nbsp</td>
                                    </tr>
                                    <tr>
                                        <td>&nbspPdf:&nbsp</td>
                                        <td>&nbsp<a href='soubory/$u[pdf]'>$u[pdf]</a>&nbsp</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp&nbsp</td>
                                        <td>&nbsp&nbsp</td>
                                    </tr>";
                        }
                    }
?>            
           </table>  
       </center>

<?php
    // patička
    foot();
?>
              