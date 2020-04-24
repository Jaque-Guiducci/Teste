<?php

declare(strict_types=1);

namespace Simples\Http\Rest;

use App\Exceptions\ErrorResourceIsGone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Simples\Persistence\RepositoryInterface;

use function is_null;

/**
 * Trait Read
 *
 * @package Simples\Http\Rest
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
        $trash = $request->get('trash') === 'true';
        $data = $this->repository()->read($id, $trash);
        if (is_null($data)) {
            throw new ErrorResourceIsGone(['id' => $id]);
        }
        return $this->answerSuccess($data);
    }
}