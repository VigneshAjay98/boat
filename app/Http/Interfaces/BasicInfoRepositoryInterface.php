<?php

namespace App\Http\Interfaces;

use App\Models\BrandModel;

interface BasicInfoRepositoryInterface
{
	public function getByBoatUuid($boatUuid);

	public function store(array $basicInfoData);
	
}
