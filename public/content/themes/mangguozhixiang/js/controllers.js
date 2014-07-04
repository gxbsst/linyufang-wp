angular.module('starter.controllers', [])
    .controller('HomeCtrl', function ($scope) {

    })

    .controller('PhotosCtrl', function ($scope) {

    })

    .controller('PhotosShowCtrl', function ($scope) {

    })

    .controller('OrdersCtrl', function ($scope) {

    })

    .controller('OrdersShowCtrl', function ($scope) {

    })

    .controller('DashCtrl', function ($scope) {
    })

    .controller('FriendsCtrl', function ($scope, Friends) {
        $scope.friends = Friends.all();
    })

    .controller('FriendDetailCtrl', function ($scope, $stateParams, Friends) {
        $scope.friend = Friends.get($stateParams.friendId);
    })

    .controller('AccountCtrl', function ($scope) {
    });
