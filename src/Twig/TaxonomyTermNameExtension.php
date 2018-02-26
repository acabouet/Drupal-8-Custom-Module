<?php
/**
 * Created by PhpStorm.
 * User: Adrienne
 * Date: 1/25/18
 * Time: 6:22 PM
 */

namespace Drupal\lavu_custom\Twig;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Link;
use Drupal\Core\Url;


class TaxonomyTermNameExtension extends \Twig_Extension {

  /**
   * @return array
   */
  public function getFunctions()
  {
    return [
      new \Twig_SimpleFunction('getTerms', [$this, 'getTerms'])
    ];
  }

  /**
   * Provides function to programmatically return terms in a given taxonomy vocabulary by name.
   *
   * @param String $vocab_name
   *  The name of taxonomy vocabulary to render
   *
   * @return array
   */
  public function getTerms($vocab_name) {
    $vocabulary_name = $vocab_name; //name of your vocabulary
    $query = \Drupal::entityQuery('taxonomy_term');
    $query->condition('vid', $vocabulary_name);
    $query->sort('weight');
    $tids = $query->execute();
    $terms = Term::loadMultiple($tids);
    $output = '<ul class="integration-filters"><li><a class="*" href="">All Integrations</a></li>';
    foreach($terms as $term) {
      $name = $term->getName();;
      $output .='<li><a class="'.str_replace(' ', '', $name).'" href="">'.$name.'</a></li>';
    }
    $output .= '</ul>';
    print $output;
  }

}
