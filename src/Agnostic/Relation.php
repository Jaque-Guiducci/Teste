<?php

namespace Devitools\Agnostic;

/**
 * Trait Relation
 *
 * @package Devitools\Agnostic
 */
trait Relation
{
    /**
     * @var array
     */
    protected array $manyToOne = [];

    /**
     * @var array
     */
    protected array $belongsTo = [];

    /**
     * @var array
     */
    protected array $oneToMany = [];

    /**
     * @var array
     */
    protected array $hasMany = [];

    /**
     * @var array
     */
    protected array $withRelations = [];

    /**
     * @param string $name
     * @param string $related
     * @param string $foreignKey
     * @param string $ownerKey
     *
     * @return $this
     */
    protected function addManyToOne(string $name, string $related, string $foreignKey, string $ownerKey): self
    {
        $this->manyToOne[$name] = $foreignKey;
        $this->belongsTo[$name] = (object)[
            'related' => $related,
            'foreignKey' => $foreignKey,
            'ownerKey' => $ownerKey,
            'name' => $name,
        ];
        return $this;
    }

    /**
     * @param string $name
     * @param string $related
     * @param string $foreignKey
     * @param string|callable|null $callable
     * @param string|null $localKey
     *
     * @return $this
     */
    protected function addOneToMany(
        string $name,
        string $related,
        string $foreignKey,
        $callable,
        string $localKey
    ): self {
        $this->oneToMany[$name] = $callable;
        $this->hasMany[$name] = (object)[
            'related' => $related,
            'foreignKey' => $foreignKey,
            'localKey' => $localKey,
        ];
        return $this;
    }

    /**
     * @return array
     */
    public function manyToOne(): array
    {
        return $this->manyToOne;
    }

    /**
     * @return array
     */
    public function oneToMany(): array
    {
        return $this->oneToMany;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->belongsTo[$name])) {
            $belongsTo = $this->belongsTo[$name];
            return $this
                ->belongsTo($belongsTo->related, $belongsTo->foreignKey, $belongsTo->ownerKey, $belongsTo->name)
                ->withTrashed()
                ->get();
        }

        if (isset($this->hasMany[$name])) {
            $hasMany = $this->hasMany[$name];
            return $this
                ->hasMany($hasMany->related, $hasMany->foreignKey, $hasMany->localKey)
                ->withTrashed()
                ->get();
        }

        return parent::__get($name);
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (isset($this->belongsTo[$name])) {
            $belongsTo = $this->belongsTo[$name];
            $related = $belongsTo->related;
            $foreignKey = $belongsTo->foreignKey;
            $ownerKey = $belongsTo->ownerKey;
            $relation = $belongsTo->name;
            return $this->belongsTo($related, $foreignKey, $ownerKey, $relation)
                ->withTrashed();
        }

        if (isset($this->hasMany[$name])) {
            $hasMany = $this->hasMany[$name];
            $related = $hasMany->related;
            $foreignKey = $hasMany->foreignKey;
            $localKey = $hasMany->localKey;
            return $this->hasMany($related, $foreignKey, $localKey)->withTrashed();
        }

        return parent::__call($name, $arguments);
    }
}
