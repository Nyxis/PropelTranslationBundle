<?php

namespace Propel\TranslationBundle\Controller;

use Propel\TranslationBundle\Util\JQGrid\Mapper;
use Propel\TranslationBundle\Form\TranslationKeyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

/**
* Translations edition controlller.
*
* @author Cédric Girard <c.girard@lexik.fr>
*/
class EditionController extends Controller
{
    /**
     * List translation keys element in json format.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $locales = $this->getManagedLocales();
        $dataManager = $this->get('propel.translation.data_manager');

        $keysList = $dataManager->getKeysList(
            $locales,
            $this->get('request')->query->get('rows', 20),
            $this->get('request')->query->get('page', 1),
            $this->get('request')->query->all()
        );

        $jqGridMapper = new Mapper(
            $this->get('request'),
            $keysList,
            $dataManager->countKeys($locales, $this->get('request')->query->all())
        );

        $response = new Response($jqGridMapper->generate($locales));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Display a javascript grid to edit trans unit elements.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gridAction()
    {
        return $this->render('PropelTranslationBundle:Edition:grid.html.twig', array(
            'layout' => $this->container->getParameter('propel.translation.base_layout'),
            'inputType' => $this->container->getParameter('propel.translation.grid_input_type'),
            'locales' => $this->getManagedLocales()
        ));
    }

    /**
     * Update a trans unit element from the javascript grid.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $result = array();

            if ('edit' == $request->request->get('oper')) {

                try {
                    $data = array_intersect_key(
                        $request->request->all(),
                        array_flip($this->getManagedLocales())
                    );

                    $this->get('propel.translation.data_manager')
                        ->updateTranslationKey($request->request->get('id'), $data);

                } catch (\IllegalArgumentException $e) {
                    throw new NotFoundHttpException($e->getMessage());
                }

                $result['success'] = true;
            }

            return new Response(json_encode($result));
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Remove cache files for managed locales.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function invalidateCacheAction()
    {
        $this->get('propel.translation.cache_manager')->removeLocalesFiles(
            $this->getManagedLocales()
        );

        $this->get('session')->setFlash('success', 'Le cache a été vidé.');

        return $this->redirect($this->generateUrl('propel_translation_grid'));
    }

    /**
     * Add a new trans unit with translation for managed locales.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $dataManager = $this->get('propel.translation.data_manager');
        $translationKey = $dataManager->createTranslationKey($this->getManagedLocales());

        $options = array(
            'domains' => $dataManager->getAllDomains(),
            'data_class' => $dataManager->getModelClassName('translation_key'),
            'translation_content_class' => $dataManager->getModelClassName('translation_content'),
        );

        $form = $this->createForm(new TranslationKeyType(), $translationKey, $options);

        if ($this->get('request')->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if ($form->isValid()) {

                $dataManager->saveTranslationKey($translationKey);

                return $this->redirect($this->generateUrl('propel_translation_grid'));
            }
        }

        return $this->render('PropelTranslationBundle:Edition:new.html.twig', array(
            'layout' => $this->container->getParameter('propel.translation.base_layout'),
            'form' => $form->createView(),
        ));
    }

    /**
     * Returns managed locales.
     *
     * @return array
     */
    protected function getManagedLocales()
    {
        return $this->container->getParameter('propel.translation.managed_locales');
    }
}
