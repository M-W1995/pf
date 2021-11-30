<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MarbrerieType;
use App\Entity\Marbrerie;
use App\Entity\Inter;
use App\Entity\InterCategorie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class MarbrerieController extends AbstractController
{
    /**
     * @Route("/monuments", name="monuments")
     */
    public function monuments()
    {
        $em = $this->getDoctrine()->getManager();
        $traditionnels = $em->getRepository(Marbrerie::class)->findBy(['categorie'=>'traditionnel']);
        $cineraires = $em->getRepository(Marbrerie::class)->findBy(['categorie'=>'cineraire']);

        return $this->render('marbrerie/monuments.html.twig', [
            'traditionnels'=>$traditionnels,
            'cineraires'=>$cineraires
        ]);
    }
    /**
     * @Route("/plaques", name="plaques")
     */
    public function plaques()
    {
        $em = $this->getDoctrine()->getManager();
        $plaques = $em->getRepository(Marbrerie::class)->findBy(['categorie'=>'plaque']);

        return $this->render('marbrerie/plaques.html.twig', [
            'plaques'=>$plaques
        ]);
    }
    /**
     * @Route("/inters", name="inters")
     */
    public function inters()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(InterCategorie::class)->findAll();

        foreach ($categories as $categorie)
        {
            $inters[$categorie->getNom()] = $categorie->getInters();
        }

        return $this->render('marbrerie/inters.html.twig', [
            'inters'=>$inters
        ]);
    }


     /**
     * @Route("/admin/marbrerie/edit/{id}", name="admin.marbrerie.edit")
     */
    public function editMarbrerie(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $monument = $em->getRepository(Marbrerie::class)->findOneBy(['id'=>$id]);


        return $this->render('admin/users.html.twig', [
            'item'=>$monument,
        ]);
    }
    /**
     * @Route("/admin/marbrerie/delete/{id}", name="admin.marbrerie.delete")
     */
    public function deleteMarbrerie(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $monument = $em->getRepository(Marbrerie::class)->findOneBy(['id'=>$id]);
        $slug = $monument->getCategorie();
        $photoPath = $monument->getPhoto();

        $filesystem = new Filesystem();
        $path=$this->getParameter('marbrerie_directory').$photoPath;
        $filesystem->remove($path);

        $em->remove($monument);
        $em->flush();

        return $this->redirectToRoute('admin.marbrerie',['slug'=>$slug]);
    }
    /**
     * @Route("admin/marbrerie/{slug}", name="admin.marbrerie")
     */
    public function adminMarbrerie(Request $request, $slug, SluggerInterface $slugger)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(Marbrerie::class)->findBy(['categorie'=>$slug]);
        $monument = new Marbrerie;  
        $form = $this->createForm(MarbrerieType::class,$monument);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {     
            $monument->setCategorie($slug);
            $file = $form->get('photo')->getData();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $slug.'-'.$safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            $file->move($this->getParameter('marbrerie_directory'),$newFilename);
            $monument->setPhoto($newFilename);
            $em->persist($monument);
            $em->flush();

            return $this->redirectToRoute('admin.marbrerie',['slug'=>$slug]);
        }

        return $this->render('admin/marbrerie.html.twig', [
            'items'=>$items,
            'form'=>$form->createView(),
            'slug'=>$slug
        ]);
    }
    /**
     * @Route("admin/inters", name="admin.inters")
     */
    public function adminInters(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $inters = $em->getRepository(Inter::class)->findAll();
        $categories = $em->getRepository(InterCategorie::class)->findAll();

        if ($request->isMethod('post')) 
        {
            if ($request->request->get('form_name') == 'new_inter')
            {
                if (empty($request->request->get('categorie')) OR empty($request->request->get('inter_nom'))) {

                }
                else {
                    $inter = new Inter;
                    $categorie = $em->getRepository(InterCategorie::class)->findOneBy(['id'=>$request->request->get('categorie')]);
                    $inter->setCategorie($categorie);
                    $inter->setNom($request->request->get('inter_nom'));
                    $em->persist($inter);
                    $em->flush();
                    return $this->redirectToRoute('admin.inters');
                }
            }
            else if ($request->request->get('form_name') == 'new_categorie')
            {
                if (!empty($request->request->get('categorie_nom'))) {
                    $categorie = new InterCategorie;
                    $categorie->setNom($request->request->get('categorie_nom'));
                    $em->persist($categorie);
                    $em->flush();
                    return $this->redirectToRoute('admin.inters');
                }
            }
        }

        return $this->render('admin/inters.html.twig', [
            'inters'=>$inters,
            'categories'=>$categories
        ]);
    }
}
