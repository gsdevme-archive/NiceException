/*jslint nomen: true */
/*global define, Backbone, $, _ */

define(function () {
	'use strict';

	return Backbone.View.extend({
		_viewName: null,

		initialize: function (options) {
			Backbone.View.prototype.initialize.call(this, options);

			this._viewName = options.viewName;
		},

		/**
		 * Renders out the string, supports both pre-render/post-render callbacks
		 *
		 * @developer Gav
		 * @param     string html
		 * @param     function preCallback  pass NULL if you dont want
		 * @param     function postCallback pass NULL if you dont want
		 * @param     object context      This is very handy for passing "this"
		 */
		renderer: function (html, preCallback, postCallback, context) {
			if (_.isFunction(preCallback)) {
				preCallback.call(context);
			}

			// Gav: Fadeout
			$.when(this.$el.fadeOut('fast')).done(function () {
				// Gav: Once we have fadedOut apply our template
				this.html(html);

				// Gav: Once we have fadedIn pop post-render
				$.when(this.fadeIn('fast')).done(function () {

					if (_.isFunction(postCallback)) {
						postCallback.call(context);
					}
				});
			});
		},

		getViewName: function () {
			return this._viewName;
		},

		sleep: function () {
			this.undelegateEvents();
			this.$el.hide();
		},

		wakeup: function () {
			this.delegateEvents();
		}
	});
});