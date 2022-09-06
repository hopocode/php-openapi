<?php

declare(strict_types=1);

use Hopo\OpenApi\OpenApiNode;
use Hopo\TestOpenApi\TestUtils;

test('OpenApiNode', function () {
    $petstoreApi = TestUtils::getPetstore();
    $node = new OpenApiNode($petstoreApi, $petstoreApi);
    expect($node)->toBeInstanceOf(OpenApiNode::class);
    expect($node['info'])->toBeInstanceOf(OpenApiNode::class);
    expect($node['openapi'])->toBe('3.0.2');
    expect($node['paths']['/pet']['post'])->toBeInstanceOf(OpenApiNode::class);
    expect($node['paths']['/pet']['post']['requestBody']['content']['application/json']['schema'])->toBeInstanceOf(OpenApiNode::class);
    expect($node['paths./pet.post.requestBody.content.application/json.schema'])->toBeInstanceOf(OpenApiNode::class);
    expect($node['paths']['/pet']['post']['requestBody']['content']['application/json']['schema']['properties']['id']['type'])->toBe('integer');
});
