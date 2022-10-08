<?php

namespace Ushahidi\Core;

use Ushahidi\Contracts\Entity;
use Ushahidi\Contracts\Repository;
use Illuminate\Container\Container;

abstract class EloquentRepository implements
    Repository\CreateRepository,
    Repository\ReadRepository,
    Repository\UpdateRepository,
    Repository\DeleteRepository,
    Repository\ImportRepository
{
    /**
     *
     * @var string|\Ushahidi\Core\EloquentEntity
     */
    protected static $root;

    public function get($id)
    {
        return $this->find($id);
    }

    public function getEntity(array $data = null)
    {
        return new self::$root($data);
    }

    /**
     * @inheritDoc
     *
     * @param \Ushahidi\Core\EloquentEntity $entity
     */
    public function create(Entity $entity)
    {
        $entity->save();

        return $entity->{$this->getKeyName()};
    }

    public function exists($id)
    {
        return $this->whereKey($id)->exists();
    }

    public function __call(string $name, array $arguments)
    {
        return Container::getInstance()->make(static::$root)->{$name}(...$arguments);
    }
}
