<?php
namespace backend\view;

class BaseView
{

    /**
     * @param string $template
     * @param array $variables
     * @return false|string
     */
    function renderTemplate(string $template, array $variables = []): false|string
    {
        // Розпаковуємо змінні, щоб їх можна було використовувати в шаблоні
        extract($variables);

        // Включаємо буферизацію виводу
        ob_start();

        // Підключаємо шаблон
        require $template;

        // Повертаємо відрендерений контент
        return ob_get_clean();
    }

}