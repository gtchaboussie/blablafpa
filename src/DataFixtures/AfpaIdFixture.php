<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Lift;
use App\Entity\Booking;
use App\Entity\Student;
use App\Entity\GivenStudentsId;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\GivenStudentsIdRepository;
use App\Repository\LiftRepository;
use App\Repository\StudentRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * La fixture représente un Stagiaire.
 * Le numéro de telephone n'est pas réaliste
 * La durée de formation est aussi approximative
 * On commence par générer les identifiants fournis par l'administration,
 * Puis, les stagiaires utilisants ces identifiants
 * Puis, les trajets
 * puis les reservations aléatoires.
 * Les fixtures peuvent mettre plusieurs secondes voire dizaines de secondes à charger, c'est normal
 * 
 * @author MrPlop
 */
class AfpaIdFixture extends Fixture
{
    /**
     * Constructeur, necessaire à l'injection de dépendance pour la
     * sécurisation du mot de passe.
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder,
        GivenStudentsIdRepository $givenStudentsIdRepo,
        StudentRepository $studentRepo,
        LiftRepository $liftRepo
    ) {
        $this->encoder = $encoder;
        $this->givenStudentsIdRepo = $givenStudentsIdRepo;
        $this->studentRepo = $studentRepo;
        $this->liftRepo = $liftRepo;
    }

    public function load(ObjectManager $manager)
    {
        //appel à faker
        $faker = Factory::create('fr_FR');

        //=======================================================================
        //creation des identifiants afpa
        //=======================================================================
        for ($i = 0; $i < 100; $i++) {
            $id = new GivenStudentsId();

            $id->setStudentId($faker->randomNumber(8, true));
            $manager->persist($id);
        }

        $manager->flush();

        //=======================================================================
        //creation des entitées Students
        //=======================================================================

        //Déclaration de deux sexes pour les choix de faker
        $genres = ['male', 'female'];

        for ($i = 0; $i < 50; $i++) {
            //création de l'entitée student
            $student = new Student();

            //Récupération d'un ID factice mais existant
            $fakeId = $this->givenStudentsIdRepo->getRandomId();

            //TESTS
            //dump($fakeId->getStudentId());
            //EOTESTS

            $studentId = $fakeId->getStudentId();

            //génération des données
            $studentFirstName = $faker->firstName;
            $studentLastName = $faker->lastName;
            $studentMail = $faker->email;
            $studentPhone = $faker->randomNumber(8);
            //mot de passe
            $studentPassword = $this->encoder->encodePassword(
                $student,
                'password'
            );

            //création de la structure photo
            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            // Suite
            $studentDescription = join($faker->paragraphs(2));
            $studentStartDate = $faker->dateTimeBetween('-10 weeks');
            $studentEndDate = $faker->dateTimeBetween(
                '+4 months',
                '+ 10 months'
            );

            //application des données à l'entitée
            $student
                ->setStudentId($studentId)
                ->setStudentFirstName($studentFirstName)
                ->setStudentLastName($studentLastName)
                ->setStudentMail($studentMail)
                ->setStudentPicture($picture)
                ->setStudentPhone($studentPhone)
                ->setPassword($studentPassword)
                ->setStudentDescription($studentDescription)
                ->setStudentStartDate($studentStartDate)
                ->setStudentEndDate($studentEndDate);

            //appel au manager
            $manager->persist($student);

            //=======================================================================
            // creation des entitées Lift = trajets
            // Un stagiaire créé entre 0 et 5 trajets
            //=======================================================================
            for ($j = 0; $j < mt_rand(0, 5); $j++) {
                $lift = new Lift();

                $lift
                    ->setLiftCityStart($faker->word())
                    ->setLiftCityGoal($faker->word())
                    ->setLiftDate(
                        $faker->dateTimeBetween('-2 weeks', '+3 weeks')
                    )
                    ->setLiftSeats(mt_rand(3, 6))
                    ->setStudent($student);

                $manager->persist($lift);
            }
        }
        /**
         * Sauvegarde effective en bdd
         * Cette sauvegarde est necessaire afin d'avoir accès aux objets requis avant
         * la création des reservations
         */
        $manager->flush();

        //=======================================================================
        // creation des entitées Booking = reservations
        // 40 trajets pris au hasars et reservés par des étudiants au hasard
        //=======================================================================

        for ($i = 0; $i < 40; $i++) {
            $booking = new Booking();

            $booking
                ->setBookingSeatsBooked(mt_rand(1, 3))
                ->setStudent($this->studentRepo->getRandomStudent())
                ->setLift($this->liftRepo->getRandomLift());

            $manager->persist($booking);
        }

        //Sauvegarde effective en bdd
        $manager->flush();
    }
}
