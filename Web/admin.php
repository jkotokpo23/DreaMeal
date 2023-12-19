<?php
require "./include/function.inc.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<main>
            <div >
                <h2 style="color:red;">Ajouter à la carte</h2>
                <div>
                    <h3>Nouveau plat à la carte</h3>
                    <form action="administration.php" method="post">
                        <label for="nomPlat">Nom du plat : </label>
                        <input type="text" name="nomPlat" id="nomPlat" required/>
                        <label for="prixPlat">Prix du plat : </label>
                        <input type="text" name="prixPlat" id="prixPlat" required/>
                        <label for="descriptionPlat">Description du plat : </label>
                        <input type="text" name="descriptionPlat" id="descriptionPlat" required/>
                        <input type="submit" value="Ajouter le plat"/>
                    </form>
                </div>

                <div>
                    <h3>Nouvelle boisson à la carte</h3>
                    <form action="administration.php" method="post">
                        <label for="nomBoisson">Nom de la boisson :</label>
                        <input type="text" name="nomBoisson" id="nomBoisson"required/>
                        <label for="prixBoisson">Prix boisson : </label>
                        <input type="text" name="prixBoisson" id="prixBoisson" required/>
                        <label for="nomPlat">Quantite(Cl) : </label>
                        <input type="text" name="quantite" id="quantite" required/>
                        <input type="submit" value="Ajouter la boisson"/>
                    </form>
                </div>

                <div>
                    <h3>Nouveau menu à la carte</h3>
                    <form action="administration.php" method="post">
                        <label for="nomMenu">Nom du menu :</label>
                        <input type="text" name="nomMenu" id="nomMenu"required/>
                        <label for="prixMenu">Prix menu : </label>
                        <input type="text" name="prixMenu" id="prixMenu" required/>
                        <label for="nomMenu">Description : </label>
                        <input type="text" name="description" id="description" required/>
                        <label for="composition">Composition : </label>
                        <input type="text" name="composition" id="composition" required/>
                        <input type="submit" value="Ajouter menu"/>
                    </form>
                </div>

                <h2 style="color:red;">Tous les abonnées à notre service</h2>
                <table >
                    <thead>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Id</th>
                        <th>Telephone</th>
                        <th>Date de naissance</th>
                        <th>Sexe</th>
                    </thead>
                    <tbody>
                
                <?php
                    $conn_string = getDBparams();
                    $pdo = new PDO($conn_string);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->beginTransaction();
                    $query = "SELECT * FROM utilisateur NATURAL JOIN abonne";
                    $stmtUpadateSeat = $pdo->prepare($query);
                    $stmtUpadateSeat->execute();
                    $data = $stmtUpadateSeat->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $row) {
                        echo '<tr><td>'.$row['nom'].'</td><td>'.$row['prenom'].'</td><td>'.$row['id_user'].'</td><td>'.$row['num_telephone'].'</td><td>'.$row['date_naissance'].'</td><td>'.$row['sexe'].'</td></tr>';
                    }
                    $pdo->commit();
                    $pdo = null;
                    
                ?>
                </tbody>
                </table>
            </div>
        </main>
</body>
</html>      
