<?php

namespace App\Http\Interfaces;

interface DetailsRepositoryInterface
{
	public function getModel();

	public function storeEngine(array $engines, $boatUuid);

	public function storeOtherInformation(array $otherInformationData, $boatUuid);
}
