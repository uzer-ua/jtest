angular.module('jtest', ['jmodel'])
	.config(function ($routeProvider) {
		$routeProvider
			.when('/', {
				controller: listController,
				templateUrl: '/templates/list.html'
			})
			.otherwise({redirectTo: '/'});
	});


function listController($scope, Contacts) {
	$scope.contacts = Contacts.query();

	$scope.edit = function () {

	};
}
