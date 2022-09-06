<?php

declare(strict_types=1);

use Hopo\OpenApi\OpenApiUtils;

test('OpenApiUtils::withSelector should return array split by dot expect escape dot.', function () {
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc'))->toEqual(['aaa', 'bbb', 'ccc']);
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc\.ddd'))->toEqual(['aaa', 'bbb', 'ccc.ddd']);
    expect(OpenApiUtils::withSelector('aaa.bbb.ccc\.\.ddd'))->toEqual(['aaa', 'bbb', 'ccc..ddd']);
});
