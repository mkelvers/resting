<?php

declare(strict_types=1);

namespace App;

use Comet\Request;

const MEDIA_CONDITIONS = ['mint', 'near_mint', 'very_good_plus', 'very_good', 'good', 'fair', 'poor'];
const SLEEVE_CONDITIONS = ['mint', 'near_mint', 'very_good_plus', 'very_good', 'good', 'fair', 'poor', 'generic'];
const FORMATS = ['lp', 'vinyl', '12_maxi', '7_single', 'cd_album', 'cd_single'];

function validate_enum_fields(array $body): ?string
{
    if (isset($body['media_condition']) && !in_array($body['media_condition'], MEDIA_CONDITIONS, true)) {
        return 'invalid media_condition';
    }
    if (isset($body['sleeve_condition']) && !in_array($body['sleeve_condition'], SLEEVE_CONDITIONS, true)) {
        return 'invalid sleeve_condition';
    }
    if (isset($body['format']) && !in_array($body['format'], FORMATS, true)) {
        return 'invalid format';
    }
    return null;
}

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
 * @param array $extraFields Fields to include alongside id and url (e.g., ['name', 'title']).
 * @return array The transformed RESTful response.
 */
function rest(array $data, string $route, ?int $count = null, ?int $limit = null, ?int $offset = null, array $extraFields = []): array
{
    // base url from environment, used to build resource urls
    $url = $_ENV['BASE_URL'];

    // transforms each item into its id and url representation
    $results = array_map(function (array $item) use ($url, $route, $extraFields): array {
        $id = $item['id'] ?? null;
        $result = [
            'id' => $id,
            'url' => $id ? "$url/$route/$id" : null,
        ];
        foreach ($extraFields as $field) {
            if (array_key_exists($field, $item)) {
                $result[$field] = $item[$field];
            }
        }
        return $result;
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

function response(mixed $data, int $status = 200): array
{
    return [
        'data' => $data,
        'status' => $status,
    ];
}

function error_response(string $message, int $status = 400): array
{
    return [
        'error' => [
            'message' => $message,
        ],
        'status' => $status,
    ];
}
