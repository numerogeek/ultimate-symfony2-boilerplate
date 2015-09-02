<?php

namespace AppBundle\EventListener;

use DRMS\CoreBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;

class AdminMenuItemListener
{
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request)
    {
        $earg = array();

        $rootItems = array(
            $home = new MenuItemModel('home', 'Accueil', 'DRMSCoreBundle_B2B_Dashboard_index', $earg, 'fa fa-home'),
            $repairRequest = new MenuItemModel('repair', 'Gestion des réparations', 'drms_repair_request_repairrequest_index', $earg, 'fa fa-wrench'),
            $sendings = new MenuItemModel('sending', 'Gestions des envois', 'DRMSCoreBundle_B2B_Dashboard_index', $earg, 'fa fa-fighter-jet'),
            $ui = new MenuItemModel('retour', 'Liste des retours', 'DRMSCoreBundle_B2B_Dashboard_index', $earg, ' fa fa-exchange'),
        );

        $repairRequest->addChild(new MenuItemModel('ui-elements-general', 'Lister les réparations', 'DRMSCoreBundle_B2B_Dashboard_index', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', 'Créer une réparation', 'DRMSCoreBundle_B2B_Dashboard_index', $earg));

        return $this->activateByRoute($request->get('_route'), $rootItems);
    }

    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) { /** @var $item MenuItemModel */
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }
}
