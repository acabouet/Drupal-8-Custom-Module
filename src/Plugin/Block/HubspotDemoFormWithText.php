<?php
/**
 * Created by PhpStorm.
 * User: adriennecabouet
 * Date: 12/18/17
 * Time: 2:19 PM
 */

namespace Drupal\lavu_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides HubspotDemoWithTextForm block.
 *
 * @Block(
 *   id = "hubspot_demo_form_text_block",
 *   admin_label = @Translation("Hubspot Demo Form With Text block"),
 *   category = @Translation("Hubspot Forms")
 * )
 */

class HubspotDemoFormWithText extends BlockBase {

  /**
   *  {@inheritdoc}
   */
  public function build(){
    return [
      '#theme' => 'hubspot_demo_form_text'
    ];
  }

}
