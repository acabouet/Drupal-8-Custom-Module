<?php

namespace Drupal\lavu_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides HubspotBlogForm block.
 *
 * @Block(
 *   id = "hubspot_blog_form_block",
 *   admin_label = @Translation("Hubspot Blog Form block"),
 *   category = @Translation("Hubspot Forms")
 * )
 */

class HubspotBlogForm extends BlockBase {

  /**
   *  {@inheritdoc}
   */
  public function build(){
    return [
      '#theme' => 'hubspot_blog_form'
    ];
  }
}
