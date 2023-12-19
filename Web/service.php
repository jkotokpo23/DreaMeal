<?php 
    declare(strict_types=1);
    
    require "./include/function.inc.php";
    $title="Services";
    require "./include/header.inc.php";
?>
        
        <main>
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Services</h1>                
            </div>
        </div>
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Nos Services</h5>
                    <h1 class="mb-5">Explorez nos services</h1>
                </div>
                <div class="row g-4">
                    
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a href="booking.php">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                                <h5>Reserver une table</h5>
                                <p>Anticipez et assurez-vous une table pour une soirée gastronomique inoubliable</p>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <a href="menu.php">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                                <h5>Commander en ligne</h5>
                                <p>Passer vos commandes et récuperer les au restaurant sur place</p>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                        <a href="service.php">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                                <h5>24/7 Service</h5>
                                <p>Toujours à votre service aux horaires via téléphoneou sur nos autres réseaux</p>
                            </div>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <a href="">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                                <h5>Qualité</h5>
                                <p>Une qualité surpérieure aussi dans notre service que nos matières premières</p>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </main>

        <?php 
    require "./include/footer.inc.php";
?>