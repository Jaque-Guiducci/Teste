<?php

declare(strict_types=1);

namespace DeviTools\Persistence;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface RepositoryInterface
 *
 * @package App\Domains
 */
interface RepositoryInterface
{
    /**
     * @param array $data
     *
     * @return string
     */
    public function create(array $data): ?string;

    /**
     * @param string $id
     * @param bool $trash
     *
     * @return ModelInterface
     */
    public function read(string $id, $trash = false): ?ModelInterface;

    /**
     * @param string $id
     * @param array $data
     *
     * @return string
     */
    public function update(string $id, array $data): ?string;

    /**
     * @param string $id
     * @param bool $erase
     *
     * @return string
     */
    public function destroy(string $id, $erase = false): ?string;

    /**
     * @param string $id
     *
     * @return string
     */
    public function restore(string $id): ?string;

    /**
     * @param array $options
     * @param bool $trash
     *
     * @return array
     */
    public function search(array $options = [], $trash = false): array;

    /**
     * @param array $filters
     * @param bool $trash
     *
     * @return int
     */
    public function count(array $filters, $trash = false): int;

    /**
     * @param array $filters
     * @param array $sorter
     * @param int $offset
     * @param int $limit
     * @param bool $trash
     *
     * @return AbstractModel[]|Builder[]|Collection
     */
    public function find(array $filters, $sorter = [], $offset = 0, $limit = 25, $trash = false);

    /**
     * @return array
     */
    public function getFilterable(): array;

    /**
     * @return array
     */
    public function getManyToOne(): array;

    /**
     * @return string
     */
    public function prefix(): string;

    /**
     * @return array|string[]
     */
    public function getDefaults(): array;
}
