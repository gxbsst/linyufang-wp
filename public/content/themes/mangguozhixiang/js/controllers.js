angular.module('starter.controllers', [])
    .controller('HomeCtrl', function ($scope, Posts) {
    })

    .controller('ProductsCtrl', function ($scope, Posts, User) {
        $scope.reload = function() {
            Posts.query(function(posts){
                $scope.posts = posts;
                console.log($scope.posts[0]);
            });
            User.get({id: 'me'},function(user){
                $scope.user = user;
                console.log($scope.user);
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

    .controller('OrdersCtrl', function ($scope, $ionicModal) {
        $ionicModal.fromTemplateUrl('/templates/login_modal.html', {
            scope: $scope,
            animation: 'slide-in-up'
        }).then(function(modal) {
            $scope.modal = modal;
            $scope.modal.show();
        });

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
    })

    .controller('LoginCtrl', function ($scope, $location, $rootScope, Auth) {
      $scope.login = function(user, loginForm){
              Auth.login({
                      username: user.username,
                      password: user.password
                  },
                  function(res) {
                      console.log('sucess', res);
                      $location.path('/');
                  },
                  function(err) {
                      console.log('err', err);
                      $rootScope.error = "Failed to login";
                  });
          };
          return false;
    })
    .controller('RegisterCtrl', function ($scope, $location, $rootScope, Auth) {
        $scope.register = function(user){
                Auth.register({
                        username: user.username,
                        email: user.email,
                        password: user.password
                    },
                    function(res) {
                          console.log(res);
//                        $location.path('/');
                    },
                    function(err) {
                        console.log(err);
                        $rootScope.error = "Failed to register";
                    });
            return false;
        }
    })
;
