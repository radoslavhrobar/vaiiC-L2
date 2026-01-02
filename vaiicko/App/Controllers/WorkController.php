<?php

namespace App\Controllers;

use App\Models\Country;
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

    public function movieForm(Request $request): Response
    {
        $countries = Country::getAll();
        return $this->html(compact('countries'));
    }

    public function addMovie(Request $request): Response
    {
        return $this->html();
    }

    public function seriesForm(Request $request): Response
    {
        $countries = Country::getAll();
        return $this->html(compact('countries'));
    }

    public function addSeries(Request $request): Response
    {
        return $this->html();
    }

    public function bookForm(Request $request): Response
    {
        $countries = Country::getAll();
        return $this->html(compact('countries'));
    }

    public function addBook(Request $request): Response
    {
        return $this->html();
    }
}