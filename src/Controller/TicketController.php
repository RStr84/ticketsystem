<?php

namespace App\Controller;

use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket')]
    public function index(): Response
    {

        $ticket1 = new Ticket();
        $ticket1->setTitle('abcd');
        $ticket1->setDescription('hallo beschreibung');
        $ticket1->setCreatedAt(new \DateTimeImmutable('now'));

        $ticket2 = new Ticket();
        $ticket2->setTitle('abcd');
        $ticket2->setDescription('hallo beschreibung');
        $ticket2->setCreatedAt(new \DateTimeImmutable('now'));

        $ticket3 = new Ticket();
        $ticket3->setTitle('abcd');
        $ticket3->setDescription('hallo beschreibung');
        $ticket3->setCreatedAt(new \DateTimeImmutable('now'));


        $tickets = [$ticket1, $ticket2, $ticket3];
        return $this->render('ticket/index.html.twig',[
        'tickets' => $tickets]);
    }

    #[Route('/ticket/new', name: 'app_ticket_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $ticket->setTitle('abcd');
        $ticket->setDescription('hallo beschreibung');
        $ticket->setCreatedAt(new \DateTimeImmutable('now'));

        $entityManager->persist($ticket);
        $entityManager->flush();

        return $this->render('ticket/new.html.twig',[]);
    }
}
