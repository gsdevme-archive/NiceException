/*jslint nomen: true */
/*global define, Backbone, $, _ */

define([
	'models/exception'
], function (Exception) {
	'use strict';

	return Backbone.Collection.extend({
		model: Exception

	});
});