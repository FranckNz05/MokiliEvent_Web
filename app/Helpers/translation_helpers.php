<?php

if (!function_exists('t')) {
    /**
     * Traduit une clé dans la langue actuelle
     */
    function t($key, $locale = null, $group = 'general')
    {
        return app('translations')->get($key, $locale, $group);
    }
}

if (!function_exists('settings')) {
    /**
     * Récupère un paramètre de configuration
     */
    function settings($group, $name, $default = null)
    {
        return app('settings')->get($group, $name, $default);
    }
}
