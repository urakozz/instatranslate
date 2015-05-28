<?php
/**
 * Desc
 *
 * PHP Version 5
 */

if ( ! function_exists('elixir_static'))
{
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string  $file
     * @return string
     */
    function elixir_static($file)
    {
        static $manifest = null;

        if (is_null($manifest))
        {
            $manifest = json_decode(file_get_contents(public_path().'/build/rev-manifest.json'), true);
        }

        return env("APP_HOST_STATIC").'/build/'.$manifest[$file];
    }
}