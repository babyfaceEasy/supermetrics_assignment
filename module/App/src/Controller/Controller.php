<?php

namespace App\Controller;

/**
 * Class Controller
 *
 * @package App\Controller
 */
abstract class Controller implements ControllerInterface
{

    /**
     * @param array  $vars
     * @param string $template
     * @param bool   $useLayout
     */
    public function render(array $vars, string $template, $useLayout = true)
    {
        $templateFile = sprintf(__DIR__ . '/../../view/%s.phtml', $template);
        if (!file_exists($templateFile)) {
            throw new \RuntimeException(sprintf('Template %s not found', $template));
        }

        extract($vars);

        $content = $templateFile;

        if (true === $useLayout) {
            include __DIR__ . '/../../view/layout.phtml';

            return;
        }

        include $content;
    }
}
