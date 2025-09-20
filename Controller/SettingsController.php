<?php

namespace Skynettechnologies\Bundle\AllInOneAccessibilityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends AbstractController
{
    
    public function indexAction(): Response
    {
        return $this->render('@SkynettechnologiesAllInOneAccessibility/Settings/index.html.twig', [
            'title' => 'All-in-One Accessibility Settings',
        ]);
    }
}
