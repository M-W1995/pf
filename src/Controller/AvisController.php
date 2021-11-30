<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Deces;
use App\Entity\Condoleances;
use App\Form\CondoleancesType;
use Doctrine\Common\Collections\Criteria;
use App\Form\DecesType;

class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="avis_deces")
     */
    public function avisDeces()
    {
        $em = $this->getDoctrine()->getManager();
        $avis = $em->getRepository(Deces::class)->findBy([],['id'=>'DESC']);

        return $this->render('avis/index.html.twig', [
            'items'=>$avis,
        ]);
    }
    /**
     * @Route("/avis/{id}", name="show_avis_deces")
     */
    public function showAvisDeces($id)
    {
        $em = $this->getDoctrine()->getManager();
        $avis = $em->getRepository(Deces::class)->findOneBy(['id'=>$id]);

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('valide', true))
            ->orderBy(['id' => Criteria::DESC]);

        $condoleances = $avis->getCondoleances()->matching($criteria);

        $form = $this->createForm(CondoleancesType::class);

        return $this->render('avis/show.html.twig', [
            'avis'=>$avis,
            'form'=>$form->createView(),
            'condoleances'=>$condoleances
        ]);
    }
    /**
     * @Route("/deces/bougie/add/{id}", name="add_bougie", methods={"POST"})
     */
    public function addBougie(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deces = $em->getRepository(Deces::class)->findOneBy(['id'=>$id]);
        $bougies = $deces->getBougies();
        $bougies++;
        $deces->setBougies($bougies);
        $em->flush();
        return $this->json(['bougies'=>$bougies]);
    }
    /**
     * @Route("/deces/condoleance/add/{id}", name="add_condoleance", methods={"POST"})
     */
    public function addCondoleance(Request $request, $id)
    {
        $condoleance = new Condoleances;
        $form = $this->createForm(CondoleancesType::class,$condoleance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {    
            if (strlen($condoleance->getAuteur()) < 5)
            {
                $message[] = ['auteur',"Ce champs doit contenir au moins 5 caractères."];
                $status = 'error';
            }
            if (strlen($condoleance->getMessage()) < 10)
            {
                $message[] = ['message',"Ce champs doit contenir au moins 10 caractères."];
                $status = 'error';
            }
            if (!isset($status))
            {
                $em = $this->getDoctrine()->getManager();
                $deces = $em->getRepository(Deces::class)->findOneBy(['id'=>$id]);
                $em->persist($condoleance);
                $deces->addCondoleance($condoleance);
                $em->flush();
                $message = "success";
                $status = 'success';
            }
        }

        return $this->json(['status'=>$status,'message'=>$message]);
    }

    /**
     * @Route("/espace/connect/{id}", name="espace_connect", methods={"POST"})
     */
    public function espaceConnect(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deces = $em->getRepository(Deces::class)->findOneBy(['id'=>$id]);
        if ($request->get('cle') != $deces->getCle())
        {
            return $this->json(['status'=>0]);
        }

        $session = new Session();
        $session->set('avis_id', $deces->getId());

        return $this->json(['status'=>1]);
    }

    /**
     * @Route("/avis/espace/{id}", name="avis_espace", methods={"POST"})
     */
    public function avisEspace(Request $request, $id)
    {
        $session = new Session();

        if ($session->get('avis_id') != $id)
        {
            return $this->json(null,400);
        }

        $em = $this->getDoctrine()->getManager();
        $deces = $em->getRepository(Deces::class)->findOneBy(['id'=>$id]);
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('valide', null))
            ->orderBy(['id' => Criteria::DESC]);
        $condoleances = $deces->getCondoleances()->matching($criteria);

        $content = $this->renderView('avis/espace.html.twig', [
            'condoleances'=>$condoleances
        ]);

        return $this->json(['content'=>$content]);
    }
    /**
     * @Route("/avis/condoleances/gestion/{id}", name="gestion_condoleance", methods={"POST"})
     */
    public function gestionCondoleance(Request $request, $id)
    {
        $session = new Session();

        if ($session->get('avis_id') != $id) {
            return $this->json(null,400);
        }

        $post = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $condoleance = $em->getRepository(Condoleances::class)->findOneBy(['id'=>$post->id]);

        if ($post->action == 'delete') {
            $em->remove($condoleance);
        } else if ($post->action = 'accept') {
            $condoleance->setValide(true);
        }
        $em->flush();

        return $this->json(null,200);
    }

    ///////////////////////////////////////////////////////////// 
    ///////////////////////////// ADMIN ////////////////////////
    ///////////////////////////////////////////////////////////// 
    /**
     * @Route("/admin/deces", name="admin.deces")
     */
    public function deces()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(Deces::class)->findBy([],['id'=>'DESC']);

        return $this->render('admin/deces.html.twig', [
            'items'=>$items,
        ]);
    }

    /**
     * @Route("/admin/deces/delete/{id}", name="delete_avis_deces")
     */

    public function deleteAvis($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $deces = $em->getRepository(Deces::class)->findOneBy(['id'=>$id]);

        $em->remove($deces);
        $em->flush();
        $this->addFlash('success',"Avis supprimé avec succès.");
        return $this->redirectToRoute('admin.deces');
    }

    /**
     * @Route("/admin/deces/add", name="admin.deces.add")
     */
    public function addDeces(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(Deces::class)->findAll();

        $avis = new Deces;
        $form = $this->createForm(DecesType::class,$avis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {     
            $cle = bin2hex(random_bytes(3));
            $avis->setCle($cle);

            $naissance = date_create_from_format('Y-m-d',$form['naissance']->getData());
            $date = date_create_from_format('Y-m-d',$form['date']->getData());
            $avis->setAge($date->diff($naissance)->y);

            $em->persist($avis);
            $em->flush();

            $this->addFlash('success',"Avis ajouté. Clé espace famille : $cle");
            return $this->redirectToRoute('admin.deces');
        }

        return $this->render('admin/add_deces.html.twig', [
            'items'=>$items,
            'form'=>$form->createView()
        ]);
    }
}
