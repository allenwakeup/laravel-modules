<?php

namespace Goodcatch\Modules\Laravel\Contracts\Auth;

interface PermissionProvider
{


    /**
     * Get the name of driver
     *
     * @return string
     */
    public function getDriver ();

    /**
     * Get a new query builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query ();

    /**
     * Get a new query builder.
     *
     * @param  array  values attributes to be save
     * @param  array  unique values to identify an exists record
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function save (array $values, array $unique);

    /**
     * Retrieve a permission with criteria range
     *
     * @param  mixed  $condition
     * @return mixed|null
     */
    public function find ($condition);

    /**
     * Retrieve permissions with criteria range
     *
     * @param  array  $condition
     * @return mixed|null
     */
    public function retrieve ($condition);

}