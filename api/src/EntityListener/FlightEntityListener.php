<?php

namespace App\EntityListener;

use App\Entity\Company;
use App\Entity\Flight;
use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FlightEntityListener
{

    /**
     * @param Flight $flight
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(Flight $flight, LifecycleEventArgs $eventArgs): void
    {
        //TODO: add real flight duration
        $arrivalDate = date_add(
            $flight->getDeparture(),
            date_interval_create_from_date_string('1 day')
        );

        $flight->setArrival($arrivalDate);
    }

}