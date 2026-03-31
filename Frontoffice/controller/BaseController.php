<?php

declare(strict_types=1);

class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../views/pages/' . $view . '.php';
    }
}
