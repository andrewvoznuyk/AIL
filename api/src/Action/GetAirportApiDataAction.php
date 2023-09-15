<?php

namespace App\Action;

use App\Entity\Airport;
use App\Entity\Company;
use App\Entity\User;
use App\Services\GetAirportsDataService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetAirportApiDataAction
{
    /**
     * @var GetAirportsDataService
     */
    private GetAirportsDataService $getAirportsData;


    /**
     * @param GetAirportsDataService $getAirportsData
     */
    public function __construct(GetAirportsDataService $getAirportsData)
    {
        $this->getAirportsData = $getAirportsData;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws ExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function __invoke(Airport $data ) : Airport
    {
        $this->getAirportsData->airportsApiParse();

        return $data;
    }
}