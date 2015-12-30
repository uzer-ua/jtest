var jtestApp = angular.module('jtest', ['jmodel'])
	.config(function ($routeProvider) {
		$routeProvider
			.when('/', {
				controller: listController,
				templateUrl: '/templates/list.html'
			})
			.otherwise({redirectTo: '/'});
	})
	.directive('ngdialog', function () {
		return {
			restrict: 'E',
			controller: function ($scope, $element) {
				$scope.hide = function () {
					$scope.show = false;
					$scope.cleanup();
				};
				$scope.cleanup = function () {

				};
			}
		};
	});


function listController($scope, Contact) {
	$scope.contacts = Contact.query();

	$scope.contact = {};
	$scope.show = false;
	$scope.editableIndex = -1;

	$scope.new = function () {
		$scope.editableIndex = -1;
		$scope.contact = new Contact();
		$scope.show = true;
	};

	$scope.edit = function () {
		$scope.editableIndex = this.$index;
		if (this.$index != -1) {
			$scope.contact = $scope.contacts[this.$index];
		}
		else {
			$scope.contact = {};
		}
		$scope.contact = new Contact($scope.contact);
		$scope.show = true;
	};

	$scope.save = function () {
		var saveCallback = function ($args) {
			if ($scope.editableIndex != -1) {
				$scope.contacts[$scope.editableIndex] = {
					id: $scope.contact.id,
					name: $scope.contact.name,
					tel: $scope.contact.tel
				};
			}
			else {
				$scope.contacts.push({
					id: $scope.contact.id,
					name: $scope.contact.name,
					tel: $scope.contact.tel
				});
			}
			$scope.hide();
		};

		if ($scope.editableIndex != -1) {
			$scope.contact.$update({
				id: $scope.contact.id
			}, saveCallback);
		}
		else {
			$scope.contact.$save(saveCallback);
		}
	};

	$scope.delete = function () {
		//TODO: create ng-confirm component, or multifunctional ng-dialog for all dialogs
		$scope.editableIndex = this.$index;
		if (confirm('Are you sure?')) {
			Contact.delete({id:$scope.contacts[$scope.editableIndex].id}, function () {
				$scope.contacts.splice($scope.editableIndex, 1);
				$scope.editableIndex = -1;
			});
		}
		else {
			$scope.editableIndex = -1;
		}
	};

	$scope.hide = function () {
		$scope.editableIndex = -1;
		$scope.show = false;
	}
}
