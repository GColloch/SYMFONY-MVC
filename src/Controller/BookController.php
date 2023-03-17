<?php

namespace App\Controller;

use App\Form\AddBook;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    /**
     * Route qui liste les livres
     */
    #[Route('/books', name: 'list_books', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository('App\Entity\Book');

        $books = $repository->findAll();

        //Appel au template
        return $this->render('book/index.html.twig', array(
            'books' => $books
        ));
    }

    /**
     * Route pour ajouter un livre
     */
    #[Route('/books/add', name: 'add_book', methods: ['GET', 'POST'])]
    public function addBook(Request $request, EntityManagerInterface $em): Response
    {
        //Créer un objet de type Book
        $book = new Book();

        //Crée un formulaire, l'associer à un objet
        $form = $this->createForm(AddBook::class, $book, options: array(
            'action' => $this->generateUrl('add_book'),
            'method' => 'POST'
        ));

        //Inspecte la requête pour voir si le formulaire est soumis, si c'est le cas, change l'état du formulaire à 'soumis'
        $form->handleRequest($request);

        //Traiter le formulaire soumis s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Traitement du formulaire
            //Dire à Doctrine qu'il y a une entité qui a subi des modifications
            $em->persist($book);
            //Repercuter ces modifications en base
            $em->flush();
        }

        //Génére la réponse HTML avec un template Twig à qui je passe le formulaire à "rendre"
        return $this->render('book/add_book.html.twig', array(
            'form' => $form
        ));
    }

    /**
     * Route pour ajouter un livre. Par exemple, books/1, books/138, etc.
     */
    #[Route('/books/{id}', name: 'single_book', methods: ['GET', 'DELETE', 'PUT'], requirements: ['id' => '\d+'])]
    public function singleBook(): Response
    {
        return $this->render('book/single.html.twig');
    }
}
