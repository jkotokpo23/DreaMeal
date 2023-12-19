<?php
require_once "TableRestau.php";


/**
 * La classe AvailableTable représente les tables disponibles dans un restaurant à un moment donné.
 */
class AvailableTable{

private $availableTables;
private TableRestau $table;

/**
* Constructeur de la classe AvailableTable.
* Initialise les tables disponibles en fonction du moment et de la capacité spécifiés.
*
* @param string $time Le moment pour lequel on veut les tables disponibles.
* @param int $capacite La capacité des tables recherchées.
*/
public function __construct($time, $capacite) {
    $conn_string = getDBparams();

    try {
        $pdo = new PDO($conn_string);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $query = "WITH tables_occupees AS (
            SELECT cr.id_table
            FROM creneau cr
            WHERE (
                :time >= cr.debut AND :time < cr.fin
            )
        )
        SELECT tr.*
        FROM tablerestau tr
        LEFT JOIN tables_occupees TOcc ON tr.id_table = TOcc.id_table
        WHERE tr.capacite = :capacite AND TOcc.id_table IS NULL";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':capacite', $capacite);
        $stmt->execute();

        $this->availableTables = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_table = $row['id_table'];
            $capacite = (int)$row['capacite'];
            $nom = $row['nom'];
            $table = new TableRestau($id_table, $capacite, $nom);
            $this->availableTables[] = $table;
        }
        $pdo->commit();
    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        echo "Erreur : " . $e->getMessage();
    } finally {
        // Fermeture de la connexion dans le bloc finally pour s'assurer que la connexion est toujours fermée
        $pdo = null;
    }
}


public function getAvalaibleTables()
    {
        return $this->availableTables;
    }

public function getAvalaibleCr($reserv){
    
}

}


?>