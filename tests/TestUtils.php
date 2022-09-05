<?php

declare(strict_types=1);

namespace Hopo\TestOpenApi;

use Nette\Utils\Json;

class TestUtils
{
    public static function getPetstore(): array
    {
        return Json::decode(file_get_contents(__DIR__ . '/petstore.json'), Json::FORCE_ARRAY);
    }
}
