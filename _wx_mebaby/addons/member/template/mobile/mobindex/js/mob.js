/**
 * Created by duoduo on 2017/4/27.
 */
// 声明控制器及app
var app = angular.module('saga',['ng','ngRoute','ngAnimate','ngSanitize']);
// 声明父控制器
app.controller('parentCtrl',
    ['$scope','$location',
        function ($scope,$location) {       //定义公共跳转方法
            $scope.jump = function (arg) {
                $location.path(arg);
            };
            $scope.nav={
                    comNews :"com-news.png",
                    comHonor: "com-honor.png",
                    comAct : "com-act.png",
                    comShop : "com-shop.png",
                    comAbout : "com-about.png"
            }
        }

    ]
);
angular.module('saga') .filter('to_trusted', ['$sce', function($sce){ return function(text) { return $sce.trustAsHtml(text); }; }]);
//声明控制器
app.controller('mainCtrl',
    ['$scope','$location','$http',
        function ($scope,$location,$http) {
            $scope.nav={
                comNews :"com-news.png",
                comHonor: "com-honor.png",
                comAct : "com-act.png",
                comShop : "com-shop.png",
                comAbout : "com-about.png"
            };
            $scope.pageClass='pageMain';
            $http.get('http://www.sagabuy.com/api/getnewslist.php?classid=17')
                .success(function (data) {
                    console.log(data);
                    $scope.mainList = data;
                });
        }
    ]
);
app.controller('newsCtrl',
    ['$scope','$location','$http',
        function ($scope,$location,$http) {
            $scope.nav={
                comNews :"com-news.png",
                comHonor: "com-honor.png",
                comAct : "com-act.png",
                comShop : "com-shop.png",
                comAbout : "com-about.png"
            };
            $scope.pageClass='pagecom';
            $scope.nav.comNews = 'com-news-focus.png';
            $http.get('http://www.sagabuy.com/api/getnewslist.php?classid=11')
                .success(function (data) {
                    console.log(data);
                    $scope.newsList = data;
                });
        }
    ]
);
app.controller('honorCtrl',
    ['$scope','$location','$http',
        function ($scope,$location,$http) {
            $scope.nav={
                comNews :"com-news.png",
                comHonor: "com-honor.png",
                comAct : "com-act.png",
                comShop : "com-shop.png",
                comAbout : "com-about.png"
            };
            $scope.pageClass='pagecom';
            $scope.nav.comHonor = 'com-honor-focus.png';
            $http.get('http://www.sagabuy.com/api/getnewslist.php?classid=4')
                .success(function (data) {
                    console.log(data);
                    $scope.honorList = data;
                });
        }
    ]
);
app.controller('actCtrl',
    ['$scope','$location','$http',
        function ($scope,$location,$http) {
            $scope.nav={
                comNews :"com-news.png",
                comHonor: "com-honor.png",
                comAct : "com-act.png",
                comShop : "com-shop.png",
                comAbout : "com-about.png"
            };
            $scope.pageClass='pagecom';
            $scope.nav.comAct = 'com-act-focus.png';
            $http.get('http://www.sagabuy.com/api/getnewslist.php?classid=17')
                .success(function (data) {
                    console.log(data);
                    $scope.actList = data;
                });
        }
    ]
);
app.controller('shopCtrl',
    ['$scope','$location',
        function ($scope,$location) {
            $scope.nav={
                comNews :"com-news.png",
                comHonor: "com-honor.png",
                comAct : "com-act.png",
                comShop : "com-shop.png",
                comAbout : "com-about.png"
            };
            $scope.pageClass='pagecom';
            $scope.nav.comShop = 'com-shop-focus.png'
        }
    ]
);
app.controller('aboutCtrl',
    ['$scope','$location',
        function ($scope,$location) {
            $scope.nav={
                comNews :"com-news.png",
                comHonor: "com-honor.png",
                comAct : "com-act.png",
                comShop : "com-shop.png",
                comAbout : "com-about.png"
            };
            $scope.pageClass='pagecom';
            $scope.nav.comAbout = 'com-about-focus.png'
        }
    ]
);
app.controller('detailsCtrl',
    ['$scope','$routeParams','$http','$sanitize',
        function ($scope,$routeParams,$http,$sanitize) {
            $scope.nav={
                comNews :"com-news.png",
                comHonor: "com-honor.png",
                comAct : "com-act.png",
                comShop : "com-shop.png",
                comAbout : "com-about.png"
            };
            console.log($routeParams.id);

            $http.get('http://www.sagabuy.com/api/getnewscontent.php?contentid='+$routeParams.id)
                .success(function (data) {
                    console.log(data);
                    $scope.det = data[0];
            });

        }

    ]
);
//设置路由
app.config(function($routeProvider){
    $routeProvider
        .when('/main',{
            templateUrl:'../addons/member/template/mobile/mobindex/views/main.html',
            controller:'mainCtrl'
        })
        .when('/com-news',{
            templateUrl:'../addons/member/template/mobile/mobindex/views/com-news.html',
            controller:'newsCtrl'
        })
        .when('/com-honor',{
            templateUrl:'../addons/member/template/mobile/mobindex/views/com-honor.html',
            controller:'honorCtrl'
        })
        .when('/com-act',{
            templateUrl:'../addons/member/template/mobile/mobindex/views/com-activity.html',
            controller:'actCtrl'
        })
        .when('/com-shop',{
            templateUrl:'../addons/member/template/mobile/mobindex/views/com-shop.html',
            controller:'shopCtrl'
        })
        .when('/com-about',{
            templateUrl:'../addons/member/template/mobile/mobindex/views/com-about.html',
            controller:'aboutCtrl'
        })
        .when('/com-details/:id',{
            templateUrl:'../addons/member/template/mobile/mobindex/views/com-details.html',
            controller:'detailsCtrl'
        })
        .otherwise({redirectTo:'/main'});
});

