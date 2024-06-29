<?php

namespace CReifenscheid\DummyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2023 Christian Reifenscheid
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class Modelname extends AbstractEntity
{
    /**
     * @\TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @\TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"maximum": 255})
     */
    protected string $string = ''; 

    /**
     * @var null|\TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?ObjectStorage $references = null;

    public function __construct()
    {
        $this->initStorageObjects();
    }

    public function initStorageObjects(): void
    {
        $this->references = new ObjectStorage();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getReferences(): ObjectStorage
    {
        return $this->references;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $references
     */
    public function setReferences(ObjectStorage $references): void
    {
        $this->references = $references;
    }

    public function addReference(FileReference $referenceToAdd): void
    {
        $this->references->attach($referenceToAdd);
    }

    public function removeReference(FileReference $referenceToRemove): void
    {
        $this->references->detach($referenceToRemove);
    }
}
