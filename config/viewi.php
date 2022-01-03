<?php

use Viewi\PageEngine;

return [
    /**
     * Location of components source code
     */
    PageEngine::SOURCE_DIR => app_path('Components'),

    /**
     * Target directory of compiled php components
     */
    PageEngine::SERVER_BUILD_DIR => app_path('build'),

    /**
     * Public root folder of application (location of index.php)
     */
    PageEngine::PUBLIC_ROOT_DIR => public_path(),

    /**
     * true if you are in developing mode.
     * All components will be compiled as soon as request occurs.
     * Default: true.
     */
    PageEngine::DEV_MODE => (bool) env('APP_DEBUG', false),

    /**
     * true if you want to render into variable, otherwise - echo output, Default: true.
     */
    PageEngine::RETURN_OUTPUT => true,

    /**
     * combine all viewi scripts into one, use in production.
     */
    PageEngine::COMBINE_JS => (bool) env('APP_DEBUG', false),
];
