<?php

declare(strict_types=1);

use Hopo\OpenApi\OpenApiNode;
use Hopo\OpenApi\OpenApiUtils;
use Hopo\TestOpenApi\TestUtils;

test('OpenApiUtils::withSelector should return array split by dot expect escape dot.', function () {
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc'))->toEqual(['aaa', 'bbb', 'ccc']);
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc\.ddd'))->toEqual(['aaa', 'bbb', 'ccc.ddd']);
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc\.\.ddd'))->toEqual(['aaa', 'bbb', 'ccc..ddd']);
});

//getDefaultParametersValues
test('OpenApiUtils::getDefaultParametersValues should return array of default values.', function () {
    $spec = new OpenApiNode(TestUtils::getPetstore(), TestUtils::getPetstore());
    expect(OpenApiUtils::getDefaultParametersValues($spec['paths']['/pet/findByStatus']['get'], 'query'))->toBe(['status' => 'available']);
});
