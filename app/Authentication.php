<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Comet\Request;
use Comet\Response;

class Authentication
{
  private static ?string $username = null;
  private static ?string $password = null;

  public static function init(): void
  {
    self::$username = $_ENV['BASIC_AUTH_USER'] ?? null;
    self::$password = $_ENV['BASIC_AUTH_PASS'] ?? null;
  }

  public static function basicAuth(Request $request, RequestHandler $handler): Response
  {
    self::init();

    $fail = fn(string $msg, int $code, array $headers = []) => (
      new Response()
      ->with($msg, $code)
      ->withHeaders($headers)
    );

    if (self::$username === null || self::$password === null) {
      return $fail('basic auth not configured', 500);
    }

    $authHeader = $request->getHeaderLine('Authorization');
    if (!$authHeader || !str_starts_with($authHeader, 'Basic ')) {
      return $fail('authorization required', 401, ['WWW-Authenticate' => 'Basic realm="Restricted"']);
    }

    $credentials = base64_decode(substr($authHeader, 6));
    if ($credentials === false) {
      return $fail('invalid credentials', 401);
    }

    [$user, $pass] = explode(':', $credentials, 2);
    if ($user !== self::$username || $pass !== self::$password) {
      return $fail('invalid credentials', 401);
    }

    return $handler->handle($request);
  }
}
