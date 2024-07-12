<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_city extends Model {

    protected $table = 'ecom_city';
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s"
    ];


    public function getAllCitiesWithShipmentTypes(){
        $cities = $this->get()->getResult();
        foreach ($cities as $city) {
            $city->shipmentTypes = $this->getShipmentTypesForCity($city->id);
        }

        return $cities;
    }

    private function getShipmentTypesForCity($cityId)
    {
        $builder = $this->db->table('ecom_cities_shipment_types');
        $builder->select('ecom_shipment_types.name')
                ->join('ecom_shipment_types', 'ecom_shipment_types.id = ecom_cities_shipment_types.shipment_type_id')
                ->where('ecom_cities_shipment_types.city_id', $cityId);

        $query = $builder->get();
        $result = $query->getResult();

        $shipmentTypes = [];
        foreach ($result as $row) {
            $shipmentTypes[] = $row->name;
        }

        return $shipmentTypes;
    }

    public static function GetCities()
    {
        $model = new static();

        return $model->where('is_active', 1)
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->findAll();
    }

    static function getCityById($cityId, $isAdmin = false)
    {
        $builder = self::where('id', $cityId)
            ->where('is_deleted', '0');

        if (!$isAdmin) {
            $builder->where('is_active', '1');
        }
        $query = $builder->get();
        if ($query->count() > 0) {
            return $query->first();
        }
        return null;
    }

    public function country()
    {
        return $this->belongsTo(ecom_country::class);
    }

    public function admin_user()
    {
        return $this->belongsToMany(ecom_admin_user::class, 'ecom_admin_user_city_rights', 'city_id', 'admin_user_id');
    }
}
