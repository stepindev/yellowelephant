<?php
// src/Acme/QuestionsBundle/Form/Type/QuestionParameterType.php
namespace Acme\FeedbackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Genemu\Bundle\FormBundle\Form\JQuery\Type\SliderType;
// use Genemu\Bundle\FormBundle\Form\JQuery\Type;

class QuestionParameterType extends AbstractType
{   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $aQuestionData = $options["data"]->get();
        foreach ($aQuestionData as $sKeyQuestionData => $aValueQuestionData) 
        {               
            switch($aValueQuestionData['type'])
            {
                case 'slider':                                                            
                    $builder->add($sKeyQuestionData,'text',array("label"=>$aValueQuestionData["label"],'attr' => array('class' => 'slider')));
                break;    
                default:
                    $builder->add($sKeyQuestionData,$aValueQuestionData['type'],array("label"=>$aValueQuestionData["label"]));
                break;    
            }            
                        
        }
        $builder->add('save', 'submit');
    }

    public function getName()
    {
        return 'questions';   
    }

    
}