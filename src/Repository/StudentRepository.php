<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * Renvoie un etudiant au hasard
     */
    public function getRandomStudent(){

        //récupération de l'ID le plus petit présent dans la base
        $indexes = $this->createQueryBuilder('s')
                      ->select('MAX(s.id) AS max, MIN(s.id) as min')
                      ->getQuery()
                      ->getResult();
        
        $maxId = $indexes[0]["max"];
        $minId = $indexes[0]["min"];
        $random = mt_rand($minId, $maxId);

        $result = null;
        while( !$result ){
            $result = $this->findOneBy([
                'id' => $random
            ]);
        }

        return $result;
    }

}
