<?php

namespace Acme\FeedbackBundle\Entity;
/**
 * Jaimin: extra after slider works its removed 
 */
class QuestionParameter 
{

    protected $data;

    public function __construct($aParameters, $bEdit = false) 
    {
        //echo $value->getIdQuestion();
        //echo $value->getQuestionName();
        //echo $value->getQuestionType();
        if($aParameters)
        { 
            //if(array_key_exists('order_name',$aParameters)) $this->ordgetQuestionNameerId = ;            
            foreach ($aParameters as $sKeyQuestion => $oQuestionValue) 
            {
               // $nQuestionId = $oQuestionValue->getIdQuestion();
                $sQuestionName = $oQuestionValue->getDisplayText();
                $this->data[$sQuestionName] = array('id_queston'=>$oQuestionValue->getIdQuestion(),"label" => $oQuestionValue->getQuestionName(), "value" => "",'type'=>$oQuestionValue->getQuestionType());
                $this->{$sQuestionName} = "";
            }
        }
    }
    public function get() 
    {
        return $this->data;
    }
}