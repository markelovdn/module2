<?php
if (!session_id()) @session_start();
require_once '../vendor/autoload.php';

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use Faker\Factory;
use JasonGrimes\Paginator;
use League\Plates\Engine;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Engine::class => function() {
        return new Engine('../src/views');
    },
    PDO::class => function() {
        $driver = 'mysql';
        $host = "localhost";
        $dbname = "posts";
        $username = "root";
        $pass = "";

        return new PDO("$driver:host=$host; dbname=$dbname", $username, $pass);
    },

    Auth::class => function($container) {
    return new Auth($container->get('PDO'));
    },

    QueryFactory::class => function() {
        return new QueryFactory('mysql');
    }
]);

$container = $containerBuilder->build();


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    $r->addRoute('GET', '/', ['\src\HomeController', 'index']);
    $r->addRoute('GET', '/page/{page:\d+}', ['\src\HomeController', 'index']);
    $r->addRoute('GET', '/about', ['\src\HomeController', 'about']);
    $r->addRoute('GET', '/verify', ['\src\HomeController', 'emailVerify']);
    $r->addRoute('GET', '/login', ['\src\HomeController', 'login']);
    $r->addRoute('GET', '/logout', ['\src\HomeController', 'logout']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'Данный метод не доступен по этому маршруту';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($routeInfo[1], $routeInfo[2]);
        break;
}
?>








<?php
//$faker = Factory::create();
//$pdo = new PDO("mysql:host=localhost;dbname=posts", "root", "");
//$queryFactory = new QueryFactory('mysql');
//
////$insert = $queryFactory->newInsert();
////
////$insert->into('post');
////for ($i=0; $i<30; $i++) {
////    $insert->cols([
////        'title'=>$faker->words(3, true),
////        'content'=>$faker->text,
////    ]);
////    $insert->addRow();
////}
////
////$sth = $pdo->prepare($insert->getStatement());
////$sth->execute($insert->getBindValues());
//
////$result = $sth->fetch(PDO::FETCH_ASSOC);
//
//$select = $queryFactory->newSelect();
//$select
//    ->cols(['*'])
//    ->from('post');
//
//$sth = $pdo->prepare($select->getStatement());
//
//$sth->execute($select->getBindValues());
//$totalItems = $sth->fetchAll(PDO::FETCH_ASSOC);
//
//$select = $queryFactory->newSelect();
//$select = $queryFactory->newSelect();
//$select
//    ->cols(['*'])
//    ->from('post')
//    ->setPaging(10)
//    ->page($_GET['page'] ?? 1);
//
//$sth = $pdo->prepare($select->getStatement());
//
//$sth->execute($select->getBindValues());
//
//$items = $sth->fetchAll(PDO::FETCH_ASSOC);
//
//$itemsPerPage = 30;
//$currentPage = $_GET['page'] ?? 1;
//$urlPattern = '?page=(:num)';
//
//$pagination = new Paginator(count($totalItems), $itemsPerPage, $currentPage, $urlPattern);
//
//foreach($items as $item) {
//    echo $item['id'].PHP_EOL.$item['title'].'<br>';
//}
//?>


/**


<!--<ul class="pagination">-->
<!--    --><?php //if($pagination->getPrevUrl()):?>
<!--    <li><a href="--><?php //echo $pagination->getPrevUrl();?><!--">&laquo;Previos</a></li>-->
<!--    --><?php //endif;?>
<!---->
<!--    --><?php //foreach ($pagination->getPages() as $page): ?>
<!--    --><?php //if ($page['url']): ?>
<!--        <li --><?php //echo $page['isCurrent'] ? 'class="active"' : ''?><!-->-->
<!--            <a href="--><?//= $page['url']; ?><!--">--><?//= $page['num'];?><!--</a>-->
<!--        </li>-->
<!--    --><?php //else:?>
<!--    <li class="disable"><span>--><?//= $page['num'];?><!--</span></li>-->
<!--    --><?php //endif;?>
<!--    --><?php //endforeach;?>
<!---->
<!--    --><?php //if ($pagination->getNextUrl()):?>
<!--    <li><a href="--><?//= $pagination->getNextUrl()?><!--">Next &raquo;</a></li>-->
<!--    --><?php //endif;?>
<!--</ul>-->
<!---->
<!--<p>-->
<!--    --><?//= $pagination->getTotalItems();?><!-- found.-->
<!--    Showing-->
<!--    --><?//= $pagination->getCurrentPageFirstItem();?>
<!--    --><?//= $pagination->getCurrentPageLastItem();?>
<!--</p>-->

**/
