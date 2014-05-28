<?php

namespace Acme\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\FeedbackBundle\Entity\Questions;
use Acme\FeedbackBundle\Entity\FeedbackAnswers;
use Acme\FeedbackBundle\Entity\Orders;
use Acme\FeedbackBundle\Entity\AttributeValues;
use Acme\FeedbackBundle\Form\Type\QuestionParameterType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {
    
    public function authenticateAction(Request $oRequest)
    {
        //$t = $this->get('translator')->trans('new_feedback');
        //return new Response ( $t );
        //exit;
    
        $oForm = $this->createFormBuilder()
                ->setAction($this->generateUrl('acme_authenticate'))
                ->setMethod('POST')
                ->add('admin_key', 'text')
                ->add('save', 'submit')
                ->getForm();
        
        if ('POST' === $oRequest->getMethod()) 
        {
            $oSession = $oRequest->getSession();
            $oForm->bind($this->getRequest());
            $aFormAuth = $oForm->getData();
            $oSession->set('auth_key', $aFormAuth['admin_key']);
            return $this->redirect($this->generateUrl('acme_target_route'));
        }
        return $this->render('AcmeFeedbackBundle:Default:authenticate.html.twig', array('form' => $oForm->createView()));
    }        

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $oRequest
     * @return type
     */
    public function orderAction(Request $oRequest) 
    {
        $session = $oRequest->getSession();
        $session->remove('orders');
        $sAuthKey = $session->get('auth_key');
        if(count($sAuthKey)>0)
        {    
            $oOrder = new Orders();
            $oForm = $this->createFormBuilder($oOrder)
                    ->setAction($this->generateUrl('acme_target_route'))
                    ->setMethod('POST')
                    ->add('order_name', 'text')
                    ->add('save', 'submit')
                    ->getForm();
            if ('POST' === $oRequest->getMethod()) 
            {
                $oForm->bind($this->getRequest());
                $aFormOrders = $oForm->getData();
                $question_array['id_order'] = $aFormOrders->getOrderName();
                $session->set('orders', $question_array);
                return $this->redirect($this->generateUrl('acme_feedback'));
            }
            return $this->render('AcmeFeedbackBundle:Default:order.html.twig', array('form' => $oForm->createView()));
        }
        return $this->redirect($this->generateUrl('acme_authenticate'));
    }
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $oRequest
     * @param type $page
     * @return type
     * @throws type
     */
    public function indexAction(Request $oRequest, $page = 1) 
    {        
            $session = $oRequest->getSession();
            $aSessionOrders = $session->get('orders');
           
            $aQuestionSet = array();

            $aFeedBackAns = $this->getDoctrine()
                                ->getRepository('AcmeFeedbackBundle:FeedbackAnswers')
                                ->findByIdOrder($aSessionOrders['id_order']);
            if(count($aSessionOrders)>0)
            {
                if(!$aFeedBackAns)
                {    
                    $em = $this->getDoctrine()->getManager();
                    $oConn = $em->getConnection();
                    $sql  = 'SELECT 
                                    q.*, 
                                    group_concat(av.attribute_value) as attribute_value  
                             FROM 
                                    questions q
                             LEFT JOIN 
                                    attribute_values av
                             ON
                                    q.id_question = av.id_question
                             WHERE
                                    q.page=:page
                             GROUP By 
                                    q.id_question';
                    $statement = $oConn->prepare($sql);
                    $statement->bindValue('page', $page);
                    $statement->execute();
                    $aQuestions = $statement->fetchAll();

                    $page = $page + 1;
                    $oForm = $this->createForm(new QuestionParameterType(), $aQuestions);
                    $configs = array('min'=>1,'max'=>10, 'step'=>1, 'orientation'=>'horizontal');
                    $aQuestionSet = $session->get('questionSet');

                    if ('POST' === $oRequest->getMethod()) {
                        $oForm->bind($this->getRequest());
                        if ($oForm->isValid()) 
                        {
                            foreach($aQuestions AS $aQuestionList)
                            {
                                $nIdQuestion = $aQuestionList['id_question'];
                                $sDisplayText = $aQuestionList['display_text'];
                                $sAnswerValue= $oForm->get($sDisplayText)->getData();
                                $question_array[$nIdQuestion] = $sAnswerValue;
                            }
                            // set and get session attributes                        
                            if (empty($aQuestionSet)) {
                                $session->set('questionSet', $question_array);
                            } else {
                                $aSessionQuestionSet = $aQuestionSet + $question_array;
                                $session->set('questionSet', $aSessionQuestionSet);
                            }
                            if ($page > 2) {
                                $aSessionQuestionSet = $session->get('questionSet');
                                foreach ($aSessionQuestionSet as $nIdQuestion => $sAnswerValue) {
                                    $entity = new FeedbackAnswers();
                                    $entity->setIdOrder($aSessionOrders['id_order']);
                                    $entity->setIdQuestion($nIdQuestion);
                                    $entity->setAnswer($sAnswerValue);
                                    $entity->setCreatedAt(new \DateTime());
                                    $entity->setUpdatedAt(new \DateTime());
                                    $entity->setDeleted(0);
                                    $em->persist($entity);
                                }
                                $em->flush();
                                $session->remove('questionSet');
                                return $this->redirect($this->generateUrl('acme_thankyou'));
                            }

                            return $this->redirect($this->generateUrl('acme_feedback', array('page' => $page), true));                        

                        }
                    }
                    if (!$aQuestions) 
                    {
                        $sMessage = $this->get('translator')->trans('no_data_found');
                        return new Response($sMessage);                    
                    }                
                    $view = $oForm->createView();
                    $sFormName = $view->vars['id'];
                    return $this->render('AcmeFeedbackBundle:Default:index.html.twig', 
                                            array(
                                                    'aQuestions'=>$aQuestions,
                                                    'form' => $oForm->createView(),
                                                    'sFormName'=>$sFormName,
                                                    'configs'=>$configs,
                                                    'value'=>5
                                                 )
                                        );
                }
                else
                {
                    $sMessage = $this->get('translator')->trans('feedback_exists');
                    return new Response($sMessage);
                }
            }
            else
            {
                return $this->redirect($this->generateUrl('acme_target_route'));
            }
    }
    /**
     * 
     * @return type
     */
    public function thankuAction(Request $oRequest)
    {
        $session = $oRequest->getSession();
        $session->clear();
        return $this->render('AcmeFeedbackBundle:Default:thanku.html.twig',array());
    }        
    
}
