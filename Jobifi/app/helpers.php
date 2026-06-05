<?php

if (!function_exists('named_route')) {
    /**
     * Return a named route URL or the current URL if no name is given.
     *
     * @param string|null $name   Route name (optional)
     * @param array       $params Route parameters (optional)
     * @return string
     */
    function named_route(?string $name = null, array $params = []): string
    {
        return $name ? route($name, $params) : url()->current();
    }
}

?>
