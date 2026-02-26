<?php

declare(strict_types=1);

namespace App;

use Comet\Request;

// valid enum values for product fields
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

// removes trailing slashes from uris
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

// transforms items into rest response with pagination links
function rest(array $data, string $route, ?int $count = null, ?int $limit = null, ?int $offset = null, array $extra = []): array
{
    $url = $_ENV['BASE_URL'];

    $results = array_map(function (array $item) use ($url, $route, $extra): array {
        $id = $item['id'] ?? null;
        $result = [
            'id' => $id,
            'url' => $id ? "$url/$route/$id" : null,
        ];
        // add any extra fields requested (e.g. name, title)
        foreach ($extra as $field) {
            if (array_key_exists($field, $item)) {
                $result[$field] = $item[$field];
            }
        }
        return $result;
    }, $data);

    $next = null;
    $previous = null;

    if ($count !== null && $limit !== null && $offset !== null) {
        // there are more pages
        if ($offset + $limit < $count) {
            $nextOffset = $offset + $limit;
            $next = "$url/$route?offset=$nextOffset&limit=$limit";
        }

        // there are previous pages
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

// extracts pagination params from request query string
function paginate(Request $request): array
{
    $params = $request->getQueryParams() ?? [];

    // ensure limit is at least 1 and offset is not negative
    $limit = isset($params['limit']) ? max(1, (int)$params['limit']) : 20;
    $offset = isset($params['offset']) ? max(0, (int)$params['offset']) : 0;

    return [
        'limit' => $limit,
        'offset' => $offset,
    ];
}

// wraps error in standard error format
function error_response(string $message): array
{
    return [
        'error' => [
            'message' => $message,
        ],
    ];
}
