<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="Reservation";
    require "./include/header.inc.php";
    require_once "./classe/Abonne.php";
    require_once "./classe/Adresse.php";
    require_once "./classe/Reservation.php";
    require_once "./classe/TabReservation.php";

?>
        
        <main>
            <?php
            if(isset($_GET['action']) && isset($_GET["item"])) {
                $reser = $_GET["item"]; 
                annuler($reser);
                header('Location: index.php');
            }           

            if(isset($_GET["item"]) && !empty( $_GET["item"] )) {
                $id_user = $_SESSION["id"];
                $reser = $_GET["item"];
                $tab = new TabReservation($id_user);
                $reservation = $tab->getOneReservation($reser);
                
                $nom_table = $reservation->getNomTable() ;
                $capacite = $reservation->getCapacite();
                $heure = $reservation->getHeure();
                $id_table = $reservation->getIdTable() ;
                $date = explode(' ',$heure)[0];
                $heure = explode(' ',$heure)[1];
                $validite = $reservation->getValidite();
                $id = $reservation->getIdReserv();
            }

            

            
echo "
<div class=\"container-xxl py-5 bg-dark hero-header mb-5\">
    <div class=\"container text-center my-5 pt-5 pb-4\">
        <h1 class=\"display-3 text-white mb-3 animated slideInDown\">Reservation</h1>    
        <p style=\"color:aliceblue\">$id</p>
    </div>
</div>
<div class=\"container-xxl py-5\">
    <div class=\"container\">
        <div class=\"text-center wow fadeInUp\" data-wow-delay=\"0.1s\">
            <h5 class=\"section-title ff-secondary text-center text-primary fw-normal\">Détails de la reservation</h5>
            
        </div>
        <div class=\"col-md-6 bg-dark d-flex align-items-center\" style=\"margin-left: 25%;\">
            <div class=\"p-5 wow fadeInUp\" data-wow-delay=\"0.2s\">
                <form action=\"traitement.php\" method=\"post\">
                    <div class=\"row g-3\">
                        <div class=\"col-md-6\">
                            <div class=\"form-floating\">
                                <input type=\"text\" class=\"form-control\" id=\"nom\" placeholder=\"votre nom\" value=\"$id\" name=\"id_reserv\" readonly/>
                                <label for=\"nom\">Identifiant</label>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"form-floating\">
                                <input type=\"text\" class=\"form-control\" id=\"prenom\" placeholder=\"votre prenom\" value=\"$nom_table\" name =\"table\" readonly/>
                                <label for=\"prenom\">Table réservée</label>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"form-floating\">
                                <input type=\"phone\" class=\"form-control\" id=\"phone\" placeholder=\"Telephone\" name=\"id_table\" value=\"$id_table\" readonly/>
                                <label for=\"phone\">ID Table</label>
                            </div>
                        </div>

                        <div class=\"col-md-6\">
                            <div class=\"form-floating\">
                                <input type=\"phone\" class=\"form-control\" id=\"phone\" placeholder=\"Telephone\" name=\"capacite\" value=\"$capacite\" readonly/>
                                <label for=\"phone\">Nombre de personnes</label>
                            </div>
                        </div>

                        <div class=\"col-md-6\">
                        ";
                        
                        if($validite == 1)
                        echo"
                        
                        <p style=\"color: aliceblue;\"><input type=\"checkbox\" id=\"pointSelectionner\" name=\"check\" value=\"selected\" class=\"checkbox\"/>  Modifier la reservation </p>
                        
                            <div class=\"form-floating\">
                                <input type=\"time\" class=\"form-control\" id=\"email\" placeholder=\"email\" placeholder=\"HH:mm\" max=\"21:00\" value=\"$heure\" name=\"time\"/>
                                <label for=\"heure\">Heure</label>
                            </div>
                        </div>

                        
                        <div class=\"col-md-6\">";
                        if($validite == 1)
                        echo "<p style=\"color: black;\"> !</p>

                            <div class=\"form-floating date\" id=\"date3\" data-target-input=\"nearest\">
                                <input class=\"form-control datetimepicker-input\" type=\"date\" id=\"date\" name=\"date\" max=\"".getDateMax()."\" min=\"".getDateDuJour()."\" value=\"$date\"/>
                                <label for=\"birthdate\">Date</label>
                            </div>
                        </div>
   

                        ";
                        if($validite == 1)
                        echo "
                        <div class=\"col-12\">
                            <button class=\"btn btn-primary w-100 py-3\" type=\"submit\">Rechercher un nouveau créneau</button>
                        </div>
                        <div class=\"col-12\">
                            <p style=\"color: aliceblue;\">Annuler votre réservation?</p>
                            <p>Cliquer sur \"Annuler votre réservation\" ci-dessous pour nous envoyer votre demande d'annulation. Une fois votre demande envoyée, vous ne pourrez plus acceder à cette réservation.</p>
                            <a href=\"reservation.php?item=$id&action=annule\"class=\"btn btn-primary w-100 py-3\" >Annuler la reservation</a>
                        </div>";

                        echo "
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>"
?>
        </main>

        <?php 
    require "./include/footer.inc.php";
?>