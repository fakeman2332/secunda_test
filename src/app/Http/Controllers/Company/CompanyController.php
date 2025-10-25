<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCompanyByNameRequest;
use App\Models\Activity;
use App\Models\Company;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function getCompanyById(Company $company)
    {
        return response()->data(true, [
            'company' => $company->load([
                'building',
                'phones',
                'activities',
            ])
        ]);
    }

    public function getCompanyByName(GetCompanyByNameRequest $request)
    {
        $company = Company::where('name', $request->name)
            ->first();

        if (!$company) {
            return response()->data(false, [
                'message' => 'Организация с указанным названием не найдена'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->data(true, [
            'company' => $company->load([
                'building',
                'phones',
                'activities'
            ])
        ]);
    }


    public function getCompaniesByActivity(Activity $activity)
    {
        $companies = $activity->companies()
            ->with([
                'building',
                'phones',
                'activities'
            ])
            ->get();

        return response()->data(true, [
            'count' => $companies->count(),
            'companies' => $companies,
        ]);
    }

    public function getCompaniesByActivityFilter(Activity $activity)
    {
        $activityIds = $activity->descendantsAndSelf()
            ->where('depth', '<=', 2)
            ->pluck('id');

        $companies = Company::whereHas('activities', function ($query) use ($activityIds) {
            $query->whereIn('activities.id', $activityIds);
        })->with([
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
