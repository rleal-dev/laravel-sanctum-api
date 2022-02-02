<?php

if (! function_exists('is_development')) {

    /**
     * Checks is development environment.
     *
     * @return boolean
     */
    function is_development()
    {
        return app()->environment('local');
    }
}
