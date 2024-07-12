<?php


namespace App\Traits;


class CurlRequest
{

    public function __construct()
    {
        $this->ip = '103.121.120.133';
        $this->codTicketApiUrl = "http://android.leopardscourier.com/CODTicketAPI/api/Shipper/";
        $this->username = 'cod_api_shipper';
        $this->password = 'P@k!$t@n4601$$+-#';
    }

    public function getShipperAdvice($method, $request = [], $bulkAction = 0)
    {
        $base_url = "{$this->codTicketApiUrl}{$method}";

        if ($method == 'GetShipperAdvice') {
            $base_url = "{$this->codTicketApiUrl}{$method}";
        } elseif ($method == 'ActivityLog') {
            $base_url = "{$this->codTicketApiUrl}GetShipperAdvice";
        }

        $CODTicket_API_CREDS = base64_encode('cod_api_shipper:P@k!$t@n4601$$+-#');
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . $CODTicket_API_CREDS
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (count($request) > 0) {
            if ($method == 'UpdateShipperAdvice') {
                if ($bulkAction == 1) {
                    foreach ($request as $key => $value) {
                        $requested_data[$key]['id'] = (int)$value['id'];
                        //$requested_data[$key]['clientID'] = $CompanyId;
                        $requested_data[$key]['cn_number'] = $value['cn_number'];
                        $requested_data[$key]['shipper_advice_status'] = $value['admin_remarks'];
                        $requested_data[$key]['shipper_remarks'] = $value['advice_text'];
                    }
                } else {
                    $requested_data[0]['id'] = $request['id'];
                    //$requested_data[0]['clientID'] = $CompanyId;
                    $requested_data[0]['cn_number'] = $request['cn_number'];
                    $requested_data[0]['shipper_advice_status'] = $request['admin_remarks'];
                    $requested_data[0]['shipper_remarks'] = $request['advice_text'];
                }
            } elseif ($method == 'GetShipperAdvice') {

                $requested_data['product'] = ($request['product'] != '') ? $request['product'] : 'COD';
                $requested_data['status'] = ($request['status'] != '') ? $request['status'] : 'ALL';

//                $requested_data['userID'] = 2747; // For testing
                // if($CompanyId > 0 ) {
                //     $requested_data['userID'] = (int) $CompanyId;
                // }
                $requested_data['userID'] = (int)$request['company_id'];
                $requested_data['origionID'] = "";
                if (isset($request['origin_city_id']) && intval($request['origin_city_id']) > 0) {
                    $requested_data['origionID'] = str_pad($request['origin_city_id'], 5, "0", STR_PAD_LEFT);
                }
                $requested_data['destinationID'] = "";
                if (isset($request['destination_city_id']) && intval($request['destination_city_id']) > 0) {
                    $requested_data['destinationID'] = str_pad($request['destination_city_id'], 5, "0", STR_PAD_LEFT);
                }
                $requested_data['dateFrom'] = (isset($request['fromDate']) && $request['fromDate'] != '') ? date('Y-m-d', strtotime($request['fromDate'])) : "";
                $requested_data['toDate'] = (isset($request['toDate']) && $request['toDate'] != '') ? date('Y-m-d', strtotime($request['toDate'])) : "";
                $requested_data['Cn_number'] = (isset($request['Cn_number']) && $request['Cn_number'] != '') ? $request['Cn_number'] : "";
                $requested_data['start'] = (int)$request['offset'];
                $requested_data['length'] = (int)$request['limit'];
            } else if ($method == 'ActivityLog') {
                $requested_data['product'] = "COD";
                $requested_data['status'] = "ALL";
                if ($this->session->userdata('admin_type') == 2) {
                    //$requested_data['userID'] = 2747; // For testing
                    $requested_data['userID'] = (int)$request['company_id'];
                }
                $requested_data['Cn_number'] = (isset($request['cn_number']) && $request['cn_number'] != '') ? $request['cn_number'] : "";
                //$requested_data['Cn_number'] = (isset($request['cn_number']) && $request['cn_number'] != '') ? $request['cn_number'] : "";
                $requested_data['start'] = 0;
                $requested_data['length'] = 100;
            } else {
                $requested_data = $request;
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requested_data));
        }

        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        return [
            'http_code' => $http_code,
            'response' => $response
        ];
    }
}
