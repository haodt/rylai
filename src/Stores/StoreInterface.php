<?php

namespace Rylai\Stores;

interface StoreInterface
{
    public function store(\stdClass $analyzed);
}
