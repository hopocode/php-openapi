<?php

declare(strict_types=1);

use Hopo\OpenApi\OpenApiUtils;
use Tester\Assert;

test('OpenApiUtils::withSelector should return array split by dot expect escape dot.', function () {
    Assert::equal(OpenApiUtils::withSelector('aaa.bbb.ccc'), ['aaa', 'bbb', 'ccc']);
    Assert::equal(OpenApiUtils::withSelector('aaa.bbb.ccc\.ddd'), ['aaa', 'bbb', 'ccc.ddd']);
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
