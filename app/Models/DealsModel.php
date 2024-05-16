<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals';
    protected $dates = ['deleted_at'];

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function storeDeal(array $requestedData, int $adminId) : bool
    {
        return $this->insert(
            [
                'name' => $requestedData['name'],
                'start_time' => $requestedData['start_time'],
                'end_time' => $requestedData['end_time'],
                'companies_id' => $requestedData['companies_id'],
                'created_at' => now(),
                'is_active' => true,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateDeal(int $dealId, array $requestedData) : int
    {
        return $this->where('id', '=', $dealId)->update(
            [
                'name' => $requestedData['name'],
                'start_time' => $requestedData['start_time'],
                'end_time' => $requestedData['end_time'],
                'companies_id' => $requestedData['companies_id'],
                'updated_at' => now()
            ]
        );
    }

    public function setActive(int $dealId, bool $activeType) : int
    {
        return $this->where('id', '=', $dealId)->update(
            [
                'is_active' => $activeType,
                'updated_at' => now()
            ]
        );
    }

    public function countDeals() : int
    {
        return $this->get()->count();
    }

    public static function getDealsInLatestMonth() {
        $dealsCount = self::where('created_at', '>=', now()->subMonth())->count();
        $allDeals = self::all()->count();

        return ($allDeals / 100) * $dealsCount;
    }

    public function getDeactivated() : int
    {
        return $this->where('is_active', '=', 0)->count();
    }

    public function getPluckCompanies()
    {
        return $this->pluck('name', 'id');
    }

    public function getPaginate()
    {
        return $this->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }

    public function getDeal(int $dealId) : self
    {
        return $this->find($dealId);
    }

    public function getName(int $dealId)
    {
        return $this->where('id', $dealId)->get()->last()->name;
    }

    public function getAssignedDealsForCompanies(int $companiesId)
    {
        return $this->where('companies_id', $companiesId)->get()->count();
    }

    public function getAll()
    {
        return $this->all()->sortBy('created_at');
    }
}
