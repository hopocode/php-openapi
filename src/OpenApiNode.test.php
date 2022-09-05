<?php

declare(strict_types=1);

use Hopo\OpenApi\OpenApiNode;
use Hopo\TestOpenApi\TestUtils;
use Tester\Assert;

test('OpenApiNode', function () {
    $petstoreApi = TestUtils::getPetstore();
    $node = new OpenApiNode($petstoreApi, $petstoreApi);
    Assert::true($node instanceof OpenApiNode);
    Assert::true($node['info'] instanceof OpenApiNode);
    Assert::true($node['openapi'] === '3.0.2');
    Assert::true($node['paths']['/pet']['post'] instanceof OpenApiNode);
    Assert::true($node['paths']['/pet']['post']['requestBody']['content']['application/json']['schema'] instanceof OpenApiNode);
    Assert::true($node['paths./pet.post.requestBody.content.application/json.schema'] instanceof OpenApiNode);
    Assert::true($node['paths']['/pet']['post']['requestBody']['content']['application/json']['schema']['properties']['id']['type'] === 'integer');
    //Assert::true($node['paths./pet.post.requestBody.content.application/json.schema.properties.id.type'] === 'integer');
});
