<?php

namespace TrivYeah\Traits;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Trait to discover files within a particular folder
 */
trait DiscoverFiles
{
    /**
     * 
     */
    private function discoverFilesWithin(array $path)
    {
        return collect($path)->reject(function ($directory) {
                        return ! is_dir($directory);
                    })
                    ->reduce(function ($discovered, $directory) {
                        return array_merge_recursive(
                            $discovered,
                            static::within($directory, base_path())
                        );
                    }, []);
    }

    private static function within($directory, $basePath)
    {
        return collect((new Finder)->files()->in($directory))
            ->map(function ($file) use ($basePath){
            return static::classFromFile($file, $basePath);
        })->all();
    }

    private static function classFromFile(SplFileInfo $file, $basePath)
    {
        $class = trim(Str::replaceFirst($basePath, '', $file->getRealPath()), DIRECTORY_SEPARATOR);

        return str_replace(
            [DIRECTORY_SEPARATOR, ucfirst(basename(app()->path())).'\\'],
            ['\\', app()->getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        );
    }

    private function getClass(string $fullyQualifiedClass)
    {
        $reversed = strrev($fullyQualifiedClass);
        $subrevered = substr($reversed, 0, strpos($reversed, "\\"));
        return strrev($subrevered);
    }

}