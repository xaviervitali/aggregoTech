<?php

namespace App\Controller;

use App\Entity\AddressBook;
use App\Entity\AddressBookActivity;
use App\Form\AddressBookActivityType;
use App\Form\AddressBookType;
use App\Form\SurveyType;
use App\Repository\AddressBookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressBookController extends AbstractController
{
    #[Route('/profile/address/book', name: 'address_book_new')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $addressBookForm = $this->createForm(AddressBookType::class);
        $addressBookActivityForm = $this->createForm(AddressBookActivityType::class);
        $addressBookForm->handleRequest($request);
        $addressBookActivityForm->handleRequest($request);

        if ($addressBookForm->isSubmitted() && $addressBookForm->isValid()) {
            $addressBook = $addressBookForm->getData();
            $em->persist($addressBook);
            $em->flush();
            return $this->redirectToRoute('addressBook');
        }

        if ($addressBookActivityForm->isSubmitted() && $addressBookActivityForm->isValid()) {
            $addressBookActivity = $addressBookActivityForm->getData();
            $em->persist($addressBookActivity);
            $em->flush();
            // return $this->redirectToRoute('addressBook');
        }

        return $this->render('address_book/new.html.twig', [
            "addressBookform" => $addressBookForm->createView(),
            "addressBookActivityform" => $addressBookActivityForm->createView()

        ]);
    }
    /**
     * @Route("/profile/addresses", name="addressBook")
     *     
     *  */
    public function index(AddressBookRepository $addressBookRepository, EntityManagerInterface $em,  Request $request)
    {
        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Survey $survey
             */

            $survey = $form->getData();
            $survey->setUser($this->getUser());
            $em->persist($survey);
            $em->flush();
            return $this->redirectToRoute('survey', ["id" => $this->getUser()->getId()]);
        }



        return $this->render('address_book/index.html.twig', [
            "addressBook" => $addressBookRepository->findAll(),
            "form" => $form->createView()

        ]);
    }

    /**
     * @Route("/profile/addresses/delete/{id}", name="addressBookDelete")
     */
    public function addressBookDelete(AddressBook $addressBook, EntityManagerInterface $em)
    {
        $em->remove($addressBook);
        $em->flush();
        return $this->redirectToRoute("addressBook");
    }

    /**
     * @Route("/profile/addresses/{id}", name="addressBookEdit")
     */
    public function edit(EntityManagerInterface $em, Request $request, AddressBook $addressBook): Response
    {
        $addressBookForm = $this->createForm(AddressBookType::class, $addressBook);
        $addressBookForm->handleRequest($request);
        if ($addressBookForm->isSubmitted() && $addressBookForm->isValid()) {
            $addressBook = $addressBookForm->getData();
            $em->persist($addressBook);
            $em->flush();
            return $this->redirectToRoute('addressBook');
        }
        $addressBookActivityForm = $this->createForm(AddressBookActivityType::class);

        $addressBookActivityForm->handleRequest($request);
        if ($addressBookActivityForm->isSubmitted() && $addressBookActivityForm->isValid()) {
            $addressBookActivity = $addressBookActivityForm->getData();
            $em->persist($addressBookActivity);
            $em->flush();
            // return $this->redirectToRoute('addressBook');
        }

        return $this->render('address_book/new.html.twig', [
            "addressBookform" => $addressBookForm->createView(),
            "addressBookActivityform" => $addressBookActivityForm->createView()

        ]);
    }
    /**
     * @Route("/profile/addresses/activity/delete/{id}", name="addressBookActivityDelete")
     */
    public function addressBookActivityDelete(AddressBookActivity $addressBookActivity, EntityManagerInterface $em)
    {
        $em->remove($addressBookActivity);
        $em->flush();
        return new JsonResponse(["status" => "ok"]);
    }
}
