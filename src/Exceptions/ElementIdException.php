<?php

namespace Hypoid\Lavacharts\Exceptions;

use Hypoid\Lavacharts\Support\Contracts\RenderableInterface as Renderable;

class ElementIdException extends RenderingException
{
    public function __construct(Renderable $renderable)
    {
        $message = 'Cannot render without an elementId.';

        parent::__construct($renderable, $message);
    }
}
