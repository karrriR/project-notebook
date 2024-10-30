<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'API Documentation for Notebook',
    version: '1.0.0',
    contact: new OA\Contact(
        email: 'regina@example.com',
        name: 'Карьгина Регина',
    )
)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
