(function(wp) {
    wp.domReady(function() {
        wp.data.subscribe(function() {
            const template = wp.data.select('core/editor').getEditedPostAttribute('template');

            // Получаем body документа
            const body = document.body;

            if (template === 'casinos.php') {
                // Добавляем класс к body, если шаблон соответствует
                body.classList.add('show-plashka-metabox');
            } else {
                // Убираем класс, если шаблон не соответствует
                body.classList.remove('show-plashka-metabox');
            }
        });
    });
})(window.wp);