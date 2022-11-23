<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class AdminUserController extends AbstractController
{

    #[Route('/', name: 'app_admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_SHIP')) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('app_login');
        }
        $this->denyAccessUnlessGranted('ROLE_SHIP', null, 'User tried to access a page without having ROLE_SHIP');

        return $this->render('admin_user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_SHIP')) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('app_login');
        }
        $this->denyAccessUnlessGranted('ROLE_SHIP', null, 'User tried to access a page without having ROLE_SHIP');

        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // transforms json column into str
            $roles = $form->get('roles')->getData();
            $user->setRoles($roles);

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if (!$this->isGranted('ROLE_SHIP')) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('login');
        }
        $this->denyAccessUnlessGranted('ROLE_SHIP', null, 'User tried to access a page without having ROLE_SHIP');

        return $this->render('admin_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_SHIP')) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('login');
        }
        $this->denyAccessUnlessGranted('ROLE_SHIP', null, 'User tried to access a page without having ROLE_SHIP');

        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // transforms json column into str
            $roles = $form->get('roles')->getData();
            $user->setRoles($roles);

            $userRepository->save($user, true);



            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_SHIP')) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('login');
        }
        $this->denyAccessUnlessGranted('ROLE_SHIP', null, 'User tried to access a page without having ROLE_SHIP');

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
