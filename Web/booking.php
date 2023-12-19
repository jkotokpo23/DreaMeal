<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="Reservation";
    require "./include/header.inc.php";
    require_once "./classe/availableTable.php"
?>
    <main>
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Reservations</h1>
            </div>
        </div>
        <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-0">
                
                <div class="col-md-6 bg-dark d-flex align-items-center" style="margin-left: auto;margin-right: auto;">
                    <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservation</h5>
                        <h1 class="text-white mb-4">Reserver votre table</h1>
                        <?php 
                        
                    

                        if(isset($_GET["time"]) && isset($_GET["capacite"]) ){
                            
                            $time = toTimestamp($_GET["time"]);
                            $capacite = (int)$_GET["capacite"];
                            $tables = new AvailableTable($time, $capacite); 
                            $arrayTable = $tables->getAvalaibleTables();
                            
                           

                            echo "<div class=\"tab-content\">
                            <div id=\"tab-1\" class=\"tab-pane fade show p-0 active\">
                            <form action=\"traitement.php\" method=\"get\">
                                <div class=\"row g-4\" style=\"width:100%\">";
                                if(count($arrayTable) !=0){
                                    for($i = 0; $i < count($arrayTable); $i++){
                                        $tab = $arrayTable[$i];
                                        $nom = $tab->getNom();
                                        $capacite = $tab->getCapacite();
                                        $id_table = $tab->getIdTable();
                                        
                                       
                                        echo "<div class=\"col-lg-6\" style=\"width: 100%;\">
                                            <div class=\"d-flex align-items-center\">
                                                <img class=\"flex-shrink-0 img-fluid rounded\" src=\"img/menu-1.jpg\" alt=\"\" style=\"width: 80px;\"/>
                                                <div class=\"w-100 d-flex flex-column text-start ps-4\">
                                                    <h5 class=\"d-flex justify-content-between border-bottom pb-2\">
                                                        <span class=\"text-primary\">$nom pour $capacite personnes</span>
                                                    </h5>";
                                                        if(isset($_GET['reserve'])){
                                                            echo"<input type=\"radio\"  name=\"pick\" value=\"$id_table|$time|".$_GET['reserve']."\" class=\"checkbox\" required/>";
                                                        }
                                                        else{
                                                            echo"<input type=\"radio\"  name=\"pick\" value=\""."$id_table|$time\" class=\"checkbox\" required/>";
                                                        }
                                                echo "</div>

                                            </div>
                                        </div>";
                                    }
                                }
                                // if(!isset($_GET['reserve']))
                                //     $link = "<a href=\"traitement.php?table=$id_table&cap=$capacite&time=$time\" class=\"btn btn-primary w-100 py-3\">Valider</a>";
                                // else
                                    $link = "<input type=\"submit\" value=\"Valider\" class=\"btn btn-primary w-100 py-3\"/> ";
                                if(!isset($_SESSION['id']))
                                echo "
                                        <div class=<\"col-md-6\">
                                            <div class=\"form-floating\" >
                                                <input type=\"text\" class=\"form-control\" id=\"nom\" name=\"nom\" placeholder=\"votre nom\" required/>
                                                <label for=\"nom\">Nom</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <input type=\"text\" class=\"form-control\" id=\"prenom\" name=\"prenom\" placeholder=\"votre prenom\" required/>
                                                <label for=\"prenom\">Prenom</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <input type=\"phone\" class=\"form-control\" id=\"phone\" name=\"phone\" placeholder=\"Telephone\" required/>
                                                <label for=\"phone\">Votre numéro</label>
                                            </div>
                                        </div>
                                        <div class=\"col-12\">
                                            <div class=\"form-floating\">
                                                <textarea class=\"form-control\" placeholder=\"Special Request\" id=\"message\" name=\"plus\" style=\"height: 100px\"></textarea>
                                                <label for=\"message\">Plus</label>
                                            </div>
                                        </div>
                                    ";

                                if(count($arrayTable) != 0)
                                echo "</div>
                                    <div class=\"col-12\" style=\"margin-top: 15px\">
                                    <p style=\"color:white;\">En cliquant sur le bouton, vous confirmer votre reservation pour ce créneau</p>
                                        $link
                                    </div>";
                                    else 
                                echo"
                                    <div class=\"col-12\" style=\"margin-top: 15px\">
                                        <p style=\"color:white;\">Aucune table disponible pour ce créneau</p>
                                    </div>";
                                echo "
                                </form>
                            </div>
                        </div>
                        ";
                        }else{
                            if(!isset($_SESSION["id"]) && !isset($_GET["time"]) && !isset($_GET["capacite"])){
                                echo ("<form>
                                    <div class=\"row g-3\">
                                        
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating date\" id=\"date3\" data-target-input=\"nearest\">
                                                <input type=\"text\" class=\"form-control datetimepicker-input\" id=\"datetime\" placeholder=\"Date & Time\" data-target=\"#date3\" data-toggle=\"datetimepicker\" name=\"time\" required/>
                                                <label for=\"datetime\">Jour & Heure</label>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"form-floating\">
                                                <select class=\"form-select\" id=\"select1\" name=\"capacite\" required/>
                                                    <option value=\"1\">1</option>
                                                    <option value=\"2\">2</option>
                                                    <option value=\"3\">3</option>
                                                    <option value=\"4\">4</option>
                                                    <option value=\"5\">5</option>
                                                    <option value=\"6\">6</option>
                                                    <option value=\"7\">7</option>
                                                </select>
                                                <label for=\"select1\">Nombre de personnes</label>
                                            </div>
                                        </div>
                                        
                                        <div class=\"col-12\">
                                            <button class=\"btn btn-primary w-100 py-3\" type=\"submit\">Rechercher...</button>
                                        </div>
                                    </div>
                                </form>");
                            }else{
                                if(isset($_SESSION["id"]) && !isset($_GET["time"]) && !isset($_GET["capacite"]))
                                echo "
                                    <form>
                                        <div class=\"row g-3\">
                                            <div class=\"col-md-6\">
                                                <div class=\"form-floating date\" id=\"date3\" data-target-input=\"nearest\">
                                                    <input type=\"text\" class=\"form-control datetimepicker-input\" id=\"datetime\" placeholder=\"Date & Time\" data-target=\"#date3\" data-toggle=\"datetimepicker\" name=\"time\" required/>
                                                    <label for=\"datetime\">Jour & Heure</label>
                                                </div>
                                            </div>
                                            <div class=\"col-md-6\">
                                                <div class=\"form-floating\">
                                                    <select class=\"form-select\" id=\"select1\" name=\"capacite\" required>
                                                        <option value=\"1\">1</option>
                                                        <option value=\"2\">2</option>
                                                        <option value=\"3\">3</option>
                                                        <option value=\"4\">4</option>
                                                        <option value=\"5\">5</option>
                                                        <option value=\"6\">6</option>
                                                        <option value=\"7\">7</option>
                                                    </select>
                                                    <label for=\"select1\">Nombre de personnes</label>
                                                </div>
                                            </div>
                                            <div class=\"col-12\">
                                                <button class=\"btn btn-primary w-100 py-3\" type=\"submit\">Rechercher...</button>
                                            </div>
                                        </div>
                                    </form>";
                            }
                        }
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                                allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php 
    require "./include/footer.inc.php";
?>