<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * @return string
     */
    public function index() : string {
        return "index";
    }

    /**
     * @param CompanyCreateRequest $request
     * @return string
     */
    public function create(CompanyCreateRequest $request) : string {
        $request->validated();
        return "Create";
    }

    /**
     * @param CompanyUpdateRequest $request
     * @return string
     */
    public function update(CompanyUpdateRequest $request) : string {
        $request->validated();
        return "Update";
    }

    /**
     * @return string
     */
    public function delete() : string {
        return "Delete";
    }
}
