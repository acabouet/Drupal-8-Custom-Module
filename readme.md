# README #

Thanks for reading! This custom Drupal 8 module was created by Adrienne Cabouet for Lavu, Inc. This little module contains a lot of functionality:

* Two custom forms (FreeTrialForm and PartnerReferralForm) built using the Drupal form API. You can find these in `src/Form/` with additional form submit handler logic in `lavu_custom.module`.
* Three custom Twig extensions (RenderMenuExtension, TaxonomyTermNameExtension, and ThemePathExtension). You can find these in `src/Twig/`.
* Three custom blocks containing Hubspot Forms. You can find these in `src/Plugin/Block/`.
* One custom controller that implements the Drupal 8 modal API to show a video entity created using the Paragraphs module to show a youtube video in a modal window. You can find it in `src/Controller/`.
