/*jslint nomen: true */
/*global window, document, require, define, Backbone, $, _ */

define([
	'views/home/index'
], function (HomeView) {
	'use strict';

	// All sections created within here
	var appDom = null,
		AppRouter = null,
		router = null;

	(function () {
		// Clear any loading junk
		$('body').empty();

		appDom = $('<div></div>').attr('id', 'application');

		// Create the Application Dom
		$('body').append(appDom);
	}());

	// View loader
	function view(View, viewName, options, context) {
		// Ensure i dont forget to give a viewname
		if (_.isUndefined(viewName)) {
			throw "ViewName was not defined, its a must!";
		}

		// MSIE
		if (typeof (window.CollectGarbage) === "function") {
			window.CollectGarbage();
		}

		// If we have a current view lets send it to sleep
		if (!_.isNull(context._activeView)) {
			context._activeView.sleep();
		}

		// Mainly for CSS stuff this
		$('body').attr('id', viewName);

		// If the view doesn't have a section
		if ($('section#' + viewName).length <= 0) {
			var el = document.createElement('section');
			el.setAttribute('id', viewName);
			appDom.append(el);
		}

		// is it in our viewMap already? if not create & store
		if (_.isNull(context._viewMap[viewName])) {
			context._viewMap[viewName] = new View({
				el: $('section#' + viewName),
				viewName: viewName
			});

			context._viewMap[viewName].wakeup(options);
		} else {
			context._viewMap[viewName].wakeup(options);
		}

		context._activeView = context._viewMap[viewName];
	}

	// the main application router,
	AppRouter = Backbone.Router.extend({
		_activeView : null,
		_viewMap: null,

		// application routes !
		routes: {
			'': 'home'
		},

		initialize: function () {
			this._viewMap = {
				home: null,
				cat: null
			};
		},

		home: function () {
			view(HomeView, 'home', null, this);
		}

	});

	router = new AppRouter();

	Backbone.history.start();
});