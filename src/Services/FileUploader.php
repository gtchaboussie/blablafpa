<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


class FileUploader{
    
    /**
     * Variable récupérée de la configuration dans sevrices yaml. Repsésente le dossier vers lequel seront envoyés les images pour stockage.
     * @var String
     */
    private $targetDirectory;

    /**
     * Instance du service de génération de slug afin de sécuriser le chemin et le nom de stockage
     */
    private $slugger;

    /**
     * Chaine de caractère à ajouter devant le nom du fichier afin de permettre de le retrouver par la suite. Définit par défault
     * @var String
     */
    private $pathToAdd;

    /**
     * Constructeur
     */
    public function __construct($targetDirectory, $pathToAdd, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->pathToAdd = $pathToAdd;
    }

    /**
     * Permets l'upload effectif du fichier présent dans une requête.
     * Renvoie le nom et le chemin donné au fichier après l'upload
     * @return String
     */
    public function upload(UploadedFile $file){
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
        }
        return $fileName = $this->pathToAdd.$fileName ;
    }

    public function getTargetDirectory(){
        return $this->targetDirectory;
    }
}
