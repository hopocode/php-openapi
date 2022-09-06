<?php

declare(strict_types=1);

use Hopo\OpenApi\OpenApiUtils;
use Tester\Assert;

test('OpenApiUtils::withSelector should return array split by dot expect escape dot.', function () {
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc'))->toEqual(['aaa', 'bbb', 'ccc']);
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc\.ddd'))->toEqual(['aaa', 'bbb', 'ccc.ddd']);
    Assert::equal(OpenApiUtils::withSelector('aaa.bbb.ccc\.\.ddd'), ['aaa', 'bbb', 'ccc..ddd']);
});

test('Replace with reference.', function () {
    $cmpName = '#/components/schemas/User';
    $from = [
        '$ref' => $cmpName,
    ];
    $ref = [
        'type' => 'object',
        'properties' => [
            'fisrtname' => [
                'type' => 'string',
            ],
        ],
    ];
    Assert::equal(OpenApiUtils::replaceWithReference($from, $ref, $cmpName), $ref);
});
