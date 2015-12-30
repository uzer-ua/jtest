angular.module('jmodel', ['ngResource'])
	.factory('Contact', function ($resource) {
		var Contact = $resource('/contact/:id', null, {
			update: {
				method: 'PUT',
				params: {id: '@id'},
				isArray: false
			}
		}, {
			//what a strange Silex routing...
			stripTrailingSlashes: false
		});

		Contact.prototype.update = function(cb) {
			return Contact.update({id: this._id.$oid},
				angular.extend({}, this, {_id:undefined}), cb);
		};

		return Contact;
	});
