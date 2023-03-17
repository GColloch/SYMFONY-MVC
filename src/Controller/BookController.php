<?php

namespace App\Controller;

use App\Form\AddBook;
use App\Form\DeleteBook;
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
     * Route pour afficher un livre en détail. Par exemple, books/1, books/138, etc.
     */
    #[Route('/books/{id}', name: 'single_book', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function singleBook(int $id, EntityManagerInterface $em, Request $request): Response
    {
        // Récupération du livre à partir de son id
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Le livre n\'existe pas');
        }

        //Crée un formulaire pour supprimer le livre, l'associer à l'objet Book correspondant
        $form = $this->createForm(DeleteBook::class, $book, options: array(
            'action' => $this->generateUrl('single_book', ['id' => $id]),
            'method' => 'DELETE'
        ));

        //Inspecte la requête pour voir si le formulaire est soumis, si c'est le cas, change l'état du formulaire à 'soumis'
        $form->handleRequest($request);

        //Traiter le formulaire soumis s'il est valide
        if ($form->