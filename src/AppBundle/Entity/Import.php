<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Import entity
 *
 * @author Haffoudhi
 *
 * @Vich\Uploadable
 */
class Import
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $import;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    private $importOriginalName = 'Import';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="document", fileNameProperty="import")
     */
    private $importFile;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getImport()
    {
        return $this->import;
    }

    /**
     *
     * @param string $import
     * @return \AppBundle\Entity\Import
     */
    public function setImport($import)
    {
        $this->import = $import;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getImportFile()
    {
        return $this->importFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $import
     *
     * @return $this
     */
    public function setImportFile(File $import = null)
    {
        $this->importFile = $import;
        if ($import) {
            if ($import instanceof UploadedFile) {
                $this->importOriginalName = $import->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getImportOriginalName()
    {
        return $this->importOriginalName;
    }

    /**
     * @param string $importOriginalName
     * @return \AppBundle\Entity\Import
     */
    public function setImportOriginalName($importOriginalName)
    {
        $this->importOriginalName = $importOriginalName;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->importOriginalName;
    }
}
