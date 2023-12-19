<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="Informations personnelles";
    require "./include/header.inc.php";
    require_once "./classe/Abonne.php";
    require_once "./classe/Adresse.php";

?>
        
        <main>
            <?php
                $id_user = $_SESSION["id"];
                $abonne = unserialize($_SESSION["abonne"]);
                $prenom = $abonne->getPrenom();
                $nom = $abonne->getNom();
                $mail = $abonne->getMail();
                $phone = $abonne->getTelephone();
                $date = $abonne->getDateNaissance();
                $sexe = $abonne->getSexe();
                $balance = $abonne->getBalance();
                $adresse = $abonne->getAdresse();
                $no_bat = null;
                $rue = $no_bat;
                $ville = $no_bat;
                $cd = $no_bat;
                if($adresse != null){
                    $no_bat = $adresse->getNoBat();
                    $rue = $adresse->getNomRue();
                    $ville = $adresse->getVille();
                    $cd = $adresse->getCodePostal();
                }
                echo "
                <div class=\"container-xxl py-5 bg-dark hero-header mb-5\">
                    <div class=\"container text-center my-5 pt-5 pb-4\">
                        <h1 class=\"display-3 text-white mb-3 animated slideInDown\">$prenom $nom</h1>  
                        <p style=\"color:aliceblue; font-size:20px\">Porte-feuille : $balance &#8364;</p> 
                        <a href=\"historique.php\" style=\"font-size:x-large;\">Historique des activités du compte</a>            
                    </div>
                </div>
                <div class=\"container-xxl py-5\">
                    <div class=\"container\">
                        <div class=\"text-center wow fadeInUp\" data-wow-delay=\"0.1s\">
                            <h5 class=\"section-title ff-secondary text-center text-primary fw-normal\">Détails du compte</h5>
                            <h1 class=\"mb-5\">Explorez votre compte</h1>
                        </div>
                        <div class=\"col-md-6 bg-dark d-flex align-items-center\" style=\"margin-left: 25%;\">
                            <div class=\"p-5 wow fadeInUp\" data-wow-delay=\"0.2s\">
                                <form action=\"traitement.php\" method=\"post\">
                                    <div class=\"row g-3\">
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <input type=\"text\" class=\"form-control\" id=\"nom\" placeholder=\"votre nom\" value=\"$nom\" readonly/>
                                                <label for=\"nom\">Nom</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <input type=\"text\" class=\"form-control\" id=\"prenom\" placeholder=\"votre prenom\" value=\"$prenom\" readonly/>
                                                <label for=\"prenom\">Prenom</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <input type=\"phone\" class=\"form-control\" id=\"phone\" placeholder=\"Telephone\" value=\"$phone\" readonly/>
                                                <label for=\"phone\">Numéro de téléphone</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating date\" id=\"date3\" data-target-input=\"nearest\">
                                                <input class=\"form-control datetimepicker-input\" type=\"date\" id=\"date\" name=\"date\" max=\"9999-12-31\" min=\"2005-01-01\" value=\"$date\" readonly/>
                                                <label for=\"birthdate\">Date de naissance</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <input type=\"text\" class=\"form-control\" id=\"email\" placeholder=\"email\" value=\"$mail\" readonly/>
                                                <label for=\"email\">Mail</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <input type=\"text\" class=\"form-control\" id=\"email\" placeholder=\"email\" value=\"$sexe\" readonly/>
                                                <label for=\"select1\">Sexe</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                                <p style=\"color: aliceblue;\">Adresse </p>
                                                <div class=\"form-floating\">
                                                    <input type=\"text\" class=\"form-control\" id=\"email\" placeholder=\"email\" value=\"$no_bat\" readonly/>
                                                    <label for=\"email\">Numero de Batiment</label>
                                                </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                                <p style=\"color: black;\"> !</p>
                                                <div class=\"form-floating\">
                                                    <input type=\"text\" class=\"form-control\" id=\"email\" placeholder=\"email\" value=\"$rue\" readonly/>
                                                    <label for=\"email\">Nom de rue</label>
                                                </div>
                                        </div>

                                        <div class=\"col-md-6\">
                                                <div class=\"form-floating\">
                                                    <input type=\"text\" class=\"form-control\" id=\"email\" placeholder=\"email\" value=\"$ville\" readonly/>
                                                    <label for=\"email\">Ville</label>
                                                </div>
                                        </div>

                                        <div class=\"col-md-6\">
                                                <div class=\"form-floating\">
                                                    <input type=\"text\" class=\"form-control\" id=\"email\" placeholder=\"email\" value=\"$cd\" readonly/>
                                                    <label for=\"email\">Code postal</label>
                                                </div>
                                        </div>

                                    </div>
                                </form>

                                <a href=\"traitement.php?action=logout\" class=\"btn btn-primary w-100 py-3\" style=\"margin-top: 20px;\"> Se deconnecter </a>
                            </div>
                        </div>
                    </div>
                </div>"
            ?>
        </main>

        <?php 
    require "./include/footer.inc.php";
?>