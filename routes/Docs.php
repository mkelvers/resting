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
    <rapi-doc spec-url="/openapi.yaml" 
              render-style="focused" 
              theme="dark"
              show-header="false"
              show-info="true"
              allow-server-selection="false"
              allow-authentication="true"
              allow-try="true"
              primary-color="#6366f1"> 
      <div slot="nav-logo" style="display:flex;align-items:center;padding:10px">
        <span style="color:white;font-weight:bold;font-size:1.2em">Resting API</span>
      </div>
    </rapi-doc>
    <script src="https://cdn.jsdelivr.net/npm/rapidoc/dist/rapidoc-min.js"></script>
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
