<?php

/**
 * Copyright (c) Honza Pospisil (https://www.honzapospisil.com)
 */

declare(strict_types=1);

namespace Hopo\OpenApi;

use Nette\StaticClass;

class OpenApiUtils
{
    use StaticClass;

    private const DOT = '______DOT______';

    public static function findReference(string $referenceName, array $rootApi)
    {
        if (!str_starts_with($referenceName, '#/components/')) {
            throw new OpenApiException("Invalid referenca neme '$referenceName'");
        } else {
            $name = substr($referenceName, strlen('#/components/'));
            $ret = $rootApi['components'];
            foreach (explode('/', $name) as $key) {
                $ret = $ret[$key];
            }
            return $ret;
        }
        throw new OpenApiException("Reference '$referenceName' does not exists.");
    }

    public static function withSelector(string $selector): array
    {
        $selector = str_replace(['\\.'], [self::DOT], $selector);
        $parts = explode('.', $selector);
        foreach ($parts as $i => $part) {
            $parts[$i] = strtr($part, [self::DOT => '.']);
        }
        return $parts;
    }

    public static function replaceReference(array $spec, array $rootApi, $deep = 1)
    {
        if (count($spec) === 1 && key($spec) === '$ref') {
            return self::replaceWithReference($spec, self::findReference($spec['$ref'], $rootApi), $spec['$ref']);
        } else {
            foreach ($spec as $k => $v) {
                if (is_array($v)) {
                    $deep = $deep - 1;
                    if ($deep > 0) {
                        $spec[$k] = self::replaceReference($v, $rootApi, $deep);
                    }
                } else {
                    // this is not need
                    // $spec[$k] = $v;
                }
            }
        }
        return $spec;
    }

    public static function replaceWithReference(array $spec, $value, $name)
    {
        if (count($spec) === 1 && key($spec) === '$ref' && $spec['$ref'] === $name) {
            return $value;
        }
    }

    public static function getDefaultParametersValues(OpenApiNode $spec, string $in): array
    {
        $params = $spec['parameters'] ?? [];
        $ret = [];
        foreach ($params as $param) {
            if ($param['in'] === $in && isset($param['schema']['default'])) {
                $ret[$param['name']] = $param['schema']['default'];
            }
        }
        return $ret;
    }
}
