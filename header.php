<?php 

/* NOTE:
 * plugin dokan-lite requires these files to exist: header.php footer.php
 * Let's copy structure from index.php and layout/app
 * Then render blade views
 *
 * */ 

?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

<div class="flex-1 flex flex-col relative bg-white">

  <a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
  </a>

    <?php echo \Roots\view('partials.header')->render(); ?>

    <main id="main" class="main mx-auto flex-1 w-full">
