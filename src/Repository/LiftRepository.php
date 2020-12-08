<?php

namespace App\Repository;

use App\Entity\Lift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lift[]    findAll()
 * @method Lift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lift::class);
    }



    /**
     * Renvoie un trajet au hasard
     */
    public function getRandomLift(){
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
