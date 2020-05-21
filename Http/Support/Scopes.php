<?php

declare(strict_types=1);

namespace App\Http\Support;

/**
 * Class Scopes
 *
 * @package App\Http\Support
 */
abstract class Scopes
{
    /**
     * @var string
     */
    public const SCOPE_INDEX = 'index';

    /**
     * @var string
     */
    public const SCOPE_ADD = 'add';

    /**
     * @var string
     */
    public const SCOPE_VIEW = 'view';

    /**
     * @var string
     */
    public const SCOPE_EDIT = 'edit';

    /**
     * @var string
     */
    public const SCOPE_REMOVE = 'destroy';

    /**
     * @var string
     */
    public const SCOPE_TRASH = 'trash';
}
