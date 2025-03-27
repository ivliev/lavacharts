<?php

namespace Hypoid\Lavacharts\Exceptions;

use Hypoid\Lavacharts\Support\Contracts\RenderableInterface as Renderable;

class RenderingException extends LavaException
{
    public function __construct(Renderable $renderable, $message = '')
    {
        $renderErrMsg = $renderable->getLabelStr() . ' cannot be rendered.';

        if (!empty($message)) {
            $message = $renderErrMsg . ' ' . $message;
        } else {
            $message = $renderErrMsg;
        }

        parent::__construct($message);
    }
}
