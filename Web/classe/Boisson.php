<?php
/**
 * La classe Boisson représente une boisson dans le système.
 */
class Boisson
{
    private $id_boisson;
    private $nom;
    private $prix;
    private $image;
    private $quantite_en_cl;

    /**
     * Constructeur de la classe Boisson.
     *
     * @param string $id_boisson L'identifiant unique de la boisson.
     * @param string $nom Le nom de la boisson.
     * @param float $prix Le prix de la boisson.
     * @param string $image Le chemin vers l'image de la boisson.
     * @param float $quantite_en_cl La quantité de la boisson en centilitres.
     */
    public function __construct($id_boisson, $nom, $prix, $image, $quantite_en_cl)
    {
        $this->id_boisson = $id_boisson;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->image = $image;
        $this->quantite_en_cl = $quantite_en_cl;
    }

    public function getIdBoisson()
    {
        return $this->id_boisson;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getQuantiteEnCl()
    {
        return $this->quantite_en_cl;
    }
}

?>
