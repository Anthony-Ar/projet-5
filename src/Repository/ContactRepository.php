<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use Config\Database;
use PDO;

class ContactRepository
{
    private ?PDO $pdo;

    public function __construct() {
        $this->pdo = Database::db();
    }

    /**
     * Retourne la liste de tous les contacts
     * @return array
     */
    public function findAll() : array
    {
        $query = $this->pdo->prepare("SELECT * FROM contact");
        $query->execute();

        $contacts = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = Contact::fromArray($row);
        }

        return $contacts;
    }

    /**
     * Retrouve un contact grâce à l'ID associé
     * @param int $id
     * @return Contact|null
     */
    public function find(int $id) : ?Contact
    {
        $query = $this->pdo->prepare("SELECT * FROM contact WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return Contact::fromArray($row);
    }

    /**
     * Insère une nouvelle entrée sur la table "contact", retourne l'entrée ajoutée
     * @param string $name
     * @param string $email
     * @param string $phone
     * @return Contact
     */
    public function add(string $name, string $email, string $phone) : Contact
    {
        $query = $this->pdo->prepare(
            "INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)"
        );
        $query->bindParam(":name", $name);
        $query->bindParam(":email", $email);
        $query->bindParam(":phone_number", $phone);
        $query->execute();

        $entry = $this->pdo->lastInsertId();

        return $this->find((int)$entry);
    }

    /**
     * Modifie un contact existant
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $phone
     * @return Contact
     */
    public function update(int $id, string $name, string $email, string $phone) : Contact
    {
        $query = $this->pdo->prepare(
            "UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id"
        );
        $query->bindParam(":name", $name);
        $query->bindParam(":email", $email);
        $query->bindParam(":phone_number", $phone);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        return $this->find($id);
    }

    /**
     * Supprime un contact de la base de données
     * @param int $id
     * @return void
     */
    public function delete(int $id) : void
    {
        $query = $this->pdo->prepare("DELETE FROM contact WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
    }
}
