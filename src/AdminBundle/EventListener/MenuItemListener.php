<?php

namespace AdminBundle\EventListener;

use AdminBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class MenuItemListener
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
            $home = new MenuItemModel('home', $this->translator->trans('menu.home'), 'adminbundle_default_index', $earg, 'fa fa-home'),
            $blog = new MenuItemModel('blog', $this->translator->trans('menu.blog'), '', $earg, 'fa fa-pencil'),
            $user = new MenuItemModel('users', $this->translator->trans('menu.user'), '', $earg, 'fa fa-users'),
        );

        $blog->addChild(new MenuItemModel('ui-elements-general', $this->translator->trans('blog.article.menu.list'), 'blog_admin_post', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', $this->translator->trans('blog.article.menu.create'), 'blog_admin_post_new', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', $this->translator->trans('blog.category.menu.list'), 'blog_admin_category', $earg))
            ->addChild(new MenuItemModel('ui-elements-general', $this->translator->trans('blog.category.menu.create'), 'blog_admin_category_new', $earg));

        $user
            ->addChild(new MenuItemModel('ui-elements-general', $this->translator->trans('user.list'), 'user_admin_user', $earg))
            ->addChild(new MenuItemModel('ui-elements-general',  $this->translator->trans('user.create'), 'user_admin_user_new', $earg));

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
