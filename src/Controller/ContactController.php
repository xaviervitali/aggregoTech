<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/admin/contact', name: 'contact_index')]
    public function index(ContactRepository $contactRepository): Response
    {

        
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findBy([],["createdAt"=>"DESC"]),
        ]);
    }
        
    /**
     * @Route("/admin/contact/{id<\d+>}", name="contact_view")
     */
    public function view(Contact $contact): Response
    { 
        return $this->render('contact/view.html.twig', [
            'contact' => $contact,
        ]);
    }


        /**
     * @Route("/admin/contact/delete/{id<\d+>}", name="contact_delete")
     */
    public function delete(Contact $contact, EntityManagerInterface $em){
        $em->remove($contact);
        $em->flush();
        return $this->redirectToRoute('contact_index');
    }
    /**
     * @Route("/contact", name="contact_new")
     */
    public function new(Request $request,  EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $message = <<<THANK
        <div class="text-center">
        <p>
        Merci, nous accusons récéption de votre message :
        </p>
    
        
        </div>
        THANK;
        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var Contact $user
             */
            $user = $form->getData();
        
            $message = <<<THANK
            <div class="text-center">
            <p>
            Merci {$user->getLastname()} {$user->getFirstname()}, nous accusons récéption de votre message :
            </p>
            <p>
            {$user->getMessage()}
            </p>
            <p>
            Nous vous recontacterons soit sur {$user->getEmail()} soit sur {$user->getPhone()} pour répondre a votre demande de {$user->getRequest()} dès que possible.
            <p>
            
            </div>
            THANK;

            
            $this->addFlash(
                'info',
              $message
            );
            $em->persist($user);
            $em->flush();

            return $this->render("public/contact.html.twig", [
                "form" => $form->createView(), "message"=>$message
            ]);
        }
        return $this->render("public/contact.html.twig", [
            "form" => $form->createView()
        ]);
    }
     /**
     * @Route("/admin/contact/sendemail/{id}",  name="sendEmail")
     */
    public function sendEmail(MailerInterface $mailer, Contact $contact, Request $request)
    {

        $message = $request->request->get("message");

        $email = (new Email())
            ->from('contact@aggregotech.fr')
            ->to($contact->getEmail())
            ->cc('aggregotech-aci@gmail.com')
            ->subject("demande de "  . $contact->getRequest())
            ->html($message);

        $mailer->send($email); 
        return new JsonResponse(json_encode( $email));
    }
}
