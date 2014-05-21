<?php

namespace Acme\FeedbackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 */
class Questions
{
    /**
     * @var integer
     */
    private $idQuestion;

    /**
     * @var string
     */
    private $questionName;

    /**
     * @var string
     */
    private $questionType;

    /**
     * @var boolean
     */
    private $isRequired;

    /**
     * @var string
     */
    private $page;

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
     * Get idQuestion
     *
     * @return integer 
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * Set questionName
     *
     * @param string $questionName
     * @return Questions
     */
    public function setQuestionName($questionName)
    {
        $this->questionName = $questionName;

        return $this;
    }

    /**
     * Get questionName
     *
     * @return string 
     */
    public function getQuestionName()
    {
        return $this->questionName;
    }

    /**
     * Set questionType
     *
     * @param string $questionType
     * @return Questions
     */
    public function setQuestionType($questionType)
    {
        $this->questionType = $questionType;

        return $this;
    }

    /**
     * Get questionType
     *
     * @return string 
     */
    public function getQuestionType()
    {
        return $this->questionType;
    }

    /**
     * Set isRequired
     *
     * @param boolean $isRequired
     * @return Questions
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * Get isRequired
     *
     * @return boolean 
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * Set page
     *
     * @param string $page
     * @return Questions
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return string 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Questions
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
     * @return Questions
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
     * @return Questions
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
}
