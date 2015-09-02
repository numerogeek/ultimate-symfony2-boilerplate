<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\ProfileController as FosProfileController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends FosProfileController
{
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $balanceManager = $this->container->get('balance_manager_service');

        $operations = $balanceManager->getOperations();
        $credit = $balanceManager->getCredit();

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'), compact('user', 'credit', 'operations'));
    }
}
