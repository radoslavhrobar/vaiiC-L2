<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class WorkController extends BaseController
{

    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function rankings(Request $request): Response
    {
        return $this->html();
    }

    public function adding(Request $request): Response
    {
        return $this->html();
    }
}