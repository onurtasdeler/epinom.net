/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
CKEDITOR.config.allowedContent = true

CKEDITOR.editorConfig = function( config ) {

    config.contentsCss = ["https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css",

        ];
	config.language = 'tr';
    config.allowedContent = true;
    config.filebrowserUploadMethod = 'form';
    config.entities = true;
    config.enterMode = CKEDITOR.ENTER_BR;
};
