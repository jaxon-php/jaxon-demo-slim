<?php

use Demo\Ajax\App\Test as AppTest;
use Demo\Ajax\App\Buttons as AppButtons;
use Demo\Ajax\Ext\Test as ExtTest;
use Demo\Ajax\Ext\Buttons as ExtButtons;
use Jaxon\Exception\RequestException;
use Jaxon\Slim\Helper;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Always load the Jaxon global functions.
jaxon()->setAppOption('helpers.global', true);

// Jaxon middleware to load config
// Set a container if you need to use its services in Jaxon classes.
// Set a logger if you need to send messages to your logs in Jaxon classes.
$jaxonConfigMiddleware = fn(Request $request, RequestHandler $handler) =>
    jaxon()->psr()
        // Uncomment the following line to set a container
        // ->container($container)
        // Uncomment the following line to set a logger
        // ->logger($logger)
        ->view('slim', '.html.twig', fn() => Helper::twigView($request))
        ->config(__DIR__ . '/../config/jaxon.php')
        ->process($request, $handler);

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
$app->addRoutingMiddleware();

// Create Twig
$twig = Helper::twig(__DIR__ . '/../templates', ['cache' => false]);
// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Process Jaxon ajax requests
$app->group('/', function() use($app) {
    /**
     * Jaxon middleware to process ajax requests
     *
     * @throws RequestException
     */
    $jaxonAjaxMiddleware = fn(Request $request, RequestHandler $handler) =>
        jaxon()->psr()->ajax()->process($request, $handler);

    $app->post('/jaxon', function($request, $response) {
        // Todo: return an error. Jaxon could not find a plugin to process the request.
    })->add($jaxonAjaxMiddleware);

    // Insert Jaxon codes in the page
    $app->get('/', function($request, $response) {
         // Display the page
        $view = Twig::fromRequest($request);

        return $view->render($response, 'demo/index.html.twig', [
            'pageTitle' => "Slim Framework",
            'rqAppTest' => rq(AppTest::class),
            'rqAppButtons' => rq(AppButtons::class),
            'rqExtTest' => rq(ExtTest::class),
            'rqExtButtons' => rq(ExtButtons::class),
        ]);
    });
})->add($jaxonConfigMiddleware);

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();
