<?php

namespace Rylai\Stores;

use Rylai\Repository;

interface StoreInterface
{
    public function store(Repository $repository);
}
