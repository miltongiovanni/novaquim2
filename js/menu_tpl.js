/* Tigra Menu template structure */
var MENU_TPL = [
{ 
	'width' : 154, 
	'height' : 25, 
	// C. Horizontal Offset between the items within level in pixels 
	'left' : 154,
	'top' : 0,
	'hide_delay': 200,//200
	'expd_delay': 200,//200
	'css': {
		'inner': 'TM0i0',
		'outer': ['TM0o0','TM0o1']
	},
	'block_left' : 0, //null
	'block_top' : 0 //null
},
{ 
	// A. Item's width in pixels 
	'width' : 154,
	// B. Item's height in pixels 
	'left' : 0,
	'top' : 25,
	'block_left' : 0,
	'block_top' : 25, //25
	'css': {
			'inner': 'TM0i0',
			'outer': ['TM1o0','TM1o1']
		}
	},
	{ 
		'width' : 190,
		'block_top': 0,
		'block_left' : 140
	}
];
