<?php

namespace AdminBundle\EventListener;

use AdminBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;

class MenuItemListener
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
            $home = new MenuItemModel('home', 'Home', 'AdminBundle_Default_index', $earg, 'fa fa-home'),
            $blog = new MenuItemModel('blog', 'Blog', '', $earg, 'fa fa-pencil'),
            $user = new MenuItemModel('users', 'Users', '', $earg, 'fa fa-users'),
        );

        $blog->addChild(new MenuItemModel('ui-elements-general', 'Liste des articles', 'blog_admin_post', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', 'Créer un article', 'blog_admin_post_new', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', 'Liste des catégories', 'blog_admin_category', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', 'Créer une catégorie', 'blog_admin_category_new', $earg));

        $user
            ->addChild(new MenuItemModel('ui-elements-general', 'Liste des utilisateurs', 'user_admin_user', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', 'Créer un utilisateur', 'user_admin_user_new', $earg));

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
