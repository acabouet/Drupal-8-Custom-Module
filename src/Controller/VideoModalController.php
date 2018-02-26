<?php
/**
 * Created by PhpStorm.
 * User: adriennecabouet
 * Date: 2/14/18
 * Time: 1:01 PM
 */

namespace Drupal\lavu_custom\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenDialogCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\paragraphs\Entity\Paragraph;

class VideoModalController extends ControllerBase {

  /**
   * @return AjaxResponse
   */
  public function videoCallback($pid) {
    $paragraph = Paragraph::load($pid);
    $videoField = $paragraph->get('field_video');
    $video = $videoField->view();
    $html = "<div class='videoWrapper' id='videoWithJs'>". render($video) ."</div>";

    $options = [
      'dialogClass' => 'video-modal',
      'width' => '750px',
    ];

    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand(t('Lavu iPad POS'), $html, $options));
    return $response;
  }

}
