<?php
/**
 * Created by PhpStorm.
 * User: adriennecabouet
 * Date: 11/28/17
 * Time: 10:51 AM
 */

namespace Drupal\lavu_custom\Twig;

class RenderMenuExtension extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('renderMenu', [$this, 'renderMenu'])
        ];
    }

    /**
     * Provides function to programmatically rendering a menu
     *
     * @param String $menu_name
     *  The machine configuration id of the menu to render
     *
     * @return array
     */
    public function renderMenu($menu_name) {
        $menu_tree = \Drupal::menuTree();

        // Build the typical default set of menu tree parameters.
        $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

        // Load the tree based on this set of parameters.
        $tree = $menu_tree->load($menu_name, $parameters);

        // Transform the tree using the manipulators you want.
        $manipulators = array(
            // Only show links that are accessible for the current user.
            array('callable' => 'menu.default_tree_manipulators:checkAccess'),
            // Use the default sorting of menu links.
            array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
            // Flatten the menu structure
            array('callable' => 'menu.default_tree_manipulators:flatten')
        );
        $tree = $menu_tree->transform($tree, $manipulators);

        // Finally, build a renderable array from the transformed tree.
        $menu = $menu_tree->build($tree);

        $menu['#attributes']['class'] = 'menu ' . $menu_name;

        return array('#markup' => \Drupal::service('renderer')->render($menu));
    }
}