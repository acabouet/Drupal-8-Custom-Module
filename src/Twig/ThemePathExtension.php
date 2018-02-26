<?php
/**
 * Created by PhpStorm.
 * User: adriennecabouet
 * Date: 12/5/17
 * Time: 12:53 PM
 */

namespace Drupal\lavu_custom\Twig;

class ThemePathExtension extends \Twig_Extension {
  /**
   * @return array
   */
  public function getFunctions()
  {
    return [
      new \Twig_SimpleFunction('themePath', [$this, 'themePath'])
    ];
  }

  /**
   * Provides function to print out the indicated theme path
   *
   * @param String $menu_name
   *  The machine configuration id of the menu to render
   *
   * @return string
   */
  public function themePath($theme_name){
    $theme_path = drupal_get_path('theme', $theme_name);
    return $theme_path;
  }

}
