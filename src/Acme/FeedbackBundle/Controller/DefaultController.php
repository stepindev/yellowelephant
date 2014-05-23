<?php

namespace Acme\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\FeedbackBundle\Entity\Questions;
use Acme\FeedbackBundle\Entity\FeedbackAnswers;
use Acme\FeedbackBundle\Entity\Orders;
use Acme\FeedbackBundle\Form\Type\QuestionParameterType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $oRequest
     * @return type
     */
    public function orderAction(Request $oRequest) 
    {
        $session = $oRequest->getSession();
        $session->clear();
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
            return $this->redirect($this->generateUrl('acme_feedback_homepage'));
        }
        return $this->render('AcmeFeedbackBundle:Default:order.html.twig', array('form' => $oForm->createView()));
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
            if(!$aFeedBackAns)
            {    
                $em = $this->getDoctrine()->getManager();
                $aQuestions = $em->getRepository('AcmeFeedbackBundle:Questions')
                                ->findByPage($page);
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
                            $nIdQuestion = $aQuestionList->getIdQuestion();
                            $sDisplayText = $aQuestionList->getDisplayText();
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

                        return $this->redirect($this->generateUrl('acme_feedback_homepage', array('page' => $page), true));                        
                       
                    }
                }
                if (!$aQuestions) {
                    throw $this->createNotFoundException(
                            'No data found '
                    );
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
                throw $this->createNotFoundException(
                        'Feedback is exists for current order '
                );
            }    
    }
    /**
     * 
     * @return type
     */
    public function thankuAction()
    {
        return $this->render('AcmeFeedbackBundle:Default:thanku.html.twig',array());
    }        
    
}
