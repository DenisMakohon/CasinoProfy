import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;

export default (function() {

    const $closeForm = $(".js-closeForm"), // Закрыть форму с ответом
        $replyForm = $(".js-replyForm"), // Форма с ответом
        $commentsMoreReviews = $('.js-commentsMoreReviews')

    let replyFormCaptcha = '',
        commentformCaptcha = '',
        commentsMoreReviewsPage = 1

    $('.comment-form').on('submit', e => {
        e.preventDefault();

        let $curCommentForm = $(e.currentTarget), // Текущая форма
            $errorMsg = $curCommentForm.find('.js-errorMsg'), // Сообщения об ошибках
            $textarea = $curCommentForm.find('#comment'),
            $invalidFields = $curCommentForm.find("input:invalid,textarea:invalid") // Невалидные поля

        const regex = /(http:\/\/|https:\/\/|www\.)/;

        $errorMsg.addClass('hide') // Прячем сообщения об ошибках

        // Проверка текстарии на ссылки
        if (regex.test($textarea.val())) $invalidFields = $.merge($invalidFields, $textarea)

        // Если есть ошибки - говорим об этом

        let hasError = $invalidFields.length ? true : false // Флаг ошибок
        hasError = false;
        if (hasError) {
            // Показываем сообщения об ошибках
            $invalidFields.closest('.js-inputContainer')
                .find('.js-errorMsg')
                .removeClass('hide')
        } else {
            // Показываем прелоадер формы
            $curCommentForm.addClass('show')

            $.ajax({
                type: 'POST',
                url: window.ajaxurl,
                data: {
                    action: 'save_comment',
                    form: $curCommentForm.serialize(),
                    curBlog: window.curBlog,
                    curLang: window.curLang
                },
                success: response => {
                    response = JSON.parse(response)

                    if (Object.keys(response.errors).length) {
                        // Если есть ошибки, то выводим сообщения про них
                        for (let k in response.errors) {
                            $(".js-" + k).removeClass('hide')
                        }
                    } else {
                        // Сбрасываем данные формы
                        $curCommentForm.trigger('reset')
                            .find('.js-response')
                            .html(response.success_msg)
                            .addClass("show")

                        // Ресет капчи

                        grecaptcha.reset(replyFormCaptcha)
                        grecaptcha.reset(commentformCaptcha)

                        // Через 5 секунд прячит сообщение с результатом
                        setTimeout(() => {
                            $curCommentForm.find('.js-response')
                                .removeClass("show")
                        }, 5000)
                    }
                },
                error: response => {
                    $curCommentForm.find('.js-response')
                        .addClass("show")

                    setTimeout(() => {
                        $curCommentForm.find('.js-response')
                            .removeClass("show")
                    }, 5000)
                },
                complete: () => {
                    // Прячим прелоадер формы
                    $curCommentForm.removeClass('show')
                }
            });

        }

    })

    // Инициализация капчи
    function loadCaptcha() {

        if ($('#replyform').length) {
            replyFormCaptcha = grecaptcha.render('replyform', {
                'sitekey': recaptcha_site,
                'theme': 'light'
            })
        }

        if ($('#commentform').length) {
            commentformCaptcha = grecaptcha.render('commentform', {
                'sitekey': recaptcha_site,
                'theme': 'light'
            })
        }

    }

    // Вызов инициализации капчи
    $(function() {
        setTimeout(() => loadCaptcha(), 500)
    });
    // Открыть форму с ответом
    $('body').on('click', '.js-commentsReply', e => {
        let commentID = $(e.currentTarget).attr('data-comment_ID')

        $replyForm.addClass('show')
            .find('input[name="comment_parent"]').val(commentID)

    })

    // Закрыть форму с ответом
    $closeForm.on("click", e => {
        let $mainTarget = $(e.target)

        if ($mainTarget.hasClass('js-closeForm')) $replyForm.removeClass("show")
    })

    // Подгрузить комментарии 
    $commentsMoreReviews.on("click", e => {
        let $moreReviews = $(e.currentTarget),
            postID = $moreReviews.attr('data-postID')

        commentsMoreReviewsPage++;
        $moreReviews.addClass('disable')
        $.ajax({
            type: 'GET',
            url: window.ajaxurl,
            data: {
                action: 'comments_load_more',
                post_id: postID,
                page: commentsMoreReviewsPage,
                curBlog: window.curBlog,
            },
            dataType: 'json',
            success: function(response) {

                if (response.comments !== undefined) $('.comments').append(response.comments)

                if (!response.more_comments) $moreReviews.addClass('d-none')

                $moreReviews.removeClass('disable')

            }
        })
    })

    // Подгрузка ответов на комментарии
    $('body').on('click', '.js-answersMore', e => {
        let $moreReplies = $(e.currentTarget),
            commentID = $moreReplies.attr('data-comment_ID'), // ID родительского комментария
            page = Number($moreReplies.attr('data-page')) // Текущая страница пагинации

        page++
        let answersHide = $moreReplies.attr('data-page', page)
            .closest('.js-answersControl')
            .find('.js-answersHide')

        $moreReplies.addClass('disable')

        answersHide.text(answersHide.attr('data-hide'))
            .removeClass('show')

        $.ajax({
            type: 'GET',
            url: window.ajaxurl,
            data: {
                action: 'replies_load_more',
                commentID: commentID,
                page: page,
                curBlog: window.curBlog,
            },
            dataType: 'json',
            success: function(response) {

                if (response.comments !== undefined) $moreReplies.closest('.js-answersControl').before(response.comments)
                $moreReplies.closest('.comments-item-child-container').find('.comments-item').removeClass('d-none')
                if (!response.more_comments) $moreReplies.addClass('d-none')
                $moreReplies.removeClass('disable')
            }
        })

    })

    $('body').on('click', '.js-answersHide', e => {
        let $moreReplies = $(e.currentTarget)

        $moreReplies.toggleClass('show')

        // Менякм текст в зависимости от состояния кнопки
        if ($moreReplies.hasClass('show')) {
            $moreReplies.text($moreReplies.attr('data-show'))
        } else {
            $moreReplies.text($moreReplies.attr('data-hide'))
        }

        $moreReplies.closest('.comments-item-child-container')
            .find('.comments-item')
            .toggleClass('d-none')

    })

})()