<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="Commande";
    require "./include/header.inc.php";
    require_once "./classe/Plat.php";
    require_once "./classe/Menu.php";
    require_once "./classe/Boisson.php";
    require_once "./classe/Commande.php";

?>
        
        <main>
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Commande</h1>
                </div>
            </div>
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom:25px;">
                        <h5 class="section-title ff-secondary text-center text-primary fw-normal">Commandes</h5>
                    </div>
                    <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                        
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    <?php
                                    if(isset($_GET["item"])){
                                        $id_commande = $_GET["item"];
                                        $commande = new Commande($id_commande);
                                        $heure = $commande->getHeure();
                                        $numero = $commande->getSolde();

                                        echo "
                                            <span style=\"margin-left:0px;\"><b>Identifiant de la commande : $id_commande</b></span>\n
                                            <span style=\"margin-left:0px;\"><b>Solde : $numero euros</b></span>\n
                                        ";

                                        $tabBoisson = $commande->getBoissons();
                                        $tabPlat = $commande->getPlats();
                                        $tabMenu = $commande->getMenus();

                                        $n = count($tabBoisson);
                                        if ($n != 0) 
                                        for ($i = 0; $i < $n; $i++){
                                            $rsrv = $tabBoisson[$i];
                                            $prix = $rsrv->getPrix();
                                            $nomBoisson = $rsrv->getNom();
                                            $quantite = $rsrv->getQuantiteEnCl();
                                            echo "
                                            <div class=\"col-lg-6\">
                                                <div class=\"d-flex align-items-center\">
                                                    <img class=\"flex-shrink-0 img-fluid rounded\" src=\"img/menu-1.jpg\" alt=\"\" style=\"width: 80px;\"/>
                                                    <div class=\"w-100 d-flex flex-column text-start ps-4\">
                                                        <h5 class=\"d-flex justify-content-between border-bottom pb-2\">
                                                            <span style=\"font-size:15px;\"> $nomBoisson </span>
                                                            <span class=\"text-primary\" span style=\"font-size:15px;\">$prix euros</span>                                                           
                                                        </h5>
                                                        <span>$quantite CL</span>
                                                    </div>
                                                </div>
                                            </div>";
                                        }

                                        $n = count($tabPlat);
                                        if ($n != 0) 
                                        for ($i = 0; $i < $n; $i++){
                                            $rsrv = $tabPlat[$i];
                                            $prix = $rsrv->getPrix();
                                            $nomBoisson = $rsrv->getNom();
                                            $quantite = $rsrv->getDescription();
                                            echo "
                                            <div class=\"col-lg-6\">
                                                <div class=\"d-flex align-items-center\">
                                                    <img class=\"flex-shrink-0 img-fluid rounded\" src=\"img/menu-1.jpg\" alt=\"\" style=\"width: 80px;\"/>
                                                    <div class=\"w-100 d-flex flex-column text-start ps-4\">
                                                        <h5 class=\"d-flex justify-content-between border-bottom pb-2\">
                                                            <span style=\"font-size:15px;\"> $nomBoisson </span>
                                                            <span class=\"text-primary\" span style=\"font-size:15px;\">$prix euros</span>                                                           
                                                        </h5>
                                                        <span>$quantite CL</span>
                                                    </div>
                                                </div>
                                            </div>";
                                        }

                                        $n = count($tabMenu);
                                        if ($n != 0) 
                                        for ($i = 0; $i < $n; $i++){
                                            $rsrv = $tabMenus[$i];
                                            $prix = $rsrv->getPrix();
                                            $nomMenu = $rsrv->getNom();
                                            
                                            echo "
                                            <div class=\"col-lg-6\">
                                                <div class=\"d-flex align-items-center\">
                                                    <img class=\"flex-shrink-0 img-fluid rounded\" src=\"img/menu-1.jpg\" alt=\"\" style=\"width: 80px;\"/>
                                                    <div class=\"w-100 d-flex flex-column text-start ps-4\">
                                                        <h5 class=\"d-flex justify-content-between border-bottom pb-2\">
                                                            <span style=\"font-size:15px;\"> $nomMenu </span>
                                                            <span class=\"text-primary\" span style=\"font-size:15px;\">$prix</span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>";
                                        }

                                    }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

<?php 
    require "./include/footer.inc.php";
?>