<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class HelloRssController extends ControllerBase {
  public function content() {
    $response = new Response();
    
    $response->headers->set('Content-Type', 'text/xml');
    
    $response->setContent('<?xml version="1.0" encoding="UTF-8"?><xml><test>Bonjour</test></xml>');
    
    return $response;
  }
}
