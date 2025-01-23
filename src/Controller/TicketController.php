<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//#[Route('/ticket')]
//#[IsGranted("ROLE_ADMIN")]
// security.yaml wird zuerst ausgeführt access control
final class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket_index')]
    public function index(TicketRepository $ticketRepository): Response
    {

//        Statische Objekte
//        $ticket1 = new Ticket();
//        $ticket1->setTitle('abcd');
//        $ticket1->setDescription('hallo beschreibung');
//        $ticket1->setCreatedAt(new \DateTimeImmutable('now'));
//
//        $ticket2 = new Ticket();
//        $ticket2->setTitle('efgh');
//        $ticket2->setDescription('hallo beschreibung');
//        $ticket2->setCreatedAt(new \DateTimeImmutable('now'));
//
//        $ticket3 = new Ticket();
//        $ticket3->setTitle('ijkl');
//        $ticket3->setDescription('hallo beschreibung');
//        $ticket3->setCreatedAt(new \DateTimeImmutable('now'));
//
//
//        $tickets = [$ticket1, $ticket2, $ticket3];
//        return $this->render('ticket/index.html.twig',[
//        'tickets' => $tickets]);

        // gibt alle Objekte aus der Datenbank wieder
        $tickets = $ticketRepository->findAll();

        return $this->render('ticket/index.html.twig',[
        'tickets' => $tickets]);
    }

    #[Route('/ticket/new', name: 'app_ticket_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $ticket->setTitle('mnop');
        $ticket->setDescription('hallo beschreibung');
        $ticket->setCreatedAt(new \DateTimeImmutable('now'));

        $entityManager->persist($ticket);
        $entityManager->flush();

        return $this->render('ticket/new.html.twig',[]);
    }

    #[Route('/ticket/delete/{id}', name: 'app_ticket_delete')]
    #[IsGranted('ROLE_DELETE')]
    public function delete(Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        // Alternative zu IsGranted Attribut -> Attribut besser
//        $this->denyAccessUnlessGranted('ROLE_DELETE');

        $entityManager->remove($ticket);
        $entityManager->flush();

        return $this->redirectToRoute('app_ticket_index');
    }

    #[Route('/ticket/update/{id}', name: 'app_ticket_update')]
    public function update(Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $ticket->setTitle('abcd');
        $ticket->setDescription('beschreibung');
        $ticket->setCreatedAt(new \DateTimeImmutable('now'));

        $entityManager->persist($ticket);
        $entityManager->flush();
        return $this->redirectToRoute('app_ticket_index');
    }

    #[Route('/wichtig', name: 'app_wichtig')]
    public function dahin() :Response {
        return $this->render('ticket/wichtig.html.twig');
    }

}
