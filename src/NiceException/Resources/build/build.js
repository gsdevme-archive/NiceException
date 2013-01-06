({
	baseUrl: '../js',
	mainConfigFile: '../js/main.js',

	out: '../js/application.min.js',

	optimize: "uglify",

	preserveLicenseComments: false,
	findNestedDependencies: true,

	paths: {
		requireLib: 'libs/require',
	},
	name: 'main',
	include: 'requireLib',
	useStrict: true,

wrap: {
		start: "(function() {",
		end: "}());"
	}
})