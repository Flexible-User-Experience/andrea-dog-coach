<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@hotwired/turbo' => [
        'version' => '8.0.13',
    ],
    'easymde' => [
        'version' => '2.20.0',
    ],
    'codemirror' => [
        'version' => '5.65.18',
    ],
    'codemirror/addon/edit/continuelist.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/addon/display/fullscreen.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/mode/markdown/markdown.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/addon/mode/overlay.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/addon/display/placeholder.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/addon/display/autorefresh.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/addon/selection/mark-selection.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/addon/search/searchcursor.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/mode/gfm/gfm.js' => [
        'version' => '5.65.18',
    ],
    'codemirror/mode/xml/xml.js' => [
        'version' => '5.65.18',
    ],
    'codemirror-spell-checker' => [
        'version' => '1.1.2',
    ],
    'marked' => [
        'version' => '4.3.0',
    ],
    'typo-js' => [
        'version' => '1.2.5',
    ],
    'codemirror/lib/codemirror.min.css' => [
        'version' => '5.65.18',
        'type' => 'css',
    ],
];
