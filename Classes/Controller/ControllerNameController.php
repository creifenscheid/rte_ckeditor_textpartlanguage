<?php

namespace CReifenscheid\DummyExtension\Controller;

use CReifenscheid\DummyExtension\Domain\Model\Modelname;
use CReifenscheid\DummyExtension\Domain\Repository\ModelnameRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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

class ControllerNameController extends ActionController
{
    protected ModelnameRepository $modelnameRepository;

    public function __construct(ModelnameRepository $modelnameRepository)
    {
        $this->modelnameRepository = $modelnameRepository;
    }

    public function listAction(): ResponseInterface
    {
        $this->assignTtContentData();

        $this->view->assign('modelnames', $this->modelnameRepository->findAll());

        return $this->htmlResponse();
    }

    public function showAction(Modelname $modelname): ResponseInterface
    {
        $this->assignTtContentData();

        $this->view->assign('modelname', $modelname);

        return $this->htmlResponse();
    }

    private function assignTtContentData(): void
    {
        $contentObject = $this->configurationManager->getContentObject();
        $this->view->assign('ttContentData', $contentObject->data);
    }
}
