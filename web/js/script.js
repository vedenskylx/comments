$(document).ready(function () {
    let tree = $('.tree');
    const CREATE_URL = '/site/create';

    tree.on('click', '.load-comments', function () {
        let $this = $(this);
        let id = $this.data('id');
        let span = $this.parent('span');

        if ($this.hasClass('fa-plus-square')) {
            $.ajax({
                type: "GET",
                url: '/site/comments?id=' + id,
                success: function (msg) {
                    span.parent().find('ul').remove();
                    span.after(msg);
                    $this.removeClass('fa-plus-square');
                    $this.addClass('fa-minus-square');
                }
            });
        } else {
            span.parent().find('ul').remove();
            $this.removeClass('fa-minus-square');
            $this.addClass('fa-plus-square');
        }
    });

    $('#create-comment').on('click', function () {
        clearForm('Создание нового комментария');
        $('#exampleModal').modal('toggle');
    });

    tree.on('click', '.reply-comment', function () {
        clearForm('Ответить на комментарий');
        $('#comment-parent-id').val($(this).parent('span').data('comment-id'));
        $('#exampleModal').modal('toggle');
    });

    $('#comment-form').on('submit', function (e) {
        let form = $(this);
        let parent_id = $('#comment-parent-id').val();
        let data = form.serialize();

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: data,
            success: function (data) {
                if (form.attr('action') === CREATE_URL) {
                    if (parent_id === '') {
                        $('.tree').children('ul').append(data);
                    } else {
                        $.ajax({
                            type: "GET",
                            url: '/site/comments?id=' + parent_id,
                            success: function (msg) {
                                let span = $('span[data-comment-id=' + parent_id + ']');
                                let load = span.find('.load-comments');

                                span.addClass('parent');
                                span.parent().find('ul').remove();
                                span.after(msg);

                                load.removeClass('fa-plus-square');
                                load.addClass('fa-minus-square');
                            }
                        });
                    }
                } else {
                    let content = data['comment']['content'];
                    let id = data['comment']['id'];
                    let span = $('span[data-comment-id=' + id + ']');

                    span.children('.content').text(content);
                }

                clearForm('Создание нового комментария');
                $('#exampleModal').modal('toggle');

            }
        });
        e.preventDefault();
    });

    tree.on('click', '.delete-comment', function () {
        let span = $(this).parent('span');
        let id = span.data('comment-id');
        $.ajax({
            type: "POST",
            url: '/site/delete?id=' + id,
            dataType: "json",
            success: function (data) {
                if (data['result']) {
                    if (data['content'] === false) {
                        span.parent('li').parent('ul').prev('span').removeClass('parent');
                        span.parent('li').parent('ul').remove();
                    } else {
                        if (data['content'] !== '') {
                            let ul = span.parent('li').parent('ul');
                            ul.replaceWith(data['content']);
                        } else {
                            span.parent('li').remove();
                        }
                    }
                }
            }
        });
    });

    tree.on('click', '.edit-comment', function () {
        let span = $(this).parent('span');
        let id = span.data('comment-id');
        let text = span.children('.content').text();

        clearForm('Изменить комментарий');

        $('#comment-content').val(text);
        $('#comment-form').attr('action', '/site/update?id=' + id);
        $('#exampleModal').modal('toggle');
    });

    function clearForm(title) {
        $('#comment-content').val('');
        $('#comment-parent-id').val('');
        $('#comment-id').val('');
        $('#comment-form').attr('action', CREATE_URL);
        $('#exampleModalLabel').text(title);
    }
});
