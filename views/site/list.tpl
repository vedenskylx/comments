<li>
    <span data-comment-id="{$comment->id}" class="{if $comment->isParent}parent{/if}">
        <i class="fa fa-plus-square load-comments" data-id="{$comment->id}"></i>
        <span class="content">{$comment->content}</span>
        <hr>
        <button type="button" class="btn btn-outline-info reply-comment">Ответить</button>
        <button type="button" class="btn btn-outline-info edit-comment">Редактировать</button>
        <button type="button" class="btn btn-outline-danger delete-comment">Удалить</button>
    </span>
</li>
