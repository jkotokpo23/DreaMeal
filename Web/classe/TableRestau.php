<?php
/**
 * La classe TableRestau représente une table dans un restaurant.
 */
class TableRestau{
    private $idTable;
    private $capacite;
    private $nom;

    /**
     * Constructeur de la classe TableRestau.
     *
     * @param int $idTable Identifiant de la table.
     * @param int $capacite Capacité de la table (nombre de personnes qu'elle peut accueillir).
     * @param string $nom Nom de la table.
    */
    public function __construct($idTable, $capacite, $nom)
    {
        $this->idTable = $idTable;
        $this->capacite = $capacite;
        $this->nom = $nom;
    }
    
    public function getIdTable()
    {
        return $this->idTable;
    }

    public function getCapacite()
    {
        return $this->capacite;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setIdTable($idTable)
    {
        $this->idTable = $idTable;
    }

    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
}
?>
