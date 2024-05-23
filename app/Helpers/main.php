<?php
    use App\Admin;
    use App\Cashier;
    use App\Models\Account;
    use App\Models\Brand;
    use App\Models\Category;
    use App\Models\Cokim;
    use App\Models\Color;
    use App\Models\Distributor;
    use App\Models\GoldPrice;
    use App\Models\Good;
    use App\Models\GoodChecking;
    use App\Models\GoodLoading;
    use App\Models\GoodUnit;
    use App\Models\Percentage;
    use App\Models\Member;
    use App\Models\Unit;

    use Illuminate\Support\Facades\DB;

    function alert()
    {
        $type  = null;
        $color = null;
        $data  = null;

        if(session('alert'))
        {
            $alert = session('alert');
            $data  = session('data');

            switch ($alert) {
                case 'add':
                    $type = 'tambah';
                    $color = 'success';
                    break;

                case 'edit':
                    $type = 'ubah';
                    $color = 'warning';
                    break;

                case 'delete':
                    $type = 'hapus';
                    $color = 'danger';
                    break;

                case 'error':
                    $type = 'error';
                    $color = 'danger';
                    break;

                case 'errorEdit':
                    $type = 'errorEdit';
                    $color = 'danger';
                    break;
            }
            session()->forget('alert');
            session()->forget('data');
        }

        return [$type, $color, $data];
    }

    function resizeImage($folder, $pathInput)
    {
        $resize = Image::make($pathInput)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                  })->encode('jpg');
        $hash = md5($resize->__toString());
        $path = $folder . "/{$hash}.jpg";
        Storage::put($path, $resize->__toString());

        return $path;
    }

    function changeInput($text)
    {
        // First, replace UTF-8 characters.
        $text = str_replace(
        array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
        array("'", "'", '"', '"', '-', '--', '...'),
        $text);

        // Next, either REPLACE their Windows-1252 equivalents.
        $text = str_replace(
        array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
        array("'", "'", '"', '"', '-', '--', '...'),
        $text);

        // OR, STRIP their Windows-1252 equivalents.
        $text = str_replace(
        array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
        array('', '', '', '', '', '', ''),
        $text);

        return $text;
    }

    function getActor($model, $model_id)
    {
        $model = "App\\" . $model;
        $data  = $model::find($model_id);

        return $data;
    }

    function getPaginations()
    {
        $paginations = ['all' => 'all', '5' => '5', '10' => '10', '15' => '15', '20' => '20', '200' => '200'];

        return $paginations;
    }

    function convertDate($date)
    {
        if($date == null) return null;
        return date('Y-m-d', strtotime($date));
    }

    function convertDateExcel($date)
    {
        if($date == null) return null;
        return date('Y-m-d', strtotime(date('d/m/Y', $date)));
    }

    function displayDate($date)
    {
        return date('d F Y', strtotime($date));
    }

    function displayDateTime($date)
    {
        return date('d F Y H:i:s', strtotime($date));
    }

    function formatNumber($number)
    {
        return number_format(checkNull($number),0,'',',');
    }

    function unformatNumber($number)
    {
        return str_replace(",", "", $number);
    }

    function showRupiah($money)
    {
        is_numeric($money) ? : $money = unformatNumber($money);
        return 'Rp' . number_format(checkNull($money),0,'.',',');
    }

    function showShortName($string)
    {
        // if(strlen($string) > 20){
        //     $textLength = strlen($string);
        //     $maxChars = 10;

        //     $string = substr_replace($string, '...', $maxChars/2, $textLength-$maxChars);
        // }

        // if(strlen($string) > 30)
        //     $string = substr($string, 0, 30);

        $string = substr($string, 0, 15);

        return $string;
    }

    function roundMoney($money)
    {
        if(is_numeric($money))
        return round($money / 100) * 100;
        else 0;
    }

    function displayGramComa($gram)
    {
        $gram = str_replace(',', '', $gram);
        $result = explode('.', $gram);

        if(!isset($result[1]))
        {
            $barcode = '000';
        }
        elseif($result[1] != '000')
        {
            $id = $result[1];
            $barcode = $result[1];
            while($id < 100)
            {
                $barcode .= '0';
                $id = $id * 10; 
            }

            if(strlen($barcode) > 3)
            {
                $barcode = substr($barcode, 0, 3);
            }
        }
        else
        { 
            $barcode = $result[1];
        }

        return $result[0] . '.' . $barcode;
    }

    function printRupiah($money)
    {
        return number_format(checkNull($money),0,'.',',');
    }

    function checkNull($item)
    {
        return $item == NULL || $item == 'NULL' || $item == "" ? 0 : $item;
    }

    function checkNullString($item)
    {
        return $item == NULL || $item == 'NULL' || $item == "" ? "" : $item;
    }

    function convertGoodBarcode($code)
    {
        $category = substr($code, 1, 2);
        $id = substr($code, 3, -1);

        return [intval($category), $id];
    }

    function calculateProfit($buy_price, $sell_price)
    {
        if($buy_price != null && $buy_price != 0)
            return round((floatval($sell_price) - floatval($buy_price)) / $buy_price * 100, 2);
        else return 0;
    }

    function changeGramToKg($weight)
    {
        $kg = $weight/1000;
        $gram = $weight%1000;
        $result = $kg > 0 ? $kg . ' kg ' : '';
        $result .= $gram > 0 ? $gram . ' gram' : '';

        return $result;
    }

    function getAccounts()
    {
        return Account::orderBy('code', 'asc')->get();
    }

    function getBrands()
    {
        $brands = [null => 'Pilih merek'];
        foreach (Brand::orderBy('name', 'asc')->get() as $data) {
            $brands = array_add($brands, $data->id, $data->name);
        }
        return $brands;
    }

    function getCategoryObjects()
    {
        return Category::orderBy('name', 'asc')->get();
    }

    function getCategories()
    {
        $categories = [null => 'Pilih kategori', 'all' => 'Seluruh kategori'];
        foreach (Category::orderBy('name', 'asc')->get() as $data) {
            $categories = array_add($categories, $data->id, $data->name . ' (' . $data->eng_name . ')');
        }
        return $categories;
    }

    function getCategoriesWoAll()
    {
        $categories = [];
        foreach (Category::orderBy('name', 'asc')->get() as $data) {
            $categories = array_add($categories, $data->id, $data->name);
        }
        return $categories;
    }

    function getCokimWeight()
    {
        $cokims = Cokim::where('status', 'sell')->get();
        $sold_cokims = Cokim::where('status', '!=', 'sell')->get();

        return $cokims->sum('weight') - $sold_cokims->sum('weight');
    }

    function getGram($category, $status)
    {
        if($category == 'all')
        {
            $golds = Good::where('goods.status', $status)
                         ->get();  
        }
        else
        {
            $golds = Good::join('categories', 'categories.id', 'goods.category_id')
                         ->where('categories.code', $category)
                         ->where('goods.status', $status)
                         ->get();  
        }

        return $golds;
    }

    function getTotalItems($category, $status)
    {
        if($category == 'all')
        {
            $golds = Good::where('goods.status', $status)
                         ->count();  
        }
        else
        {
            $golds = Good::join('categories', 'categories.id', 'goods.category_id')
                         ->where('categories.code', $category)
                         ->where('goods.status', $status)
                         ->count();  
        }

        return $golds;
    }

    function getColors()
    {
        $colors = [null => 'Pilih warna'];
        foreach (Color::orderBy('name', 'asc')->get() as $data) {
            $colors = array_add($colors, $data->id, $data->name . ' (' . $data->code . ')');
        }
        return $colors;
    }

    function getColorAsObjects()
    {
        return Color::orderBy('name', 'asc')->get();
    }

    function getDistributors()
    {
        $distributors = Distributor::orderBy('name', 'asc')->get();

        return $distributors;
    }

    function getDistributorLists()
    {
        $distributors = [null => 'Pilih distributor', 'all' => 'Seluruh distributor'];
        foreach (Distributor::orderBy('name', 'asc')->get() as $data) {
            $distributors = array_add($distributors, $data->id, $data->name);
        }
        return $distributors;
    }

    function getDistributorLoading($distributor_id, $start_date = null, $end_date = null)
    {
        $search = ['all' => 'Semua'];
        if($start_date != null)
        {
            foreach (DB::select("SELECT DISTINCT good_loadings.distributor_id as distributor_id, distributors.name FROM good_loadings join distributors on good_loadings.distributor_id = distributors.id WHERE good_loadings.created_at >= '" . $start_date . "' AND good_loadings.created_at <= '" . $end_date . "' ORDER BY distributors.name") as $data) {
                $search = array_add($search, $data->distributor_id, $data->name);
            }
        }
        return $search;
    }

    function getDistributorLocations()
    {
        $locations = ['all' => 'Semua'];
        foreach (DB::select("SELECT DISTINCT distributors.location FROM distributors ORDER BY distributors.location ASC") as $data) {
            $locations = array_add($locations, $data->location, $data->location);
        }

        return $locations;
    }

    function getGoldHistoryNumber()
    {
        $types = ['0' => 'Kulak pertama', '1' => 'Buyback pertama'];

        for($i = 2; $i < 11; $i++)
        {
            $entry = [$i => 'Buyback ke-' . $i];
            $types = array_merge($types, $entry);
            // array_push($types, $entry);
        }

        return $types;
    }

    function getGoldTypes()
    {
        $types = [0 => 'Emas Muda', 1 => 'Emas Tua', '2' => 'Emas Pertengahan'];

        return $types;
    }

    function getGoods()
    {
        $goods = Good::all();

        return $goods;
    }

    function getGoodLoadingTypes()
    {
        $types = ['all' => 'Seluruh Status', 'buy' => 'Dengan Surat', 'buy-other' => 'Tanpa Surat'];

        return $types;
    }

    function getGoodUnits()
    {
        $good_units = GoodUnit::join('goods', 'goods.id', 'good_units.good_id')
                              ->select('good_units.*', 'goods.*', 'good_units.id as good_unit_id', 'goods.name as good_name', 'goods.code as good_code')
                              ->where('goods.status', 'Siap dijual')
                              ->where('goods.deleted_at', null)
                              ->orderBy('goods.name', 'asc')->get();
                              
        return $good_units;
    }

    function getMembers()
    {
        $members = Member::all();

        return $members;
    }

    function getOtherPayment()
    {
        $payments = [null => 'Pilih biaya'];
        foreach (Account::where('name', 'like', 'Biaya %')->orderBy('name', 'asc')->get() as $data) {
            $payments = array_add($payments, $data->id, $data->name . ' (' . $data->code . ')');
        }
        return $payments;
    }

    function getPercentages()
    {
        $percentages = [];
        foreach (Percentage::orderBy('name', 'asc')->get() as $data) {
            $percentages = array_add($percentages, $data->id, $data->name);
        }
        return $percentages;
    }

    function getPercentageObjects()
    {
        return Percentage::orderBy('name', 'asc')->get();
    }

    function getRoles()
    {
        $roles = ['admin' => 'admin', 'cashier' => 'cashier', 'member' => 'member'];

        return $roles;
    }

    function getSearchLoading($type, $start_date = null, $end_date = null)
    {
        $search = ['all' => 'Semua'];
        if($start_date != null)
        {
            foreach (DB::select("SELECT DISTINCT " . $type . " as name FROM good_loadings WHERE loading_date >= '" . $start_date . "' AND loading_date <= '" . $end_date . "' ORDER BY " . $type) as $data) {
                $search = array_add($search, $data->name, $data->name);
            }
        }
        else
        {
            foreach (DB::select("SELECT DISTINCT " . $type . " as name FROM good_loadings ORDER BY " . $type) as $data) {
                $search = array_add($search, $data->name, $data->name);
            }
        }
        return $search;
    }

    function getStatus()
    {
        $statuses = ['Siap dijual' => 'Siap dijual', 'Butuh Permak' => 'Butuh permak'];

        return $statuses;
    }

    function getStatusOther()
    {
        $statuses = ['all' => 'Seluruh Status', 'Siap dijual' => 'Siap dijual', 'Service' => 'Service', 'Cuci' => 'Cuci', 'Tidak layak jual' => 'Tidak layak jual'];

        return $statuses;
    }

    function getStatusOtherWoAll()
    {
        $statuses = ['Siap dijual' => 'Siap dijual', 'Service' => 'Service', 'Cuci' => 'Cuci', 'Tidak layak jual' => 'Tidak layak jual'];

        return $statuses;
    }

    function getTodayGoldPrice()
    {
        $gold_price = GoldPrice::orderBy('created_at', 'desc')->first();

        return $gold_price;
    }

    function getUnits()
    {
        $units = [null => 'Pilih satuan'];
        foreach (Unit::orderBy('name', 'asc')->get() as $data) {
            $units = array_add($units, $data->id, $data->name . ' (' . $data->code . ')');
        }
        return $units;
    }

    function getUnitAsObjects()
    {
        return Unit::orderBy('name', 'asc')->get();
    }

    function getUsers()
    {
        $users = ['all/all' => 'Semua user'];
        foreach (Admin::where('is_active', 1)->orderBy('name', 'asc')->get() as $data) {
            $users = array_add($users, 'admin/' . $data->id, $data->name . ' (admin)');
        }
        foreach (Cashier::where('is_active', 1)->orderBy('name', 'asc')->get() as $data) {
            $users = array_add($users, 'cashier/' . $data->id, $data->name . ' (kasir)');
        }

        return $users;
    }
