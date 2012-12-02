/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'iStructAdmin';
 
	config.toolbar_iStructAdmin =
	[
		{
			name: 'whole',
			items : [ 'Source','-','Image','Bold','Italic','NumberedList','BulletedList','Blockquote','-','Link','Unlink','Anchor' ]
		}
	];
};
