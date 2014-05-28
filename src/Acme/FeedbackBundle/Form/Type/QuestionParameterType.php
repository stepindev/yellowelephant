<?php
// src/Acme/QuestionsBundle/Form/Type/QuestionParameterType.php
namespace Acme\FeedbackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
class QuestionParameterType extends AbstractType
{   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
        $fieldOptions = array();
        foreach ($options['data'] as $aQuestion) 
        {
            $oValidation =  json_decode($aQuestion['validations']);
            if(isset($oValidation->is_required))
            {    
                $fieldOptions = array('constraints' => new NotBlank());
            }
            else if(isset($oValidation->email))
            {
                $email = new Email();
                $email->message = 'Invalid email address';
                $fieldOptions = array('constraints' => $email);
            }    
            // Current form field attributes
            $sFieldName = $aQuestion['display_text'];
            $sQuestionName = $aQuestion['question_name'];
            $sQuestionType = $aQuestion['question_type']; 
            
            /*
             * Quey change then use questin object
                $sFieldName = $oQuestion->getDisplayText();
                $sQuestionName = $oQuestion->getQuestionName();
                $sQuestionType = $oQuestion->getQuestionType();            
             */
            switch($sQuestionType)
            {
                case 'slider':
                    $sQuestionType = 'genemu_jqueryslider';
                break;    
                case 'choice':                    
                    //value and display text same use for array_combine
                    $fieldOptions['choices'] = array_combine(explode(",",$aQuestion['attribute_value']), explode(",",$oQuestion['attribute_value']) );
                break;    
            }
            $fieldOptions = array("label"=>$sQuestionName)+$fieldOptions;
            // build the form fields
            $builder->add($sFieldName, $sQuestionType, $fieldOptions);
        }
        $builder->add('save', 'submit');
    }
    public function getName()
    {
        return 'feedbackquestions';   
    }
}