<?php
// src/Acme/QuestionsBundle/Form/Type/QuestionParameterType.php
namespace Acme\FeedbackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionParameterType extends AbstractType
{   
    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $aQuestionData = $options["data"]->get();        
        
        foreach ($aQuestionData as $sKeyQuestionData => $aValueQuestionData) 
        {   
            switch($aValueQuestionData['type'])
            {
                case 'slider':
                    $aValueQuestionData['type'] = 'genemu_jqueryslider';
                break;    
            
            }            
            
            $builder->add($sKeyQuestionData,$aValueQuestionData['type'],array("label"=>$aValueQuestionData["label"]));            
        }
        $builder->add('save', 'submit');
    }*/
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['data'] as $question) 
        {
            // Current form field attributes
            $sFieldName = $question->getDisplayText();
            $sQuestionName = $question->getQuestionName();
            $sQuestionType = $question->getQuestionType();            
            switch($sQuestionType)
            {
                case 'slider':
                    $sQuestionType = 'genemu_jqueryslider';
                break;    
            
            }
            // build the form fields
            $builder->add($sFieldName, $sQuestionType, array("label"=>$sQuestionName));
        }
        $builder->add('save', 'submit');
        
    }
    public function getName()
    {
        return 'feedbackquestions';   
    }

    
}