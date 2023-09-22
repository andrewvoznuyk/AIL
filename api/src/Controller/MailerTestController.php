<?php

namespace App\Controller;

use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MailerTestController extends AbstractController
{
    /**
     * @var MailerService
     */
    private MailerService $mailerService;

    /**
     * @param MailerService $mailerService
     */
    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    /**
     * @return JsonResponse
     */
    #[Route('/send-mail', name: 'send_mail')]
    public function getOwnerCompany(): JsonResponse
    {
        $this->mailerService->SendMailFunc();
        return new JsonResponse("Data sended via mailtrap!");
    }

}