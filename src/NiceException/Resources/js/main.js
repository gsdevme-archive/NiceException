/*jslint nomen: true */
/*global require */

require.config({
	paths: {
		// Libs
		'jquery': 'libs/jquery', // change to zepto if need be
		'underscore': 'libs/underscore',
		'backbone': 'libs/backbone',
		'text': 'libs/text',
	},

	shim: {
		'jquery': {
			exports: '$'
		},
		'underscore': {
			exports: '_'
		},
		'backbone': {
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
		},
		'app': {
			deps: ['underscore', 'jquery', 'backbone']
		}
	}
});

/**
 * To help disable browser cache during development
 */
require.config({
	urlArgs: 'nocache=' + (Math.random() * 642646)
});

require(['app']);