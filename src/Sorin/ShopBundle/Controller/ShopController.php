<?php

namespace Sorin\ShopBundle\Controller;

use Sorin\ShopBundle\Entity\Shop;
use Sorin\ShopBundle\Form\ShopType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;


class ShopController extends Controller
{

    /**
     * Shortcut to get the manager
     */
    private function get_manager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Shortcut to get the Shop repository
     */
    private function get_repo_shops()
    {
        return $this->get_manager()->getRepository('SorinShopBundle:Shop');
    }

    /**
     * Get form errors
     */
    protected function getErrorsAsArray($form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $key => $child) {
            if ($err = $this->getErrorsAsArray($child)) {
                $errors[$key] = $err;
            }
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
            ->findAll();

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
        if ($request->isMethod('POST')) {

            $name = $request->request->get('name', null);
            $adress = $request->request->get('adress', null);

            $data = array(
                'name' => $request->request->get('name', null),
                'adress' => $request->request->get('adress', null),
            );


            // Validation...
            if (empty($name)) {
                return new JsonResponse(array('error' => "Name must not be empty"));
            }
            if (strlen($name) < 3) {
                return new JsonResponse(array('error' => "Name too short"));
            }
            $shop_exist = $this
                ->get_repo_shops()
                ->findByName($name);
            if ($shop_exist) {
                return new JsonResponse(array('error' => "Shop already exist"));
            }

            if (empty($adress)) {
                return new JsonResponse(array('error' => "Name must not be empty"));
            }
            if (strlen($adress) < 3) {
                return new JsonResponse(array('error' => "Adress too short"));
            }

            // Create ...
            $shop = new Shop();
            $shop->setName($name);
            $shop->setAdress($adress);
            $em = $this->getDoctrine()->getManager();
            $em->persist($shop);
            $em->flush();

            return new JsonResponse(
                array(
                    'name' => $name,
                    'adress' => $adress,
                )
            );
        } else {
            throw new AccessDeniedHttpException();
        }
    }




    /**
     * Set shop, according its id
     */
    public function setAction(Request $request)
    {


        if ($request->isMethod('POST')) {

            $id = $request->request->get('id', null);
            $name = $request->request->get('name', null);
            $adress = $request->request->get('adress', null);

            $shop = $this
                ->get_repo_shops()
                ->findOneById($id);


            // Validation ...
            if ($shop == null) {
                throw new AccessDeniedHttpException();
            }
            if (empty($name)) {
                return new JsonResponse(array('error' => "Name must not be empty"));
            }
            if (strlen($name) < 3) {
                return new JsonResponse(array('error' => "Name too short"));
            }
            $shop_exist = $this
                ->get_repo_shops()
                ->findOneByName($name);
            if ($shop_exist && $shop_exist->getId() != $id) {
                return new JsonResponse(array('error' => "Shop already exist"));
            }

            if (empty($adress)) {
                return new JsonResponse(array('error' => "Name must not be empty"));
            }
            if (strlen($adress) < 3) {
                return new JsonResponse(array('error' => "Adress too short"));
            }

            // Create ...
            $shop->setName($name);
            $shop->setAdress($adress);
            $em = $this->getDoctrine()->getManager();
            $em->persist($shop);
            $em->flush();

            return new JsonResponse(
                array(
                    'name' => $name,
                    'adress' => $adress,
                )
            );
        } else {
            throw new AccessDeniedHttpException();
        }
    }


}