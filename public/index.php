<?php

use Jaxon\Demo\Ajax\Bts;
use Jaxon\Demo\Ajax\Pgw;
use Jaxon\Exception\RequestException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

use function Jaxon\jaxon;
use function Jaxon\pm;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Jaxon middleware to load config
// Set a container if you need to use its services in Jaxon classes.
// Set a logger if you need to send messages to your logs in Jaxon classes.
$jaxonConfigMiddleware = function(Request $request, RequestHandler $handler) {
    return jaxon()->psr()
        // Uncomment the following line to set a container
        // ->container($container)
        // Uncomment the following line to set a logger
        // ->logger($logger)
        ->view('slim', '.html.twig', function() use($request) {
            $view = Twig::fromRequest($request);
            return new \Jaxon\Slim\View($view);
        })
        ->config(__DIR__ . '/../jaxon/config.php')->process($request, $handler);
};

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
$app->addRoutingMiddleware();

// Create Twig
$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Process Jaxon ajax requests
$app->group('/', function() use($app) {
    /**
     * Jaxon middleware to process ajax requests
     *
     * @throws RequestException
     */
    $jaxonAjaxMiddleware = function(Request $request, RequestHandler $handler) {
        return jaxon()->psr()->ajax()->process($request, $handler);
    };

    $app->post('/jaxon', function($request, $response) {
        // Todo: return an error. Jaxon could not find a plugin to process the request.
    })->add($jaxonAjaxMiddleware);

    // Insert Jaxon codes in a page
    $app->get('/', function($request, $response) {
        $jaxon = jaxon()->app();
        // Display the page
        $view = Twig::fromRequest($request);

        return $view->render($response, 'demo/index.html.twig', [
            'jaxonCss' => $jaxon->css(),
            'jaxonJs' => $jaxon->js(),
            'jaxonScript' => $jaxon->script(),
            'pageTitle' => "Slim Framework Integration",
            'bts' => $jaxon->request(Bts::class), // Jaxon request to the Bts controller
            'pgw' => $jaxon->request(Pgw::class), // Jaxon request to the Pgw controller
            'pm' => pm(), // Jaxon Request Factory
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
