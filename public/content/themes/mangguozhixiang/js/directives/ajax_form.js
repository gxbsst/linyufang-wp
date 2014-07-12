angular.module('starter.services')
  .directive('ajaxForm', function () {
    return {
      link: function (scope, element, attrs) {
        attrs.focused != 'false' && jQuery(':input:first', element).focus();
        var callback = scope[attrs.callback] || scope.callback || function () {
        };
        element.on('submit', function () {
          if (element.is('.disabled') || scope._FormStatus == 'submitting' || element.data('ajaxValid')) {
            return false;
          }
          var _this = this,
            self = scope[attrs.name],
            action = attrs.action || attrs.ngAction,
            method = attrs.method || 'post',
            reload = attrs.reload,
            el = jQuery(element),
            data = el.serialize(),
            success = function (res) {
              scope._FormStatus = 'submitted';
              jQuery('button[type="submit"],.button[type="submit"]', element).removeClass('disabled').removeAttr('disabled', true);
//                            attrs.notify != 'false' && jQuery.notify($.LANG(202));
              reload && jQuery.each(reload.split(','), function (i, name) {
                name = jQuery.trim(name || '');
                var scope = APP[name],
                  params = [];
                if (attrs.params) {
                  try {
                    params = eval('([' + attrs.params + '])');
                  } catch (e) {
                  }
                }
                scope && scope.reload && scope.reload.apply(this, params);
              });
              callback.call(_this, res, data);
              var dialog = el.closest('.dialog');
              if (dialog[0]) {
                jQuery('.dialog-close', dialog).click();
              }
            };
          if (self.$valid) {
            var validation = scope[attrs.validation] || scope['validation'];
            if (validation && !validation.call(scope, self)) {
              return false;
            }
            scope._FormStatus = 'submitting';
            jQuery('button[type="submit"],.button[type="submit"]', element).addClass('disabled').attr('disabled', true);
            jQuery.ajax({
              url: action,
              type: method,
              data: data,
              dataType: 'json',
              success: success,
              error: function (res) {
              }
            });
          } else {
          }
          return false;
        });
      }
    }
  })

  .directive("passwordVerify", function () {
    return {
      require: "ngModel",
      scope: {
        passwordVerify: '='
      },
      link: function (scope, element, attrs, ctrl) {
        scope.$watch(function () {
          var combined;

          if (scope.passwordVerify || ctrl.$viewValue) {
            combined = scope.passwordVerify + '_' + ctrl.$viewValue;
          }
          return combined;
        }, function (value) {
          if (value) {
            ctrl.$parsers.unshift(function (viewValue) {
              var origin = scope.passwordVerify;
              if (origin !== viewValue) {
                ctrl.$setValidity("passwordVerify", false);
                return undefined;
              } else {
                ctrl.$setValidity("passwordVerify", true);
                return viewValue;
              }
            });
          }
        });
      }
    };
  });
;
