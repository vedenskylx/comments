<?php

namespace app\models;


class CommentShort extends Comment
{
    /**
     * @inheritDoc
     */
    public function fields(): array
    {
        return [
            'id',
            'content'
        ];
    }
}
