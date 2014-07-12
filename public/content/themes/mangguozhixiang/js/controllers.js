angular.module('starter.controllers', ['ngSanitize'])
  .controller('HomeCtrl', function ($scope, Posts) {
  })

  .controller('ProductsCtrl', function ($scope, Posts, User, $ionicLoading) {
    $scope.reload = function () {
      $ionicLoading.show({
        template: '正在载入...'
      });
      Posts.query(function (posts) {
        $scope.posts = posts;
      })
        .$promise.then(function () {
          $ionicLoading.hide();
        });
    };

    $scope.reload();
  })

  .controller('ProductsShowCtrl', function ($scope, $stateParams, Posts) {

    $scope.reload = function () {
      $scope.post = Posts.get({id: $stateParams.id})
    };

    $scope.reload();

  })

  .controller('PhotosCtrl', function ($scope, $ionicModal, Media, $ionicLoading) {

    $scope.photos2 = [];

    $scope.reload = function () {
      Media.query(function (photos) {
        $ionicLoading.show({
          template: '正在载入...'
        });

        $scope.photos = photos;

        while ($scope.photos.length) {
          $scope.photos2.push($scope.photos.splice(0, 2))
        }
      }).$promise
        .then(function () {
          $ionicLoading.hide();
        });
    };

    $scope.reload();

    $ionicModal.fromTemplateUrl('my-modal.html', {
      scope: $scope,
      animation: 'slide-in-up'
    }).then(function (modal) {
      $scope.modal = modal;
    });
    $scope.openModal = function (photo) {
      $scope.photo = photo;
      $scope.modal.show();
    };
    $scope.closeModal = function () {
      $scope.modal.hide();
    };

  })

  .controller('PhotosShowCtrl', function ($scope) {


  })

  .controller('OrdersCtrl', function ($scope, $ionicModal) {

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

  .controller('AccountCtrl', function ($scope, $rootScope, $cookieStore, Auth, $location, User, $ionicLoading) {
    $rootScope.currentUser = $cookieStore.get('user');

    $scope.loadCurrentUser = function () {
      $ionicLoading.show({
        template: '正在载入...'
      });
      User.get({id: 'me'},function (user) {
        $scope.user = user;
      }).$promise.then(function () {
          $ionicLoading.hide();
        }
      );
    }

    $scope.loadCurrentUser();

    $scope.logout = function () {
      Auth.logout(
        function (req) {
          $location.path('/tab/login');
        },
        function (err) {

        }
      )
    }
  })

  .controller('LoginCtrl', function ($scope, $location, $rootScope, Auth, $cookieStore) {

    if (Auth.isLoggedIn())
      $location.path('/')

    $scope.username = '';
    $scope.password = '';
    $scope.login = function () {
      Auth.login({
          username: $scope.username,
          password: $scope.password
        },
        function (res) {
          $rootScope.currentUser = $cookieStore.get('user');
          $location.path('/tab/products');
        },
        function (err) {
          console.log('err', err);
          $rootScope.error = "Failed to login";
        });
    };
    return false;
  })
  .controller('RegisterCtrl', function ($scope, $location, $rootScope, Auth, $window) {

    if (Auth.isLoggedIn())
      $window.location.href = '#/tab/account';

    $scope.user = [];
    $scope.user.username = '';
    $scope.user.email = '';
    $scope.user.password = '';

    $scope.register = function () {
      Auth.register({
          username: $scope.user.username,
          email: $scope.user.email,
          password: $scope.user.password
        },
        function (res) {
          console.log(res);
          $location.path('/tab/login');
        },
        function (err) {
          console.log(err);
          $rootScope.error = "Failed to register";
          $location.path('/tab/register');
        });
      return false;
    }
  })

  .controller('ResetPasswordCtrl', function ($scope, $location, $rootScope, $ionicPopup, $http, $sanitize) {

    $scope.user = [];
    $scope.user.username = '';
    $scope.user.password = '';

    $scope.resetPassword = function () {
      $http.post('/site/wp-admin/admin-ajax.php?action=ajaxresetpassword', {password: $sanitize($scope.user.password)}).success(function (res) {
        $scope.showAlert();
      }).error(function (err) {
        alert(err);
      });
      return false;
    }

    $scope.showAlert = function () {
      var alertPopup = $ionicPopup.alert({
        title: '信息',
        template: '修改密码成功!'
      });
      alertPopup.then(function (res) {
        $location.path('/tab/account')
      });
    };

  })
;
