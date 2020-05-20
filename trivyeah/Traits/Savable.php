<?php

namespace TrivYeah\Traits;

/**
 * Tries to find an existing instance from the db before saving
 */
trait Savable
{
    /**
     * Get first instance that matches some given attribute or save;
     */
    public function firstOrSave(...$attributes)
    {
        $query = $this->query();

        $attributes = $attributes ?: $this->getFilledAttributes();

        foreach ($attributes as $attribute) {
            $query = $query->where($attribute, $this->$attribute);
        }
        
        return $query->first() ?? $this->saveOnly();
    }

    /**
     * Update or save the given instance
     */
    public function updateOrSave(...$attributes)
    {
        $query = $this->query();

        $attributes = $attributes ?: $this->getFilledAttributes();

        foreach ($attributes as $attribute) {
            $query = $query->where($attribute, $this->$attribute);
        }

        if ($model = $query->first()) {
            return tap ($model, function ($model) {
                return $model->update($this->toArray());
            });
        }
        
        return $this->saveOnly();
    }

    public static function fit(array $attributes)
    {
        return static::make()->fill($attributes);
    }

    public function saveOnly()
    {
        return tap ($this, function ($model) {
            return $model->save();
        });
    }

    public function getFilledAttributes()
    {
        return array_keys($this->toArray());
    }
}