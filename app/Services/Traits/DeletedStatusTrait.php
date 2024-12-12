<?php

    namespace App\Traits;

    use Illuminate\Database\Eloquent\Builder;

    trait DeletedStatusTrait {

        /** 
         * Records with status less than 0 are not shown.
         *
         * @return void
        */
        protected static function booted(): void
        {
            static::addGlobalScope('ancient', function (Builder $builder) {
                $builder->where((new static)->getTable().'.status', '>', -1);
            });
        }
    }