<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Hermawan\DataTables\DataTable;
use App\Models\ecom_booked_packet_model;
use App\Models\ecom_city;
use App\Models\ecom_status;
use App\Models\ecom_admin_user;
use Illuminate\Support\Facades\Route;
class SettingsController extends Controller
{
    protected $ecom_admin_user;

    public function __construct()
    {
        // $this->ecom_admin_user =  ecom_admin_user::query();
    }

    public function index(Request $request)
    {
        if (Route::is('merchant.settings.api_managment.index')) {
            return view('Merchant/setting/api_management');
        }else  if (Route::is('api.merchant.settings.api_managment.get')  && $request->has('id') && $request->has('ajax') ) {
            $id = $request->id;
            $data = $this->ecom_admin_user->find($id);
            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }else  if (Route::is('api.merchant.settings.api_managment.update')) {
            $data = [
                'api_key' => $request->api_key,
                'api_password' => $request->api_password,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $admin_user_id = $request->user()->id;
            $this->ecom_admin_user->where('id',$admin_user_id)->update($data);
            return response()->json(['status' => 1, 'data' => [], 'message' => 'success'], 200);
        }else{
            return response()->json(['status' => 0,  'message' => 'Invalid Request'], 401);
        }
    }

    public function apiBookedPacket()
    {
        if ($this->request->isAJAX()) {

            $book_packet_model = new ecom_booked_packet_model();

            $queryBuilder = $book_packet_model->select("ecom_status.title,booked_packet_cn,orig.city_name as origin_city,dest.city_name as destination_city,shipper_name,consignee_name,booked_packet_date,booked_packet_collect_amount")
            ->join('ecom_shipper','ecom_bookings.shipper_id=ecom_shipper.id')
            ->join('ecom_consignee','ecom_bookings.consignee_id=ecom_consignee.id')
            ->join('ecom_status','ecom_bookings.booked_packet_status=ecom_status.status_id')
            ->join('ecom_city orig','origin_city=orig.id')
            ->join('ecom_city dest','destination_city=dest.id');

            if(!empty($this->request->getVar('origin'))){
                $queryBuilder = $queryBuilder->where('origin_city',$this->request->getVar('origin'));
            }

            if(!empty($this->request->getVar('destination'))){
                $queryBuilder = $queryBuilder->where('destination_city',$this->request->getVar('destination'));
            }

            if(!empty($this->request->getVar('status'))){
                $queryBuilder = $queryBuilder->where('booked_packet_status',$this->request->getVar('status'));
            }

            $data = DataTable::of($queryBuilder);
            return $data =  $data->toJson(true);
        }

        $cities = new ecom_city();
        $this->data['cities'] = $cities->get()->getResult();

        $statuses = new ecom_status();
        $this->data['statuses'] = $statuses->get()->getResult();

        return view('Merchant/Setting/api_booked_packets',$this->data);
    }

    public function apiShipper()
    {
        return view('Merchant/setting/api_shipper');
    }

    public function apiConsignee()
    {
        return view('Merchant/setting/api_consignee');
    }

    public function plugins()
    {
        return view('Merchant/setting/plugins');
    }

    public function tutorials()
    {
        return view('Admin/settings/tutorials');
    }
}
