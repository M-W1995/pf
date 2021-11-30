<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$contact->getExpediteur() OR !$contact->getMessage())
            {
                $this->addFlash('danger',"Veuillez remplir tous les champs demandés.");
            }
            else {
                if (!$contact->getEmail() && !$contact->getTelephone())
                {
                    $this->addFlash('danger',"Veuillez fournir au minimum une adresse mail ou un numéro de téléphone.");
                }
                else
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($contact);
                    $em->flush();
                    $this->addFlash('success',"Votre message a été envoyé.");
                }
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function adminContact()
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository(Contact::class)->findBy([],['id'=>'DESC']);

        return $this->render('admin/contact.html.twig', [
            'messages'=>$messages
        ]);
    }
    /**
     * @Route("/admin/contact/{id}", name="admin_contact_read")
     */
    public function adminContactRead($id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository(Contact::class)->findOneBy(['id'=>$id]);

        if (!$message->getLu()) {
            $message->setLu(true);
            $em->flush();
        }

        return $this->render('admin/read.html.twig', [
            'message'=>$message
        ]);
    }
}
