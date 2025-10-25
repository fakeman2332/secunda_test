<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCompaniesInBoundsRequest;
use App\Http\Requests\GetCompaniesInRadiusRequest;
use App\Models\Building;
use App\Models\Company;

class CompanyGeoController extends Controller
{
    public function getCompaniesInBuilding(Building $building)
    {
        $companies = $building->companies()->with([
            'building',
            'phones',
            'activities'
        ])->get();

        return response()->data(true, [
            'count' => $companies->count(),
            'companies' => $companies
        ]);
    }

    public function getCompanyInRadius(GetCompaniesInRadiusRequest $request)
    {
        $companies = Company::withinRadius(
            $request->validated('latitude'),
            $request->validated('longitude'),
            $request->validated('radius')
        )->with([
            'building',
            'phones',
            'activities'
        ])->get();

        return response()->data(true, [
            'count' => $companies->count(),
            'companies' => $companies
        ]);
    }

    public function getCompanyInBounds(GetCompaniesInBoundsRequest $request)
    {
        $validated = $request->validated();

        $companies = Company::withinBoundingBox(
            $validated['top_left']['lat'],      // north
            $validated['bottom_right']['lat'],   // south
            $validated['top_left']['lon'],       // west
            $validated['bottom_right']['lon']    // east
        )->with([
            'building',
            'phones',
            'activities'
        ])->get();

        return response()->data(true, [
            'count' => $companies->count(),
            'companies' => $companies
        ]);
    }
}
