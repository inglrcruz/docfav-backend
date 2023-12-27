<?php

/**
 * The Core class responsible for automatic loading of PHP files from specified folders.
 *
 */

namespace System;

class Core
{

    /**
     * This function loads PHP files from folders such as 'config', 'system', 'dtos', 'controllers', and 'repositories'.
     */
    public function autoLoad()
    {
        $folders = ['config', 'system', 'dtos', 'controllers', 'repositories'];
        foreach ($folders as $folder) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    require_once $folder . '/' . $file;
                }
            }
        }
    }
}
