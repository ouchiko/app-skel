<?php
namespace somename\controllers;
/**
 * CONTROLLER: Train Controller
 */
use \Slim\Http\Request;
use \Slim\Http\Response;


class API {

    public function something(Request $request, Response $response, $args) {
        return $response->withJSON($dataset);
    }
}