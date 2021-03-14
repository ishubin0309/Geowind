<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rappel entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class Rappel
{
    
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id = 1;

    /**
     * @var ArrayCollection|RappelData[]
     *
     * @ORM\OneToMany(targetEntity="RappelData", mappedBy="rappel", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $datas;

    public function __construct()
    {
        $this->datas = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|Data[]
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * @param \AppBundle\Entity\RappelData $data
     */
    public function addData(RappelData $data)
    {
        if (!$this->datas->contains($data)) {
            $data->setRappel($this);
            $this->datas[] = $data;
        }
        return $this;
    }

    /**
     * @param \AppBundle\Entity\RappelData $data
     */
    public function removeData(RappelData $data)
    {
        $this->datas->removeElement($data);
    }

    /**
     * @param ArrayCollection $datas
     * @return \AppBundle\Entity\Rappel
     */
    public function setDatas(ArrayCollection $datas)
    {
        $this->datas = $datas;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'rappel';
    }
}
