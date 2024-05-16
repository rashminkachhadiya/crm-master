<?php

namespace App\Services;

use App\Models\CompaniesModel;
use App\Models\DealsModel;

class CompaniesService
{
    private CompaniesModel $companiesModel;

    public function __construct()
    {
        $this->companiesModel = new CompaniesModel();
    }

    public function execute(array $requestedData, int $adminId)
    {
        return $this->companiesModel->storeCompany($requestedData, $adminId);
    }

    public function update(int $companiesId, array $requestedData)
    {
        return $this->companiesModel->updateCompany($companiesId, $requestedData);
    }

    public function loadCompanies($createForm = false)
    {
        return $this->companiesModel->getAll($createForm);
    }

    public function loadPagination()
    {
        return $this->companiesModel->getPaginate();
    }

    public function pluckData()
    {
        return $this->companiesModel->pluckData();
    }

    public function loadCompany(int $companyId)
    {
        return $this->companiesModel->getCompany($companyId);
    }

    public function loadSetActive(int $companiesId, bool $value)
    {
        return $this->companiesModel->setActive($companiesId, $value);
    }

    public function loadCompaniesByCreatedAt()
    {
        return $this->companiesModel->getCompaniesSortedByCreatedAt();
    }

    public function loadCountCompanies()
    {
        return $this->companiesModel->countCompanies();
    }

    public function loadDeactivatedCompanies()
    {
        return $this->companiesModel->getDeactivated();
    }

    public function loadCompaniesInLatestMonth()
    {
        return $this->companiesModel->getCompaniesInLatestMonth();
    }
}
