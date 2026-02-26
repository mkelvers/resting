<?php

declare(strict_types=1);

namespace App;

use Comet\Comet;
use Comet\Request;
use Comet\Response;

class Routes
{

  /**
   * Registers all route files in the routes directory.
   */
  public static function register(Comet $app): void
  {
    $routesDir = __DIR__ . '/../routes';

    if (!is_dir($routesDir)) {
      return;
    }

    // retrieves all php files in the routes directory and subdirectories
    // requires means that the routes defined in those files will be registered
    // along with the app instance passed to this method
    $files = new \RecursiveIteratorIterator(
      new \RecursiveDirectoryIterator($routesDir, \RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($files as $file) {
      if ($file->getExtension() === 'php') {
        require_once $file->getPathname();
      }
    }

    // catch-all route for any undefined routes, returns a 404 error
    // this should be registered last to ensure it doesn't override any defined routes
    $app->any('/{path:.+}', function (Request $request, Response $response, $args) {
      return $response->with(error_response('route not found'), 400);
    });
  }
}
