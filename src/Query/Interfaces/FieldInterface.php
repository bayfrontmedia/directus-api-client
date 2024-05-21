<?php

namespace Bayfront\Directus\Query\Interfaces;

interface FieldInterface
{

    /**
     * Get field.
     *
     * @return array
     */
    public function get(): array;

}