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
    'quill2-emoji' => [
        'version' => '0.1.2',
    ],
    'quill' => [
        'version' => '2.0.3',
    ],
    'quill2-emoji/dist/style.css' => [
        'version' => '0.1.2',
        'type' => 'css',
    ],
    'lodash-es' => [
        'version' => '4.17.21',
    ],
    'parchment' => [
        'version' => '3.0.0',
    ],
    'quill-delta' => [
        'version' => '5.1.0',
    ],
    'eventemitter3' => [
        'version' => '5.0.1',
    ],
    'fast-diff' => [
        'version' => '1.3.0',
    ],
    'lodash.clonedeep' => [
        'version' => '4.5.0',
    ],
    'lodash.isequal' => [
        'version' => '4.5.0',
    ],
    'quill/dist/quill.snow.css' => [
        'version' => '2.0.3',
        'type' => 'css',
    ],
    'quill/dist/quill.bubble.css' => [
        'version' => '2.0.3',
        'type' => 'css',
    ],
    'axios' => [
        'version' => '1.11.0',
    ],
    'quill-resize-image' => [
        'version' => '1.0.11',
    ],
    'quill-table-better' => [
        'version' => '1.2.1',
    ],
    'quill-table-better/dist/quill-table-better.css' => [
        'version' => '1.2.1',
        'type' => 'css',
    ],
];
