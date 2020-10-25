<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require dirname(__DIR__) . '/vendor/autoload.php';

$routeCollection = new RouteCollection();
$routeCollection->add(
    'home',
    new Route(
        '/',
        [
            '_controller' => function() {
                return new Response('Hi!');
            },
        ]
    )
);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(
    new RouterListener(
        new UrlMatcher($routeCollection, new RequestContext()),
        new RequestStack()
    )
);

(new HttpKernel($dispatcher,new ControllerResolver()))
    ->handle(Request::createFromGlobals())
    ->send()
;
