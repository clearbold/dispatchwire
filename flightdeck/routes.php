<?php

use \FlightDeck\Console as Console;
use \FlightDeck\EmailTemplate as EmailTemplate;

$view = $app->view();
$view->parserOptions = array(
    // This Twig setting needs to move into config
    'debug' => true,
    'cache' => FLIGHTDECK_PATH . '/cache'
);
$view->twigTemplateDirs = array(
    FLIGHTDECK_PATH . '/app/templates'
);

/**
 * Default page, loads list of email templates
 * @return rendered Twig template as HTML
 */
$app->get('/', function () use ($app)
{

    $app->render('email-template-list.html', array( 'file_tree' => Console::listEmailTemplates() ));

});

/**
 * Build (& Test) URL called for a template
 * @param string  $requestedTemplate  modified path to template to build & test
 * @throws
 * @return JSON  status + build datetime
 */
$app->get('/build/:template', function($requestedTemplate) use ($app)
{

    $template = new EmailTemplate;

    $app->response->headers->set('Content-Type', 'application/json');
    echo json_encode($template->buildEmailTemplate(filter_var($requestedTemplate, FILTER_SANITIZE_STRING)));

});