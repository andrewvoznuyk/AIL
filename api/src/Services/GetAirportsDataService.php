<?php

namespace App\Services;

use App\Entity\AircraftModel;
use App\Entity\Airport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAirportsDataService
{

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param HttpClientInterface $client
     * @param EntityManagerInterface $entityManager
     * @param DenormalizerInterface $denormalizer
     * @param ValidatorInterface $validator
     */
    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer, ValidatorInterface $validator)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
    }

    /**
     * @return void
     * @throws ExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function airportsApiParse(): void
    {
        $response = $this->client->request('GET', 'https://flight-radar1.p.rapidapi.com/airports/list', [
            'headers' => [
                'X-RapidAPI-Key'  => '47e2b070fdmsh932f2501fdcf894p14620fjsn62d151a62acc',
                'X-RapidAPI-Host' => 'flight-radar1.p.rapidapi.com'
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $requestData = json_decode($content, true);

        $airportData = $requestData['rows'];

        for ($i = 0; $i < count($airportData); $i++) {
            $airport = new Airport();

            if (!is_double($airportData[$i]['lon']) or !is_double($airportData[$i]['lat'])) {
                $airportData[$i]['lon'] = (double)$airportData[$i]['lon'];
                $airportData[$i]['lat'] = (double)$airportData[$i]['lat'];
            }

            $airport = $this->denormalizer->denormalize($airportData[$i], Airport::class, "array");
            $errors = $this->validator->validate($airportData[$i]);

            $this->entityManager->persist($airport);
            $this->entityManager->flush($airport);
        }
    }

    /**
     * @return void
     * @throws ClientExceptionInterface
     * @throws ExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function aircraftsApiParse(): void
    {
        $response = $this->client->request('GET', 'https://airplanesdb.p.rapidapi.com/', [
            'headers' => [
                'X-RapidAPI-Key'  => '47e2b070fdmsh932f2501fdcf894p14620fjsn62d151a62acc',
                'X-RapidAPI-Host' => 'airplanesdb.p.rapidapi.com'
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $requestData = json_decode($content, true);

        for ($i = 0; $i < count($requestData); $i++) {
            $aircraft = new AircraftModel();

            if ($requestData[$i]['cruise_speed_kmph'] === null) {
                $requestData[$i]['cruise_speed_kmph'] = 600;
            }

            if (is_float($requestData[$i]['cruise_speed_kmph'])) {
                $requestData[$i]['cruise_speed_kmph'] = intval($requestData[$i]['cruise_speed_kmph']);
            }

            if ($requestData[$i]['engine'] === null) {
                $requestData[$i]['engine'] = "Default engine";
            }

            if ($requestData[$i]['imgThumb'] === null) {
                $requestData[$i]['imgThumb'] = "https://media.cnn.com/api/v1/images/stellar/prod/221216150405-c919a.jpg?c=16x9&q=h_720,w_1280,c_fill";
            }

            $aircraft = $this->denormalizer->denormalize($requestData[$i], AircraftModel::class, "array");
            $errors = $this->validator->validate($requestData[$i]);

            $this->entityManager->persist($aircraft);
            $this->entityManager->flush($aircraft);
        }
    }

}