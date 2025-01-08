/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. 	
	config.uiColor = '#F6F6F6';
    config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;15/15px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px' ;         
    config.skin = 'kama';
    config.undoStackSize = 90;   
	
	config.height = "300px";
    config.disableNativeSpellChecker = false;
    config.scayt_autoStartup = false;

    config.toolbarCanCollapse = false;
    config.toolbar = 'Cms';
    config.toolbar_Cms =
    [        
        ['Cut','Copy','Paste'],
        ['Undo','Redo'],
		['SpecialChar'],
		['Image'],
        '/',
        ['Bold','Italic','-','Subscript','Superscript'],
        ['NumberedList','BulletedList'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],                        
        ['Styles','Format','FontSize'],
        ['TextColor']
    ];

};
