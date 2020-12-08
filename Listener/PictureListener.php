<?php

namespace Listener\PictureListener;

use App\Entity\Student;
use App\Services\PictureUpload;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureUploadListener{

    private $uploader;

    public function __construct(PictureUpload $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($student);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $student = $args->getEntity();

        $this->uploadFile($student);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$student instanceof Student) {
            return;
        }

        $file = $student->getPicture();

        // Seulement pour upload nouveaux fichiers
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setPicture($fileName);
    }
}


?>