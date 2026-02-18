<?php

namespace App;

/**
 * Transforms an array of items into a RESTful response format.
 * Each item is expected to have an 'id' field, which is used to generate a URL for the resource.
 * 
 * @param array $data The array of items to transform.
 * @param string $route The base route for the resources (e.g., 'posts').
 * @return array The transformed RESTful response.
 */
function rest(array $data, string $route): array
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

    return [
        'count' => count($data),
        'next' => null,
        'previous' => null,
        'results' => $results,
    ];
}
