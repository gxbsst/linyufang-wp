angular.module('starter.services', ['ngResource'])

/**
 * A simple example service that returns some data.
 */
    .factory('Friends', function () {
        // Might use a resource here that returns a JSON array

        // Some fake testing data
        var friends = [
            { id: 0, name: 'Scruff McGruff' },
            { id: 1, name: 'G.I. Joe' },
            { id: 2, name: 'Miss Frizzle' },
            { id: 3, name: 'Ash Ketchum' }
        ];

        return {
            all: function () {
                return friends;
            },
            get: function (friendId) {
                // Simple index lookup
                return friends[friendId];
            }
        }
    })
    .service('Posts', function ($resource, Actions) {
        return $resource('/?json_route=/posts/:id', {id: '@id'}, Actions);
    })
    .service('Media', function ($resource, Actions) {
        return $resource('/?json_route=/media/:id', {id: '@id'}, Actions);
    })
    .service('User', function ($resource, Actions) {
        return $resource('/?json_route=/users/:id', {id: '@id'}, Actions);
    })
    .factory('Auth', function($http, $cookieStore){

        var accessLevels = routingConfig.accessLevels
            , userRoles = routingConfig.userRoles
            , currentUser = $cookieStore.get('user') || { username: '', role: userRoles.public };

        $cookieStore.remove('user');

        function changeUser(user) {
            angular.extend(currentUser, user);
        }

        return {
            authorize: function(accessLevel, role) {
                if(role === undefined) {
                    role = currentUser.role;
                }

                return accessLevel.bitMask & role.bitMask;
            },
            isLoggedIn: function(user) {
                if(user === undefined) {
                    user = currentUser;
                }
                return user.role.title === userRoles.user.title || user.role.title === userRoles.admin.title;
            },
            register: function(user, success, error) {
                $http.post('/site/wp-admin/admin-ajax.php?action=ajaxregistration', user).success(function(res) {
                    changeUser(res);
                    success();
                }).error(error);
            },
            login: function(user, success, error) {
                $http.post('/site/wp-admin/admin-ajax.php?action=ajaxlogin', user).success(function(user){
                    changeUser(user);
                    success(user);
                }).error(error);
            },
            logout: function(success, error) {
                $http.post('/logout').success(function(){
                    changeUser({
                        username: '',
                        role: userRoles.public
                    });
                    success();
                }).error(error);
            },
            accessLevels: accessLevels,
            userRoles: userRoles,
            user: currentUser
        };
    })
;
