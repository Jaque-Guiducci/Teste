<?php

declare(strict_types=1);

namespace Devitools\Persistence\Repository;

use Devitools\Persistence\AbstractModel;

/**
 * Trait Update
 *
 * @package Devitools\Persistence\Repository
 */
trait Update
{
    /**
     * @param string $id
     * @param array $data
     *
     * @return string
     */
    public function update(string $id, array $data): ?string
    {
        /** @var AbstractModel $instance */
        $instance = $this->pull($id);
        if ($instance === null) {
            return null;
        }
        $data = $this->prepare($id, $data, false);
        $instance->fill($data);
        $instance->save();
        return $instance->getPrimaryKeyValue();
    }
}