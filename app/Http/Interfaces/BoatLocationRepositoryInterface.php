<?php

namespace App\Http\Interfaces;

use App\Models\BrandModel;

interface BoatLocationRepositoryInterface
{
	public function getPackageByUserId();

	public function getDescription();

	public function getAllCountries();

	public function getByCountry($country);

	public function storeImages($images, $boatUuid);

	public function storeVideos($videos, $boatUuid);

	public function store(array $locationInfoData);
}
