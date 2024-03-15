<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;

use App\Models\Percentage;

trait PercentageControllerBase 
{
    public function indexPercentageBase($pagination)
    {
        if($pagination == 'all')
           $percentages = Percentage::orderBy('nominal', 'asc')->get();
        else
           $percentages = Percentage::orderBy('nominal', 'asc')->paginate($pagination);

        return $percentages;
    }

    public function storePercentageBase(Request $request)
    {
        $data = $request->input();

        $percentage = Percentage::create($data);

        return $percentage;
    }

    public function updatePercentageBase($percentage_id, Request $request)
    {
        $data = $request->input();

        $percentage = Percentage::find($percentage_id);
        $percentage->update($data);

        return $percentage;
    }

    public function deletePercentageBase($percentage_id)
    {
        $percentage = Percentage::find($percentage_id);
        $percentage->delete();
    }
}
