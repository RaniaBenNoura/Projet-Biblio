<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Category ;
use AppBundle\Entity\Livre ;
use AppBundle\Entity\User ;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use App\Repository\UserRepository;


 /**
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @IsGranted("ROLE_ADMIN")
  */


    /**
     * @Route("/administration")
     */

class AdminController extends AbstractController

{   
    /**
     * @Route("/index", name="admin_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $livres = $em->getRepository(Livre::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();

        

        return $this->render('admin/index.html.twig',[]);
    }
    /**
     * @Route("/admin/login", name="login")
     */
    public function loginAction()
    {
       

        return $this->render('admin/login.html.twig');
    }

    
    
    
    /**
     * @Route("/listCategory", name="admin_category_index", methods={"GET"})
     */
    public function adminCategoryindex(CategoryRepository $categoryRepository): Response
    {
        $this->addFlash('succes','The Category is successfully added ..');

        return $this->render('admin/listCategory.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
        $this->addFlash('succes','The Category is successfully added ..');


    }

    /**
     * @Route("/listLivre", name="admin_livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('admin/listLivre.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }
    /**
     * @Route("/listUsers", name="admin_user_index", methods={"GET"})
     */
    public function listUsers(UserRepository $UserRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'livres' => $UserRepository->findAll(),
        ]);
    }


    
}
    
