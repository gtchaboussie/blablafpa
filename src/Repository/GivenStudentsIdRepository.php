<?php

namespace App\Repository;

use App\Entity\GivenStudentsId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GivenStudentsId|null find($id, $lockMode = null, $lockVersion = null)
 * @method GivenStudentsId|null findOneBy(array $criteria, array $orderBy = null)
 * @method GivenStudentsId[]    findAll()
 * @method GivenStudentsId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GivenStudentsIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GivenStudentsId::class);
    }

    /**
     * Cette fonction renvoie un Objet d'indentifiant au hasard pris dans la base de données
     */
    public function getRandomId() :GivenStudentsId {

        //récupération de l'ID le plus petit présent dans la base
        $result = $this->createQueryBuilder('g')
                      ->select('MAX(g.id) AS max, MIN(g.id) as min')
                      ->getQuery()
                      ->getResult();
        
        $maxId = $result[0]["max"];
        $minId = $result[0]["min"];

        $random = mt_rand($minId, $maxId);

        //récupération de l'identifiant aléatoire
        return $this->findOneBy([
            'id' => $random
        ]);
    }
}
