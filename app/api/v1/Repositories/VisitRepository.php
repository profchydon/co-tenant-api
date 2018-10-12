<?php

namespace App\Api\v1\Repositories;

use App\Visit;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class VisitRepository
{

    public function create($request)
    {

        DB::beginTransaction();

        $payment_status = "not paid";

        $visit = Visit::create([
            'property_id' => $request->property_id,
            'cotenant_id' => $request->cotenant_id,
            'visit_date' => $request->visit_date,
            'payment_status' => $payment_status,
            'amount' => "1,000",
        ]);

        if (!$visit) {

          DB::rollback();

        }else {

          DB::commit();

          return $visit;

        }

    }

    public function visits ()
    {
        $visits = Visit::all();

        return $visits;
    }

    public function fetchAVisit ($request)
    {
        $visits = Visit::where('property_id' , $request->property_id && 'cotenant_id' , $request->cotenant_id)->first();

        return $visits;
    }

    public function updateVisit ($request)
    {

        DB::beginTransaction();

        $fetchVisit = $this->fetchAVisit($request->property_id , $request->cotenant_id);

        if ($fetchVisit) {

            $updateVisit = $fetchVisit->update(['visit_date' => $request->visit_date]);

            if (!$updateVisit) {

              DB::rollback();

            }else {

              DB::commit();

            }

        }

        return $updateVisit;

    }

}
