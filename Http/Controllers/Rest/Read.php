<?php

declare(strict_types=1);

namespace Devitools\Http\Controllers\Rest;

use Devitools\Exceptions\ErrorResourceIsGone;
use Devitools\Http\Support\Scopes;
use Devitools\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Trait Read
 *
 * @package Devitools\Http\Controllers\Rest
 * @method RepositoryInterface repository()
 */
trait Read
{
    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     * @throws ErrorResourceIsGone
     */
    public function read(Request $request, string $id): JsonResponse
    {
        $this->grant($this->repository()->domain(), Scopes::SCOPE_VIEW);

        $trash = $request->get('trash') === 'true';
        $data = $this->repository()->read($id, $trash);
        if ($data === null) {
            throw new ErrorResourceIsGone(['id' => $id]);
        }

        return $this->answerSuccess($data);
    }
}
