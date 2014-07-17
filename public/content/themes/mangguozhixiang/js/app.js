// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
var APP = angular.module('starter', ['ionic', 'starter.controllers', 'starter.services', 'ngCookies'])

    .run(function ($ionicPlatform) {
      $ionicPlatform.ready(function () {
        // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
        // for form inputs)
        if (window.cordova && window.cordova.plugins.Keyboard) {
          cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        }
        if (window.StatusBar) {
          // org.apache.cordova.statusbar required
          StatusBar.styleDefault();
        }
      });
    })

    .value({
      Actions: {
        post: {method: 'POST'},
        add: {method: 'POST'},
        put: {method: 'PUT'},
        update: {method: 'PUT'},
        remove: {method: 'DELETE'}
      },
      Plans: [
        {name: '套餐一', value: 88, text: '5千克 - 88元'},
        {name: '套餐二', value: 158, text: '10千克 - 158元'}
      ]
    })

    .config(function ($stateProvider, $urlRouterProvider, $httpProvider, $locationProvider) {

      var access = routingConfig.accessLevels;

      $httpProvider.defaults.headers.common['X-Wp-Nonce'] = WP_API_Settings.nonce;
      $httpProvider.defaults.headers.common['GFORM-State'] = WP_API_Settings.form_state;
      $httpProvider.defaults.headers.common['GFORM-Unique_Id'] = WP_API_Settings.form_unique_id;

//            $locationProvider.html5Mode(true);

      $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

      /**
       * The workhorse; converts an object to x-www-form-urlencoded serialization.
       * @param {Object} obj
       * @return {String}
       */
      var param = function (obj) {
        var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

        for (name in obj) {
          value = obj[name];

          if (value instanceof Array) {
            for (i = 0; i < value.length; ++i) {
              subValue = value[i];
              fullSubName = name + '[' + i + ']';
              innerObj = {};
              innerObj[fullSubName] = subValue;
              query += param(innerObj) + '&';
            }
          }
          else if (value instanceof Object) {
            for (subName in value) {
              subValue = value[subName];
              fullSubName = name + '[' + subName + ']';
              innerObj = {};
              innerObj[fullSubName] = subValue;
              query += param(innerObj) + '&';
            }
          }
          else if (value !== undefined && value !== null)
            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
        }

        return query.length ? query.substr(0, query.length - 1) : query;
      };

      // Override $http service's default transformRequest
      $httpProvider.defaults.transformRequest = [function (data) {
        return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
      }];


      jQuery.ajaxSetup({
        global: true,
        headers: {
          'X-WP-Nonce': WP_API_Settings.nonce
        }
      });

      $httpProvider.interceptors.push(function ($q, $location) {
        return {
          'responseError': function (response) {
            if (response.status === 401 || response.status === 403) {
              $location.path('/tab/login');
            }
            return $q.reject(response);
          }
        };
      });

      $stateProvider

        .state('tab', {
          url: "/tab",
          abstract: true,
          templateUrl: "templates/tabs.html",
          data: {
            access: access.public
          }
        })

        // Each tab has its own nav history stack:
        .state('tab.home', {
          url: '/home',
          views: {
            'tab-home': {
              templateUrl: 'templates/tab-home.html',
              controller: 'HomeCtrl'
            }
          }
        })

        .state('tab.products', {
          url: '/products',
          views: {
            'tab-products': {
              templateUrl: 'templates/tab-products.html',
              controller: 'ProductsCtrl'
            }
          }
        })

        .state('tab.products-show', {
          url: '/products/:id',
          views: {
            'tab-products': {
              templateUrl: 'templates/tab-products-show.html',
              controller: 'ProductsShowCtrl'
            }
          }
        })

        .state('tab.dash', {
          url: '/dash',
          views: {
            'tab-dash': {
              templateUrl: 'templates/tab-dash.html',
              controller: 'DashCtrl'
            }
          }
        })

        .state('tab.friends', {
          url: '/friends',
          views: {
            'tab-friends': {
              templateUrl: 'templates/tab-friends.html',
              controller: 'FriendsCtrl'
            }
          }
        })

        .state('tab.friend-detail', {
          url: '/friend/:friendId',
          views: {
            'tab-friends': {
              templateUrl: 'templates/friend-detail.html',
              controller: 'FriendDetailCtrl'
            }
          }
        })

        .state('tab.account', {
          url: '/account',
          views: {
            'tab-account': {
              templateUrl: 'templates/tab-account.html',
              controller: 'AccountCtrl'
            }
          },
          data: {
            access: access.user
          }
        })

        .state('tab.login', {
          url: '/login',
          views: {
            'tab-account': {
              templateUrl: 'templates/tab-account-login.html',
              controller: 'LoginCtrl'
            }
          }
        })

        .state('tab.register', {
          url: '/register',
          views: {
            'tab-account': {
              templateUrl: 'templates/tab-account-register.html',
              controller: 'RegisterCtrl'
            }
          }
        })

        .state('tab.change-password', {
          url: '/account/change_password',
          views: {
            'tab-account': {
              templateUrl: 'templates/tab-account-reset-password.html',
              controller: 'ResetPasswordCtrl'
            }
          }
        })

        .state('tab.photos', {
          url: '/photos',
          views: {
            'tab-photos': {
              templateUrl: 'templates/tab-photos.html',
              controller: 'PhotosCtrl'
            }
          }
        })

        .state('tab.photos-show', {
          url: '/photos/:id',
          views: {
            'tab-photos': {
              templateUrl: 'templates/tab-photos-show.html',
              controller: 'PhotosShowCtrl'
            }
          }
        })
        .state('tab.orders', {
          url: '/orders',
          views: {
            'tab-orders': {
              templateUrl: 'templates/tab-orders.html',
              controller: 'OrdersCtrl'

            }
          },
          data: {
            access: access.user
          }
        })

        .state('tab.orders-show', {
          url: '/orders/:id',
          views: {
            'tab-orders': {
              templateUrl: 'templates/tab-orders-show.html',
              controller: 'OrdersShowCtrl'
            }
          }
        })


      // if none of the above states are matched, use this as the fallback
      $urlRouterProvider.otherwise('/tab/products');

    })
    .run(['$rootScope', '$state', 'Auth', function ($rootScope, $state, Auth) {

      $rootScope.$on("$stateChangeStart", function (event, toState, toParams, fromState, fromParams) {
        if (!Auth.authorize(toState.data.access)) {
          $rootScope.error = "Seems like you tried accessing a route you don't have access to...";
          $state.go('tab.login');
          event.preventDefault();

//          if (fromState.url === '/tab/orders') {
//            if (Auth.isLoggedIn()) {
////                            $state.go('user.home');
//            } else {
//              $rootScope.error = null;
//              console.log('2');
////                            $state.go('anon.login');
//            }
//          }
        }
      });

    }])

    .directive('abc', function(){
      return {
        scope: {
          a: "@"
        },
        link: function(scope, element, attrs){
          console.log('-===', scope.a, '=====');
        }
      }
    })
  ;

