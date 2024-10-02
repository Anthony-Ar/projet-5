<?php
declare(strict_types=1);

namespace App\Command;

use App\Attribute\CommandAttribute;
use App\Repository\ContactRepository;

class ContactCommand
{
    private ?ContactRepository $contact;

    public function __construct() {
        $this->contact = new ContactRepository();
    }

    #[CommandAttribute(
        name: 'list',
        pattern: '/^list$/',
        description: 'list : Affiche la liste des contacts enregistrés'
    )]
    public function showAllContact() : void
    {
        $contactList = $this->contact->findAll();

        if(empty($contactList)) {
            echo "Vous n'avez actuellement aucun contact.\n";
            echo "Créez-en un avec la commande create";
            return;
        }

        echo "Liste de contacts (format: id, nom, email, téléphone) :\n";
        foreach ($contactList as $contact) {
            echo $contact."\n";
        }
    }

    #[CommandAttribute(
        name: 'detail',
        pattern: '/^detail (.*)$/',
        description: 'detail [id] : Affiche le détail d\'un contact'
    )]
    public function showContact(int $id) : void
    {
        $contactDetail = $this->contact->find($id);

        if(!$contactDetail) {
            echo "Aucun contact n'existe pour cet identifiant.";
            return;
        }

        echo $contactDetail;
    }

    #[CommandAttribute(
        name: 'create',
        pattern: '/^create (.*), (.*), (.*)$/',
        description: 'create [name], [email], [phone] : Ajoute un nouveau contact à la base de données'
    )]
    public function addContact(string $name, string $email, string $phone) : void
    {
        $add = $this->contact->add($name, $email, $phone);

        echo "Vous venez de créé un nouveau contact :\n {$add}";
    }

    #[CommandAttribute(
        name: 'update',
        pattern: '/^update (.*), (.*), (.*), (.*)$/',
        description: 'update [id], [name], [email], [phone] : Modifie un contact existant'
    )]
    public function updateContact(int $id, string $name, string $email, string $phone) : void
    {
        $update = $this->contact->update($id, $name, $email, $phone);

        echo "Contact modifié avec succès :\n {$update}";
    }

    #[CommandAttribute(
        name: 'delete',
        pattern: '/^delete (.*)$/',
        description: 'delete [id] : Supprime un contact. Attention : cette action est irréversible'
    )]
    public function deleteContact(int $id) : void
    {
        $delete = $this->contact->find($id);

        if(!$delete) {
            echo "Aucun contact n'existe pour cet identifiant.";
            return;
        }

        $this->contact->delete($id);

        echo "Vous venez de supprimer \"{$delete['name']}\" de votre répertoire.";
    }
}
