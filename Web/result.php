<?php 
    declare(strict_types=1);
    $title = "Resume";
    if(isset($_GET['data']))
    $title = "Recapitulatif";

    require "./include/header.inc.php";
    
?>

<main style="display: grid; place-items: center;">
        <div class="container-xxl py-5 bg-dark hero-header mb-5" >
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Récapitulatif</h1>                
            </div>
        </div>
        <?php
        include("phpqrcode/qrlib.php");
        if(isset($_GET['data'])){
            $data = $_GET['data'];
            $picName = $data.'png';
            $parametres = ['size' => 10];
            ob_start();
                QRcode::png($data, null, QR_ECLEVEL_L, $parametres);
                $image = ob_get_contents();
            ob_end_clean();
            echo '<img src="data:image/png;base64,'.base64_encode($image).'" style="width:400px;height:400px;margin-top: 4%; margin-bottom:0%" alt="QR code"></br>';
            echo '<a href="data:image/png;base64,'.base64_encode($image).'"download="qrcode" ><button class=\"btn btn-primary w-100 py-3\">Telecharger</button></a>';
        }else{
            echo '<p style="color:black;font-size:large;">Solde Insuffisant pour réaliser cette transaction</p>';
        }
        ?>
    </div>
</main>

<?php 
    require "./include/footer.inc.php";
?>