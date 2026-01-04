<?php

namespace App\Controllers;

use App\Controllers\WorkController;
use App\Models\Country;
use App\Models\Genre;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class SeriesDetailController extends WorkController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }
    public function form(Request $request): Response
    {
        $countries = Country::getAll();
        $genres = Genre::getAll(whereClause: '(`type` = ? OR `type` = ?)', whereParams: ['Cinema', 'Both']);
        return $this->html(compact('countries', 'genres'));
    }

    public function add(Request $request): Response
    {
        return $this->html();
    }
}