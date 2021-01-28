<?php

namespace Goodcatch\Modules\Laravel\Contracts\Database;

interface DBConnectionProvider
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
     * @return array all of database connections
     */
    public function all ();


    /**
     * Retrieve a permission with criteria range
     *
     * @param  string  database alias
     * @return mixed|null
     */
    public function find ($alias);

}