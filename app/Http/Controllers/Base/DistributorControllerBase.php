<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;

use App\Models\Distributor;

trait DistributorControllerBase 
{
    public function indexDistributorBase($type, $pagination)
    {
        if($pagination == 'all')
           $distributors = Distributor::where('type', $type)->orderBy('name', 'asc')->get();
        else
           $distributors = Distributor::where('type', $type)->orderBy('name', 'asc')->paginate($pagination);

        return $distributors;
    }

    public function storeDistributorBase($type, Request $request)
    {
        $data = $request->input();
        $data['type'] = $type;

        $distributor = Distributor::create($data);

        return $distributor;
    }

    public function updateDistributorBase($distributor_id, Request $request)
    {
        $data = $request->input();

        $distributor = Distributor::find($distributor_id);
        $distributor->update($data);

        return $distributor;
    }

    public function deleteDistributorBase($distributor_id)
    {
        $distributor = Distributor::find($distributor_id);
        $distributor->delete();
    }
}
