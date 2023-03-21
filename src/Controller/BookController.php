<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AddBook;
use App\Form\DeleteBook;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BookController extends AbstractController
{
    /**
     * Route qui liste les livres
     */
    #[Route('/books', name: 'list_books', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Book::class);

        $books = $repository->findAll();

        //Appel au template
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * Route pour ajouter un livre
     */
    #[Route('/books/add', name: 'add_book', methods: ['GET', 'POST'])]
    public function addBook(Request $request, EntityManagerInterface $em, AuthorRepository $authorRepository): Response
    {
        // Vérifie si l'utilisateur est authentifié
        $this->denyAccessUnlessGranted('ROLE_USER');

        //Créer un objet de type Book
        $book = new Book();

        //Crée un formulaire, l'associer à un objet
        $form = $this->createForm(AddBook::class, $book, [
            'action' => $this->generateUrl('add_book'),
            'method' => 'POST',
        ]);

        //Inspecte la requête pour voir si le formulaire est soumis, si c'est le cas, change l'état du formulaire à 'soumis'
        $form->handleRequest($request);

        //Traiter le formulaire soumis s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //Récupérer l'auteur sélectionné dans le formulaire
            $authorId = $request->request->get('add_book')['author'];

            //Récupérer l'objet Author correspondant à l'id
            $author = $authorRepository->find($authorId);

            //Associer l'auteur au livre
            $book->setAuthor($author);

            //Dire à Doctrine qu'il y a une entité qui a subi des modifications
            $em->persist($book);

            //Repercuter ces modifications en base
            $em->flush();

            return $this->redirectToRoute('list_books');
        }

        //Génére la réponse HTML avec un template Twig à qui je passe le formulaire à "rendre"
        return $this->render('book/add_book.html.twig', [
            'form' => $form->createView(),
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * Route pour afficher un livre en détail. Par exemple, books/1, books/138, etc.
     */
    #[Route('/books/{id}', name: 'single_book', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function singleBook(int $id, EntityManagerInterface $em): Response
    {
        // Vérifie si l'utilisateur est authentifié
        $this->denyAccessUnlessGranted('ROLE_USER');