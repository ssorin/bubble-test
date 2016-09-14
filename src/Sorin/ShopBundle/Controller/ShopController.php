<?php

namespace Sorin\ShopBundle\Controller;

use Sorin\ShopBundle\Entity\Shop;
use Sorin\ShopBundle\Form\ShopType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ShopController extends Controller
{

    /**
     * Shortcut to get the manager
     */
    private function get_manager(){
        return $this->getDoctrine()->getManager();
    }

    /**
     * Shortcut to get the Shop repository
     */
    private function get_repo_shops(){
        return $this->get_manager()->getRepository('SorinShopBundle:Shop');
    }

    /**
     * Get form errors
     */
    protected function getErrorsAsArray($form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error)
            $errors[] = $error->getMessage();

        foreach ($form->all() as $key => $child) {
            if ($err = $this->getErrorsAsArray($child))
                $errors[$key] = $err;
        }
        return $errors;
    }

    /**
     * Shops list
     */
    public function listAction()
    {
        $shops = $this
            ->get_repo_shops()
            ->findAll()
        ;
        return $this->render(
            'SorinShopBundle:Shop:list.html.twig',
            array('shops' => $shops,)
        );
    }


    /**
     * Shop's detail according its ID
     */
    public function getAction($id, Shop $shop)
    {
        return new JsonResponse(
            array(
                'name' => $shop->getName(),
                'adress' => $shop->getAdress()
            )
        );
    }

    /**
     * Create shop
     */
    public function createAction(Request $request)
    {
        $shop = new Shop();
        $form = $this->createForm(new ShopType(), $shop);

        if($request->isMethod('POST')) {
            if($form->handleRequest($request)->isValid()) {
                $em = $this->get_manager();
                $em->persist($shop);
                $em->flush();

                return new JsonResponse(
                    array(
                        'id' => $shop->getId(),
                        'name' => $shop->getName(),
                        'adress' => $shop->getAdress()
                    )
                );

            }
            else {
                return new JsonResponse(
                    array(
                        'errors' => $this->getErrorsAsArray($form)
                    )
                );
            }
        }

        return $this->render(
            'SorinShopBundle:Shop:create.html.twig',
            array('form' => $form->createView(),
            )
        );
    }




    /**
     * Set shop, according its id
     */
    public function setAction(Request $request, $id)
    {

        $shop = $this
            ->get_repo_shops()
            ->findOneById($id)
        ;

        if ($shop== NULL) {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(new ShopType(), $shop);

        if($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {

                $this->get_manager()->flush();

                return new JsonResponse(
                    array(
                        'id' => $shop->getId(),
                        'name' => $shop->getName(),
                        'adress' => $shop->getAdress()
                    )
                );
            }
            else {
                return new JsonResponse(
                    array(
                        'errors' => $this->getErrorsAsArray($form)
                    )
                );
            }

        }
        return $this->render(
            'SorinShopBundle:Shop:set.html.twig',
            array(
                'form'   => $form->createView(),
                'shop' => $shop
            )
        );
    }

}