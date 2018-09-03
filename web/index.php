<?php

/**
 * Archivo de autocarga
 */
require_once __DIR__.'/../vendor/autoload.php';

use Controller\Generic;
/**
 * Creamos objeto Silex\Application
 */
$app = new Silex\Application();
/**
 * Activando debug
 */
$app['debug'] = true;
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app['oauth'] = $app->share(function() use($app){
    $gen = new Generic();
    $oauth = $gen->Auth($app['url_generator']->generate('callback', array(), true));
    return $oauth;
});

/**
 * definicion de ruta quizas esto se puede agregar en un archivo routes
 * para mantener controladas todas las rutas
 */
$app->get('/ssot/auth/', function () use ($app) {
    $oauth = $app['session']->get('oauth');

    if (empty($oauth)) {
        $priorities = null;
    } else {
        $priorities = $app['oauth']->getClient(
            $oauth['oauth_token'],
            $oauth['oauth_token_secret']
        )->get('rest/api/2/priority')->send()->json();
    }

    return $app['twig']->render('layout.twig', array(
        'oauth' => $oauth,
        'priorities' => $priorities,
    ));
})->bind('home');

$app->get('/connect', function() use($app){

    $token = $app['oauth']->requestTempCredentials();
    $app['session']->set('oauth', $token);

    return $app->redirect(
        $app['oauth']->makeAuthUrl()
    );
})->bind('connect');

$app->get('/reset', function() use($app){

    $app['session']->set('oauth', null);

    return $app->redirect(
        $app['url_generator']->generate('home',['user'=>'reset'])
    );
})->bind('reset');

$app->get('/callback', function() use($app){

    $verifier = $app['request']->get('oauth_verifier');

    if (empty($verifier)) {
        throw new \InvalidArgumentException("There was no oauth verifier in the request");
    }

    $tempToken = $app['session']->get('oauth');

    $token = $app['oauth']->requestAuthCredentials(
        $tempToken['oauth_token'],
        $tempToken['oauth_token_secret'],
        $verifier
    );

    $app['session']->set('oauth', $token);

    return $app->redirect(
        $app['url_generator']->generate('home')
    );
})->bind('callback');

$app->run();