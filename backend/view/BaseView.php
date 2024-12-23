<?php

namespace backend\view;

class BaseView
{
    /**
     * @param string $template
     * @param array $variables
     * @return false|string
     */
    public function renderTemplate(string $template, array $variables = []): false|string
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

    public function render(string $viewName, array $variables = []): false|string
    {
        $template = __DIR__  . $viewName . '.php';
        if (file_exists($template)) {
            return $this->renderTemplate($template, $variables);
        }
        return false;
    }
}
