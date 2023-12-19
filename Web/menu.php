<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="Commnader...";
    require "./include/header.inc.php";
    require_once "./classe/Carte.php";
    require_once "./classe/Boisson.php";
    require_once "./classe/Menu.php";
    require_once "./classe/Plat.php";
?>

        <main>
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Carte du restaurant</h1>
                </div>
            </div>

        <!-- Menu Start -->
        <div class="container-xxl py-5">
        <form action="traitement.php" method="post">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu</h5>
                    <h1 class="mb-5">Articles les plus populaires</h1>
                </div>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                                <i class="fa fa-coffee fa-2x text-primary"></i>
                                <div class="ps-3">
                                    <small class="text-body">Nos</small>
                                    <h6 class="mt-n1 mb-0">Boissons</h6>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                                <i class="fa fa-hamburger fa-2x text-primary"></i>
                                <div class="ps-3">
                                    <small class="text-body">Nos</small>
                                    <h6 class="mt-n1 mb-0">Plats</h6>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-3">
                                <i class="fa fa-utensils fa-2x text-primary"></i>
                                <div class="ps-3">
                                    <small class="text-body">Nos</small>
                                    <h6 class="mt-n1 mb-0">Menus</h6>
                                </div>
                            </a>
                        </li>
                    </ul>
                    
                    <?php
                        $carte = new Carte(); 
                        $tabMenu = $carte->getMenus(); 
                        $tabBoisson = $carte->getBoissons(); 
                        $tabPlat = $carte->getPlats();
                    ?>
                    
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <?php
                                    if(count($tabBoisson) != 0)
                                    for($i = 0; $i < count($tabBoisson); $i++){
                                        $boisson = $tabBoisson[$i];
                                        $nom = $boisson->getNom(); 
                                        $prix = $boisson->getPrix(); 
                                        $id_boisson = $boisson->getIdBoisson().'/'.$prix;
                                        $quantite = $boisson->getQuantiteEnCl();
                                        $image = $boisson->getImage();
                                        echo
                                        "<div class=\"col-lg-6\">
                                            <div class=\"d-flex align-items-center\">
                                                <img class=\"flex-shrink-0 img-fluid rounded\" src=\"img/menu-1.jpg\" alt=\"\" style=\"width: 80px;\">
                                                <div class=\"w-100 d-flex flex-column text-start ps-4\">
                                                    <h5 class=\"d-flex justify-content-between border-bottom pb-2\">
                                                        <span style=\"font-size:15px;\">$nom : $quantite cl</span>
                                                        <span class=\"text-primary\" style=\"font-size:15px;\">$prix &#8364;</span>
                                                    </h5>
                                                    <input type=\"checkbox\" id=\"pointSelectionner\" name=\"food[]\" value=\"$id_boisson\" class=\"checkbox\">
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                ?>
                                
                            </div>
                        </div>

                        <div id="tab-2" class="tab-pane fade show p-0">
                            <div class="row g-4">
                            <?php
                                    if(count($tabPlat) != 0)
                                    for($i = 0; $i < count($tabBoisson); $i++){
                                        $plat = $tabPlat[$i];
                                        $prix = $plat->getPrix();
                                        $id_plat = $plat->getIdPlat().'/'.$prix;
                                        $nom = $plat->getNom();  
                                        $description = $plat->getDescription();
                                        $image = $plat->getImage();
                                        echo
                                        "<div class=\"col-lg-6\">
                                            <div class=\"d-flex align-items-center\">
                                                <img class=\"flex-shrink-0 img-fluid rounded\" src=\"img/menu-1.jpg\" alt=\"\" style=\"width: 80px;\">
                                                <div class=\"w-100 d-flex flex-column text-start ps-4\">
                                                    <h5 class=\"d-flex justify-content-between border-bottom pb-2\">
                                                        <span style=\"font-size:15px;\">$nom : $description</span>
                                                        <span class=\"text-primary\" style=\"font-size:15px;\">$prix &#8364;</span>
                                                    </h5>
                                                    <input type=\"checkbox\" id=\"pointSelectionner\" name=\"food[]\" value=\"$id_plat\" class=\"checkbox\">
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                ?>

                            </div>
                        </div>

                        <div id="tab-3" class="tab-pane fade show p-0">
                            <div class="row g-4">

                                <?php
                                    if(count($tabMenu) != 0)
                                    for($i = 0; $i < count($tabMenu); $i++){
                                        $menu = $tabMenu[$i];
                                        $prix = $menu->getPrix();
                                        $id_menu = $menu->getIdMenu().'/'.$prix;
                                        $nom = $menu->getNom(); 
                                        $composition = $menu->getComposition();
                                        $image = $menu->getImage();
                                        echo
                                        "<div class=\"col-lg-6\">
                                            <div class=\"d-flex align-items-center\">
                                                <img class=\"flex-shrink-0 img-fluid rounded\" src=\"img/menu-1.jpg\" alt=\"\" style=\"width: 80px;\">
                                                <div class=\"w-100 d-flex flex-column text-start ps-4\">
                                                    <h5 class=\"d-flex justify-content-between border-bottom pb-2\">
                                                        <span style=\"font-size:15px;\">$nom : $composition</span>
                                                        <span class=\"text-primary\" style=\"font-size:15px;\">$prix &#8364;</span>
                                                    </h5>
                                                    <input type=\"checkbox\" id=\"pointSelectionner\" name=\"food[]\" value=\"$id_menu\" class=\"checkbox\">
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                ?>
           
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-6" style="width: 15%;margin-top: 10px;margin-left: 60px">
                <div class="form-floating">
                    
                    <input type="time" class="form-control" id="timeC" placeholder="timeC" name="timeC" placeholder="HH:mm" min="11:00" max="21:00" value="<?=getHeureActuelle()?>" required/>
                    <input class="form-control datetimepicker-input" style="margin-top: 10px;" type="date" id="dateC" name="dateC" max=<?=getDateMax()?>  min=<?=getDateDuJour()?> value=<?=getDateDuJour()?> required/>
                    <label for="timeC">Heure</label>
                </div>
          </div>
          <div class="col-md-6" style="width: 15%;margin-top: 10px;margin-left: 60px">
                <div class="form-floating">
                <?php
                        if(!isset($_SESSION['id']))
                        echo "
                            
                            <input type=\"text\" class=\"form-control\" id=\"nom\" placeholder=\"nom\" name =\"nom\" required/>
                            <label for=\"nom\">Nom</label>
                        ";
                    ?>
                    
                </div>
          </div>

          <div class="col-md-6" style="width: 15%;margin-top: 10px;margin-left: 60px">
                <div class="form-floating">
                <?php
                        if(!isset($_SESSION['id']))
                        echo "
                            
                            <input type=\"text\" class=\"form-control\" id=\"prenom\" placeholder=\"prenom\" name =\"prenom\" required/> 
                            <label for=\"prenom\">Prenom</label>
                        ";
                    ?>
                    
                </div>
          </div>

          <div class="col-md-6" style="width: 15%;margin-top: 10px;margin-left: 60px">
                <div class="form-floating">
                <?php
                        if(!isset($_SESSION['id']))
                        echo "
        
                            <input type=\"text\" class=\"form-control\" id=\"phone\" placeholder=\"phone\" name =\"phone\" required/>
                            <label for=\"phone\">Telephone</label>
                        ";
                    ?>
                    
                </div>
          </div>

            <input type="submit" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLef" style="margin-left: 60px;margin-right: auto; margin-top: 10px;" value="Commander"/>
            
        </form>
        </div>
    </main>
        

    <?php 
    require "./include/footer.inc.php";
?>
