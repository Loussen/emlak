(function ($) {

    $(function () {

        $('.rf').each(function () {
            // Объявляем переменные (форма и кнопка отправки)
            var form = $(this),
                    btn = form.find('.btn_submit');

            // Добавляем каждому проверяемому полю, указание что поле пустое
            form.find('.rfield').addClass('empty_field');

            // Функция проверки полей формы
            function checkInput() {
                form.find('.rfield').each(function () {
                    if ($(this).val() != '') {
                        // Если поле не пустое удаляем класс-указание
                        $(this).removeClass('empty_field');
                    } else {
                        // Если поле пустое добавляем класс-указание
                        $(this).addClass('empty_field');
                    }
                });
            }

            // Функция подсветки незаполненных полей
            function lightEmpty() {
                form.find('.empty_field').css({'border-color': '#d8512d'});
                // Через полсекунды удаляем подсветку
                setTimeout(function () {
                    form.find('.empty_field').removeAttr('style');
                }, 3000);
            }

            // Проверка в режиме реального времени
            setInterval(function () {
                // Запускаем функцию проверки полей на заполненность
                checkInput();
                // Считаем к-во незаполненных полей
                var sizeEmpty = form.find('.empty_field').size();
                // Вешаем условие-тригер на кнопку отправки формы
                if (sizeEmpty > 0) {
                    if (btn.hasClass('disabled')) {
                        return false
                    } else {
                        btn.addClass('disabled')
                    }
                } else {
                    btn.removeClass('disabled')
                }
            }, 500);

            // Событие клика по кнопке отправить
            btn.click(function () {
                if ($(this).hasClass('disabled')) {
                    // подсвечиваем незаполненные поля и форму не отправляем, если есть незаполненные поля
                    lightEmpty();
                    var scroll_el = $(".rf"); // возьмем содержимое атрибута href
                    if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
                        $('html, body').animate({scrollTop: $(scroll_el).offset().top}, 500); // анимируем скроолинг к элементу scroll_el
                    }
                    return false;
                    return false;
                } else {
                    // Все хорошо, все заполнено, отправляем форму
                    form.submit();
                }
				
				
            });
        });
    });



})(jQuery);
