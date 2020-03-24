<?php


namespace TrivYeah\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait HasMeta
{
    /**
     * Meta field
     */
    protected static $meta_field = "meta";

    public static function bootHasMeta()
	{
		static::saving(function ($model) {
            return static::packMeta($model);
        });

        static::retrieved(function ($model) {
            return static::unpackMeta($model);
        });
    }

    protected function initializeHasMeta()
    {
        $this->fillable(
            array_merge($this->fillable , $this->getMetaAttributes())
        );
    }

    protected function getMetaAttributes()
    {
        return array_keys($this->meta());
    }
    
    public function meta()
    {
        return [];
    }

    protected static function getMeta($model, $modelMetas)
    {
        foreach ($modelMetas as $meta => $default) {
            $metas[$meta] = $model->$meta ?? $default;
        }
        return $metas ?? [];
    }

    protected static function packMeta($model)
    {
        $metas = static::getMeta($model, $model->meta());

        foreach ($metas as $meta => $value) {
            $model->offsetUnset($meta);
        }

        $model->{static::$meta_field} = array_unshape($metas);
    }

    protected static function unpackMeta($model)
    {
        $metas = static::getMeta($model, $model->meta);
        $model->offsetUnset(static::$meta_field);

        foreach ($metas as $meta => $value) {
            $model->$meta = array_shape($value);
        }
    }
}