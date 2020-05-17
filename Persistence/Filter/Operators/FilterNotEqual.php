<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Filter\Operators;

use DeviTools\Persistence\Filter\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterNotEqual
 *
 * @package DeviTools\Persistence\Filter\Operators
 */
class FilterNotEqual extends FilterAbstract
{
    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function where(Builder $query, string $connector, string $value, string $column): Builder
    {
        return $query->where($column, '<>', $value);
    }

    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function orWhere(Builder $query, string $connector, string $value, string $column): Builder
    {
        return $query->orWhere($column, '<>', $value);
    }
}
