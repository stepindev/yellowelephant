<?php

namespace Acme\FeedbackBundle\Entity;

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
            //if(array_key_exists('order_name',$aParameters)) $this->orderId = ;
            foreach ($aParameters as $oQuestionValue) 
            {
                $nQuestionId = $oQuestionValue->getIdQuestion();
                $this->data[$nQuestionId] = array('id_queston'=>$nQuestionId,"label" => $oQuestionValue->getQuestionName(), "value" => "",'type'=>$oQuestionValue->getQuestionType());
                $this->{$nQuestionId} = "";
            }
        }
    }
    public function get() 
    {
        return $this->data;
    }
}