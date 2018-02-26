<?php
/**
 * Created by PhpStorm.
 * User: adriennecabouet
 * Date: 1/10/18
 * Time: 3:12 PM
 */

namespace Drupal\lavu_custom\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation;
use Drupal\Core\Url;

/**
 * A recreation of the Lavu Free Trial form using the Drupal 8 Form API
 */
class FreeTrialForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'freetrial_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['wrapper'] = array(
      '#type' => 'fieldset',
      '#title' => 'Lavu Free Trial Sign Up',
      '#attributes' => [
        'id' => 'free-trial-wrapper'
      ],
    );

    $form['wrapper']['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#required' => TRUE
    );

    $form['wrapper']['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name'),
      '#required' => TRUE
    );

    $form['wrapper']['business_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Business Name'),
      '#required' => TRUE
    );

    $form['wrapper']['email'] = array(
      '#type' => 'email',
      '#title' => t('Email Address'),
      '#required' => TRUE
    );

    $form['wrapper']['phone_number'] = array (
      '#type' => 'tel',
      '#title' => t('Phone Number'),
      '#required' => TRUE
    );

    $form['wrapper']['actions']['#type'] = 'actions';
    $form['wrapper']['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('phone_number')) < 10) {
      $form_state->setErrorByName('phone_number', $this->t('Phone number is too short.'));
    }
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * Here is the Free Trial endpoint: https://register.poslavu.com/signup
   * and it expects a JSON POST like this one:
   * {
   * "package": "Lavu",
   * "lead_source": "lavu.com nocc signup",
   * "domain": "lavu",
   * "vf_signup": "69cff4ae60b38ad50e902c51d915dee6",
   * "referrer": "none",
   * "utm_campaign": "CollingMedia",
   * "utm_medium": "FreeTrial",
   * "utm_source": "DigitalLead",
   * "theip": "67.134.3.50",
   * "utm_medium": "FreeTrial",
   * "default_menu": "default_restau",
   * "email": "tom@lavu.com",
   * "company": "Lavu Test",
   * "firstname": "Lavu",
   * "lastname": "Test",
   * "address": "116 Central Ave SW, Suite 302",
   * "city": "Albuquerque",
   * "state": "New Mexico",
   * "zip": "87102"
   * }
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Data from form
    $firstname = $form_state->getValue('first_name');
    $lastname = $form_state->getValue('last_name');
    $businessname = $form_state->getValue('business_name');
    $email = $form_state->getValue('email');

    // Clean up the phone number
    $phone =  preg_replace("/[^0-9]/", "", $form_state->getValue('phone_number'));

    // Empty var for Hubspot curl results
    $h_status = '';

    // Connect to Lavu
    $lavudata = send_to_lavu($firstname, $lastname, $businessname, $email, $phone);

    // Connect to Hubspot
    if(is_array($lavudata)) {
      $h_status = send_to_hubspot($lavudata);
    }

    if($h_status === '204' || '302') {
      drupal_set_message($this->t('Thanks! Check your email for credentials and instructions for how to log in to the Lavu app.'));

      $urlObject = \Drupal::service('path.validator')->getUrlIfValid('/thank-you');
      $route_name = $urlObject->getRouteName();
      $route_parameters = $urlObject->getRouteParameters();
      $form_state->setRedirect($route_name, $route_parameters);
      return;
    } else {
      drupal_set_message($this->t('Oh no! There was an error. Please give us a call at 1 (855)-767-5288 to get set up with your free trial.'), 'error');
      return;
    }

  }

  // @TODO this function will ultimately replace the entire form with a message telling the user that their submission was successful and to check their email for Lavu app credentials
  public function replaceForm(array &$form, FormStateInterface $form_state) {

  }
}
