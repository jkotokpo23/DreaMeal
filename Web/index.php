<?php 
    declare(strict_types=1);
    require "./include/function.inc.php";
    $title="DreaMeal";
    require "./include/header.inc.php";
?>

        <main>
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft">Profitez de nos<br>Delicieux mets</h1>
                            <p class="text-white animated slideInLeft mb-4 pb-2">Explorez une symphonie de saveurs exquises dans notre restaurant, où chaque plat est une ode à la délicatesse culinaire. 
                                Plongez dans une expérience gastronomique inoubliable, où le goût et l'élégance se rencontrent pour éveiller vos papilles à un voyage de plaisirs gustatifs.</p>
                            <a href="booking.php" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Reservez une table</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <img class="img-fluid" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </main>
        
    <?php 
    require "./include/footer.inc.php";
?>