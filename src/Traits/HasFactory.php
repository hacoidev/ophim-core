<?php

namespace Ophim\Core\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory as BaseFactory;
use Illuminate\Support\Str;

trait HasFactory
{
    use BaseFactory;

    protected static function newFactory()
    {
        $package = Str::before(get_called_class(), 'Models\\');
        $modelName = Str::after(get_called_class(), 'Models\\');
        $path = $package.'Database\\Factories\\'.$modelName.'Factory';

        return $path::new();
    }
}