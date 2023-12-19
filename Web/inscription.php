<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="Inscription";
    require "./include/header.inc.php";
?>
        
    <main>
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Inscription</h1>
            </div>
        </div>
        <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-0">
                
                <div class="col-md-6 bg-dark d-flex align-items-center" style="margin-left: 25%;">
                    <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Inscription</h5>
                        <h1 class="text-white mb-4">S'inscrire</h1>
                        <form action="traitement.php" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nom" name="nom" placeholder="votre nom" required/>
                                        <label for="nom">Nom</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="votre prenom" required/>
                                        <label for="prenom">Prenom</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="phone" class="form-control" id="phone" name="phone" placeholder="Telephone" required/>
                                        <label for="phone">Numéro de téléphone</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating date" id="date3" data-target-input="nearest">
                                        <input class="form-control datetimepicker-input" type="date" id="birthdate" name="birthdate" max="2023-11-18" min="2005-01-01" required/>
                                        <label for="birthdate">Date de naissance</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="phone" class="form-control" id="email" name="email" placeholder="email" required/>
                                        <label for="email">email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="sexe" name="sexe" required>
                                          <option value="Femme">Femme</option>
                                          <option value="Homme">Homme</option>
                                        </select>
                                        <label for="sexe">Sexe</label>
                                      </div>
                                </div>
                                <div class="col-md-6" style="width: 100%;">
                                <?php if(isset($_GET["pw"])) echo "<p>Les mots de passes ne sont pas identiques</p>"; ?>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required/>
                                        <label for="password">Mot de passe</label>
                                    </div>
                                </div>
                                <div class="col-md-6" style="width: 100%;">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password" name="passwordconf" placeholder="Mot de passe" required/>
                                        <label for="passwordconf">Confirmez votre mot de passe</label>
                                    </div>
                                </div>
                                <p style="color:aliceblue;">Adresse personnelle</p>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="no_bat" name="no_bat" placeholder="Numero"/>
                                        <label for="no_bat">Numero de batiment</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="no_rue" name="no_rue" placeholder="Nom de rue">
                                        <label for="no_rue">Nom de rue</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville">
                                        <label for="ville">Ville</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="code_postal" name="code_postal" placeholder="Code postal">
                                        <label for="code_postal">Code postal</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Creez une compte</button>
                                </div>
                                <p style="color: aliceblue;">Vous avez déjà un compte?<a href="connexion.html"> Connectez-vous ici</a></p>
                            </div>
                        </form>
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