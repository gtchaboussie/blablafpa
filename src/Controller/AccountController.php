<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\AccountType;
use App\Form\RegisterType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils){
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout(){
        // .. rien !
    }

 /**
     * Permet d'afficher et gérer le formulaire d'inscription
     * @Route("/register", name="account_register")
     * @return Response
     */
    public function register(
                            Request $request, EntityManagerInterface $manager,
                            UserPasswordEncoderInterface $encoder,
                            SluggerInterface $slugger) {
                                
        $student = new Student();

        $form = $this->createForm(RegisterType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($student, $student->getPassword());
            $student->setPassword($password);

            //===========================================================
            //  IMAGE PART
            //===========================================================

            /** @var UploadedFile $studentPictureFile */
            $studentPictureFile = $form->get('studentPicture')->getData();

            //Condition necessaire car le champ n'est pas requis.
            if ($studentPictureFile) {
                $originalFilename = pathinfo($studentPictureFile->getClientOriginalName(), PATHINFO_FILENAME);

                // Creation d'un slug afin de sécuriser l'accès à l'image par la suite.
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$studentPictureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $studentPictureFile->move(
                        $this->getParameter('student_pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $student->setStudentPicture($newFilename);
            }

            //===========================================================
            // EO IMAGE PART
            //===========================================================

            $manager->persist($student);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     * @Route("/account/profile", name="account_profile")
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager){
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            $this->addflash(
                'success',
                "Les données du profil ont été enregistrée avec succès !"
            );
        }

        return $this->render('account/myAccount.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier le mot de passe
     * @Route("/account/password-update", name="account_password")
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager) {
        $passwordUpdate = new PasswordUpdate();

            $student = $this->getUser();

            $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                // 1. Vérifier que le oldPassword du formulaire soit le même que le password de l'user
                if(!password_verify($passwordUpdate->getOldPassword(), $student->getPassword())) {
                    // Gérer l'erreur
                    $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
                } else {
                    $newPassword = $passwordUpdate->getNewPassword();
                    $password = $encoder->encodePassword($student, $newPassword);

                    $student->setPassword($password);

                    $manager->persist($student);
                    $manager->flush();

                    $this->addFlash(
                        'success',
                        "Votre mot de passe a bien été modifié !"
                    );

                    return $this->redirectToRoute('homepage');
                }
            }

        return $this->render('account/password_update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     * @Route("/account", name="account_my_account")
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     */
    public function myAccount(){
        return $this->render('account/myAccount.html.twig', [
            'user' => $this->getUser()
        ]);
    }

}
