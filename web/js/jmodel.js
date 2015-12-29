angular.module('jmodel', ['ngResource'])
	.factory('Contacts', function ($resource) {
		var Contacts = $resource('/contact/:id', null, {
			update: {method: 'PUT'}
		});

		return Contacts;
	});
