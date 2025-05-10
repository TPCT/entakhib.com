<?php

namespace App\Http\Controllers;

use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\District\District;
use App\Settings\Site;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form_data = [
            'city_id' => \request('city_id'),
            'district_id' => \request('district_id'),
            'cluster_id' => \request('cluster_id')
        ];

        $cities = City::get();
        $districts = City::find($form_data['city_id'])?->districts;
        $clusters = District::find($form_data['district_id'])?->clusters;

        $candidates = Candidate::when(
            $form_data['city_id'],
            function ($q, $city_id) {
                $q->whereHas('cluster', function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                });
            }
        )->when(
            $form_data['district_id'],
            function ($q, $district_id) {
                $q->whereHas('cluster', function ($q) use ($district_id) {
                    $q->where('district_id', $district_id);
                });
            }
        )->when(
            $form_data['cluster_id'],
            function ($q, $cluster_id) {
                $q->where('cluster_id', $cluster_id);
            }
        )->whereCandidateType(Candidate::CLUSTER_CANDIDATE)
        ->paginate(app(Site::class)->candidates_page_size)
        ->withQueryString();
        return $this->view('Candidates.index', compact(
            'cities', 'candidates', 'form_data', 'districts', 'clusters')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Candidate $candidate)
    {
        return $this->view('Candidates.show', compact('candidate'));
    }
}
