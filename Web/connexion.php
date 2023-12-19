<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="Connexion";
    require "./include/header.inc.php";
?>
        
    <main>
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Connexion</h1>
            </div>
        </div>
        <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s" >
            <div class="row g-0">
                
                <div class="col-md-6 bg-dark d-flex align-items-center" style="margin-left: 25%;">
                    <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Connexion</h5>
                        <h1 class="text-white mb-4">Acceder à votre compte</h1>
                        <form action="connect.php" method="post">
                            <div class="row g-3">
                                <div class="col-md-6" style="width: 100%;">
                                    <div class="form-floating" >
                                        <input type="text" class="form-control" id="id" name="id" required>
                                        <label for="id">E-mail</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" style="width: 100%;">
                                    <div class="form-floating" >
                                        <input type="text" class="form-control" id="pass_word" name="pass_word" required>
                                        <label for="password">Mot de passe</label>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Connexion</button>
                                </div>
                                <p style="color: aliceblue;">Vous n'avez pas de compte ? <a href="inscription.php">Créer un compte</a></p>
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