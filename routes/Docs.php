<?php

declare(strict_types=1);

use Comet\Request;
use Comet\Response;

$app->get('/docs', function (Request $request, Response $response) {
  $html = <<<HTML
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resting API Docs</title>
  </head>
  <body>
    <div id="app"></div>
    <script src="https://cdn.jsdelivr.net/npm/@scalar/api-reference"></script>
    <script>
      Scalar.createApiReference('#app', { url: '/openapi.yaml' })
    </script>
  </body>
</html>
HTML;

  $response->getBody()->write($html);
  return $response->withHeader('Content-Type', 'text/html');
});

$app->get('/openapi.yaml', function (Request $request, Response $response) {
  $yaml = file_get_contents(__DIR__ . '/../openapi.yaml');
  $response->getBody()->write($yaml);
  return $response->withHeader('Content-Type', 'text/plain');
});
