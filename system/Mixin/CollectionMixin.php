<?php

namespace System\Mixin;

use Illuminate\Support\Fluent;

class CollectionMixin
{

    /**
     * Map collection in twos
     * @return Closure
     */
    public function mapInTwos()
    {
        return function ($closure) {
            $newInstance = collect();

            $this->reduce(function ($carry, $item) use ($closure, $newInstance){
                if ($carry == null) {
                    return $item;
                }

                $newInstance->push($closure($carry, $item));
                return null;
            });

            return $newInstance;
        };
    }

    /**
     * Map collection in pairs
     * @return Closure
     */
    public function mapInPairs()
    {
        return function ($closure) {
            $newInstance = collect();
            $series = collect();
            $pair = (new \ReflectionFunction($closure))->getNumberOfParameters();

            $unpackItems = function ($i, $data) use ($pair) {
                $data->push($i);
                for ($index = 0; $index < $pair; $index++) {
                    $items[] = $data->get($index);
                }
                return $items;
            };

            foreach ($this->values() as $key => $item) {
                if ($series->count() === ($pair - 1) || $key == ($this->count() - 1)) {
                    
                    $newInstance->push($closure(...$unpackItems($item, $series)));
                    $series = collect();
                } else {
                    $series->push($item);
                }
            }

            return $newInstance;
        };
    }

    /**
     * Get the key from the collection where condition is met
     * @return Closure
     */
    public function keyWhere()
    {
        return function ($index, $value) {
            foreach ($this->values() as $key => $item) {
                if (((object)$item)->$index == $value) {
                    return $key;
                }
            }
            return null;
        };
    }
}