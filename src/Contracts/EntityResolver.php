<?php

declare(strict_types=1);

namespace SwooleTW\Hyperf\Queue\Contracts;

interface EntityResolver
{
    /**
     * Resolve the entity for the given ID.
     */
    public function resolve(string $type, mixed $id): mixed;
}
