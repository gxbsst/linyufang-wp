APP.filter('status', function(){
    return function(string) {
      var allStatus = {cancel:'取消', completed:  '完成', nopay: '未支付'};
      return allStatus[string];
    }
  })