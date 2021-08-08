<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Slim Uygulamasıdır');
        return $response;
    });
    $app->group('/api', function (Group $group) {
        /**
         * GET METHODS
         */

        $group->get('/', function (Request $request, Response $response) {
            $response->getBody()->write('Slim Uygulaması API');
            return $response;
        });
        $group->get('/students',\App\Application\Actions\Student\StudentGetAllAction::class);
        $group->get('/non-deleted-students',\App\Application\Actions\Student\StudentGetAllAction::class);
        $group->get('/non-deleted-student-count',\App\Application\Actions\Student\StudentGetNonDeletedCountAction::class);
        $group->get("/non-deleted-students-with-paging",\App\Application\Actions\Student\StudentGetNonDeletedWithPagingAction::class);
        $group->get("/schools",\App\Application\Actions\School\SchoolGetAllAction::class);
        $group->get("/active-schools",\App\Application\Actions\School\SchoolGetActiveAction::class);
        $group->get("/student",\App\Application\Actions\Student\StudentGetAction::class);

        /**
         * POST METHODS
         */
        $group->post("/add-school",\App\Application\Actions\School\SchoolCreateAction::class);
        $group->post('/add-student',\App\Application\Actions\Student\StudentCreateAction::class);

        /**
         * DELETE METHODS
         */
        $group->delete("/delete-student",\App\Application\Actions\Student\StudentDeleteAction::class);
        /**
         * PUT METHODS
         */
        $group->put("/update-student",\App\Application\Actions\Student\StudentUpdateAction::class);

    });
};
