<?php

namespace Acme\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributeValues
 */
class AttributeValues
{
    /**
     * @var integer
     */
    private $idAttributeValue;

    /**
     * @var string
     */
    private $attributeValue;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var boolean
     */
    private $deleted;

    /**
     * @var \Acme\FeedbackBundle\Entity\Questions
     */
    private $idQuestion;


    /**
     * Get idAttributeValue
     *
     * @return integer 
     */
    public function getIdAttributeValue()
    {
        return $this->idAttributeValue;
    }

    /**
     * Set attributeValue
     *
     * @param string $attributeValue
     * @return AttributeValues
     */
    public function setAttributeValue($attributeValue)
    {
        $this->attributeValue = $attributeValue;

        return $this;
    }

    /**
     * Get attributeValue
     *
     * @return string 
     */
    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return AttributeValues
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return AttributeValues
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return AttributeValues
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set idQuestion
     *
     * @param \Acme\FeedbackBundle\Entity\Questions $idQuestion
     * @return AttributeValues
     */
    public function setIdQuestion(\Acme\FeedbackBundle\Entity\Questions $idQuestion = null)
    {
        $this->idQuestion = $idQuestion;

        return $this;
    }

    /**
     * Get idQuestion
     *
     * @return \Acme\FeedbackBundle\Entity\Questions 
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }
}
