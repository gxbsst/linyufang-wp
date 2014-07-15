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

  .controller('ProductsShowCtrl', function ($scope, $stateParams, Posts, $ionicLoading, $ionicModal, Comment, $rootScope, Plans, $ionicPopup, $location, Auth) {

    $scope.product = {};

    $scope.plans = Plans;

    $scope.reload = function () {
      $ionicLoading.show({
        template: '正在载入...'
      });
      Posts.get({id: $stateParams.id}).$promise.then(function (post) {
        $ionicLoading.hide();
        $scope.post = post;
      });
    };

    $scope.reload();

    $ionicModal.fromTemplateUrl('/templates/comment-modal.html', {
      scope: $scope,
      animation: 'slide-in-up'
    }).then(function (modal) {
      $scope.modal = modal;
    });

    $scope.newComment = function (post) {
      $scope.modal.show();
    };


    $ionicModal.fromTemplateUrl('/templates/checkout-modal.html', {
      scope: $scope,
      animation: 'slide-in-up'
    }).then(function (modal) {
      $scope.checkoutModal = modal;
    });

    $scope.checkout = function (post, product) {

      if (!Auth.isLoggedIn()){
        $location.path('/tab/login');
        return false;
      }

      if(!product.plan) {
        var alertPopup = $ionicPopup.alert({
          title: '信息提示',
          template: '请选择你需要购买的套餐或者输入购买的数量，谢谢.'
        });
        alertPopup.then(function(res) {
          console.log('Thank you for not eating my delicious ice cream cone');
        });
        return false;
      }

      $scope.checkoutModal.show().then(function(){
        $rootScope.post = post;
        $rootScope.product = product;

        var planIndex;

        switch(product.plan){
          case 88:
            planIndex = 0;
            break;
          case 168:
            planIndex = 1;
            break;
          default:
            planIndex = undefined;
        }

        if(planIndex != undefined ){
          $rootScope.selectPlan = Plans[planIndex];
          $rootScope.planInfo = Plans[planIndex]['name'] + ' - ' + Plans[planIndex]['text'];
        }else{
          $rootScope.selectPlan = {name: product.plan, value: '', text: ''}
          $rootScope.planInfo = product.plan;
        }

      });
    }

  })

  .controller('CommentCtrl', function ($scope, Comment, $stateParams, $rootScope) {

    $scope.cancelComment = function () {
      $scope.$parent.modal.hide();
    }

    $scope.comment = [];
    $scope.postComment = function (post) {
      Comment.createComment({post_id: $stateParams.id, comment: $scope.comment.content}, function (res) {
        $rootScope.$broadcast('comment:create');
        $scope.$parent.modal.hide();
      });
    }

  })

  .controller('CheckoutCtrl', function ($scope, Order, $stateParams, $rootScope, $location, Plans) {

    $scope.plans = Plans;
    $scope.order = [];


    $scope.cancelCheckout = function () {
      $scope.$parent.checkoutModal.hide();
    }

    $scope.doCheckout = function (post) {

      Order.create({
          input_1: $stateParams.id,
          input_3: post.title,
          input_4: $rootScope.selectPlan['value'],
          input_5: $scope.order.address,
          input_6: $scope.order.username,
          input_7: $scope.order.phone,
          input_12: $rootScope.selectPlan['name']
        },
        function (res) {
          $rootScope.$broadcast('order:create');
          $scope.$parent.checkoutModal.hide();
          $location.path('tab/orders');
        });
    }

  })

  .controller('CommentListCtrl', function ($scope, PostComment, $stateParams) {

    $scope.reloadComment = function () {
      PostComment.query({id: $stateParams.id}).$promise.then(function (comments) {
        $scope.comments = comments;
        console.log($scope.comments);
      })
    }

    $scope.reloadComment();

    $scope.$on("comment:create", function (event) {
      $scope.reloadComment();
      return;
    });
  })

  .controller('PhotosCtrl', function ($scope, $ionicModal, Media, $ionicLoading) {

    $scope.photos2 = [];

    $scope.reload = function () {
      $ionicLoading.show({
        template: '正在载入...'
      });
      Media.query(function (photos) {
      }).$promise.then(function (photos) {
          $ionicLoading.hide();
          $scope.photos = photos;
          while ($scope.photos.length) {
            $scope.photos2.push($scope.photos.splice(0, 2))
          }
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

  .controller('OrdersCtrl', function ($scope, $ionicModal, $rootScope, Order, $ionicLoading, $location, $ionicPopup) {

    $scope.reload = function () {
      $ionicLoading.show({
        template: '正在载入...'
      });
      Order.query(function(orders){
         $scope.orders = orders;
         console.log(orders);
        $ionicLoading.hide();
      },
        function(err) {
          alert(err);
        }
      );
    };

    $scope.reload();

    $scope.viewOrder = function(order) {
      $rootScope.order = order;
      $location.path('tab/orders/' + order[10]);
    }


    $scope.cancelOrder = function(order) {
      var confirmPopup = $ionicPopup.confirm({
        title: '取消订单',
        template: '取消订单后，该订单不可回复， 您确定？',
        cancelText: '取消',
        okText: '确定'
      });

      confirmPopup.then(function(res) {
        if(res) {
          Order.cancel(
            order,
            function(success){
              order[8] = 'cancel';
            },
            function(error){

            })
        } else {
          console.log('You are not sure');
        }
      });
    }

  })

  .controller('OrdersShowCtrl', function ($scope) {

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
