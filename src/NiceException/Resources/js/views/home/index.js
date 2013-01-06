/*jslint nomen: true */
/*global define, Backbone, $, _, window */

define([
	'abstract/views/app',
	'models/collections/exceptions',
	'text!templates/home/index.html',
	'text!templates/home/exception.html'
], function (AppView, Exceptions, homeTemplate, exceptionTemplate) {
	'use strict';

	return AppView.extend({
		_exceptions: null,

		initialize: function (options) {
			AppView.prototype.initialize.call(this, options);

			this._exceptions = new Exceptions(window.exceptions);
		},

		render: function () {
			var exceptionsTemplate = '';

			this._exceptions.each(function (exception) {
				exceptionsTemplate += _.template(exceptionTemplate, {
					data: {
						exception: exception.toJSON()
					}
				});
			});

			this.renderer(_.template(homeTemplate, {
				data: {
					exceptions: exceptionsTemplate
				}
			}));
		},

		wakeup: function (options) {
			this.render();

			AppView.prototype.wakeup.call(this, options);
		}

	});
});