angular.module('starter.controllers', [])
    .controller('HomeCtrl', function ($scope, Posts) {
    })

    .controller('ProductsCtrl', function ($scope, Posts) {
        $scope.reload = function() {
            Posts.query(function(posts){
                $scope.posts = posts;
                console.log($scope.posts[0]);
            });
        };

        $scope.reload();
    })

    .controller('ProductsShowCtrl', function($scope, $stateParams, Posts){

        $scope.reload = function(){
          $scope.post = Posts.get({id: $stateParams.id})
          console.log($scope.post);
        };

        $scope.reload();

    })

    .controller('PhotosCtrl', function ($scope, $ionicModal, Media) {

        $scope.photos2 = [];

        $scope.reload = function() {
            Media.query(function(photos){
                $scope.photos = photos;

                console.log($scope.photos[0]);

                while ($scope.photos.length) {
                    $scope.photos2.push($scope.photos.splice(0, 2))
                }
            });


        };

        $scope.reload();

        $ionicModal.fromTemplateUrl('my-modal.html', {
            scope: $scope,
            animation: 'slide-in-up'
        }).then(function(modal) {
            $scope.modal = modal;
        });
        $scope.openModal = function(photo) {
            $scope.photo = photo;
            $scope.modal.show();
        };
        $scope.closeModal = function() {
            $scope.modal.hide();
        };

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
