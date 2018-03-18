<?php

/**
 *
 * @author Pontus Horn
 * @link https://pontushorn.me
 * @repository https://github.com/PontusHorn/Pico-Random-Page
 * @license http://opensource.org/licenses/MIT
 */

class PicoRandomPage extends AbstractPicoPlugin
{

    private $is_requested = false;
    private $scope;

    /**
     * Triggered after Pico evaluated the request URL
     *
     * @see    Pico::getBaseUrl()
     * @see    Pico::getRequestUrl()
     * @param  string &$url request URL
     * @return void
     */
    public function onRequestUrl(&$url)
    {
        if (preg_match('/^(.+\/)?random$/', $url, $matches)) {
            $this->is_requested = true;

            if (!empty($matches[1])) {
                $this->scope = $matches[1];
            }
        }
    }

    /**
     * If a random page was requested, find a random page within the scope and redirect to it
     *
     * @see    Pico::getPages()
     * @see    Pico::getCurrentPage()
     * @see    Pico::getPreviousPage()
     * @see    Pico::getNextPage()
     * @param  array &$pages        data of all known pages
     * @param  array &$currentPage  data of the page being served
     * @param  array &$previousPage data of the previous page
     * @param  array &$nextPage     data of the next page
     * @return void
     */
    public function onPagesLoaded(&$pages, &$currentPage, &$previousPage, &$nextPage)
    {
        if ($this->is_requested) {
            if (isset($this->scope)) {
                $pages = array_filter($pages, [$this, 'isPageInScope']);
            }

            $pico = $this->getPico();

            $excludes = $pico->getConfig('random_page_excludes');
            if (!empty($excludes)) {
                foreach ($excludes as $exclude_path) {
                    unset($pages[$exclude_path]);
                }
            }

            header('Location: ' . rtrim($pico->getBaseUrl(), '/') . '?' . array_rand($pages));
            exit;
        }
    }

    private function isPageInScope($page) {
        return substr($page['id'], 0, strlen($this->scope)) === $this->scope;
    }
}
