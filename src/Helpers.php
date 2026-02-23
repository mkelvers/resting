<?php

namespace App;

use Comet\Request;

/**
 * Middleware to strip trailing slashes from request URIs.
 * This helps to avoid issues with routing and ensures consistent URL handling.
 *
 * @return callable The middleware function that processes the request and response.
 */
function strip_trailing_slash(): callable
{
    return function ($request, $handler) {
        $uri = $request->getUri()->getPath();
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            return $handler->handle($request->withUri(
                $request->getUri()->withPath(rtrim($uri, '/'))
            ));
        }
        return $handler->handle($request);
    };
}

/**
 * Transforms an array of items into a RESTful response format.
 * Each item is expected to have an 'id' field, which is used to generate a URL for the resource.
 * 
 * @param array $data The array of items to transform.
 * @param string $route The base route for the resources (e.g., 'posts').
 * @return array The transformed RESTful response.
 */
function rest(array $data, string $route, ?int $count = null, ?int $limit = null, ?int $offset = null): array
{
    // base url from environment, used to build resource urls
    $url = $_ENV['BASE_URL'];

    // transforms each item into its id and url representation
    $results = array_map(function (array $item) use ($url, $route): array {
        $id = $item['id'] ?? null;
        return [
            'id' => $id,
            'url' => $id ? "$url/$route/$id" : null,
        ];
    }, $data);

    $next = null;
    $previous = null;

    if ($count !== null && $limit !== null && $offset !== null) {
        if ($offset + $limit < $count) {
            $nextOffset = $offset + $limit;
            $next = "$url/$route?offset=$nextOffset&limit=$limit";
        }
        
        if ($offset > 0) {
            $prevOffset = max(0, $offset - $limit);
            $previous = "$url/$route?offset=$prevOffset&limit=$limit";
        }
    }

    return [
        'count' => $count ?? count($data),
        'next' => $next,
        'previous' => $previous,
        'results' => $results,
    ];
}

/**
 * Extract pagination details from a request.
 *
 * @param \Comet\Request $request
 * @return array{limit: int, offset: int}
 */
function paginate(Request $request): array
{
    $params = $request->getQueryParams() ?? [];
    
    // set default limit and offset values, however can be overriden by query parameters
    // we also ensure that limit is at least 1 and offset is not negative
    $limit = isset($params['limit']) ? max(1, (int)$params['limit']) : 20;
    $offset = isset($params['offset']) ? max(0, (int)$params['offset']) : 0;

    return [
        'limit' => $limit,
        'offset' => $offset,
    ];
}
