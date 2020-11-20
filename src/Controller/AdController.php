<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnoncesType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPSTORM_META\type;

class AdController extends AbstractController
{
	/**
	 * @Route("/ads", name="ads_index")
	 */
	public function index(AdRepository $repo): Response
	{

		$ads = $repo->findAll();

		return $this->render('ad/index.html.twig', [
			'ads' => $ads
		]);
	}


	/**
	 * Permet de créer une annonce
	 * 
	 * @Route("/ads/new", name="ads_create")
	 * @return Response
	 */
	public function create(Request $request, EntityManagerInterface $manager)
	{
		$ad = new Ad();

		$form = $this->createForm(AnnoncesType::class, $ad);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			foreach ($ad->getImages() as $image ) {
				$image->setAd($ad);
				$manager->persist($image);
			}

			$manager->persist($ad);
			$manager->flush();

			$this->addFlash(
				'success',
				"L'annonce <strong>{$ad->getTitle()}</strong> à bien été sauvegardée !"
			);

			return $this->redirectToRoute('ads_show', [
				'slug' => $ad->getSlug()
			]);
		}

		return $this->render('ad/new.html.twig', [
			'form' => $form->createView(),
		]);
	}


	/**
	 * Permet de éditer une annonce existante
	 *
	 * @Route("/ads/{slug}/edit", name="ads_edit")
	 * @return Response
	 */
	public function edit(Ad $ad, Request $request, EntityManagerInterface $manager){

		$form = $this->createForm(AnnoncesType::class, $ad);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			foreach ($ad->getImages() as $image) {
				$image->setAd($ad);
				$manager->persist($image);
			}

			$manager->persist($ad);
			$manager->flush();

			$this->addFlash(
				'success',
				"Les modofications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été sauvegardée !"
			);

			return $this->redirectToRoute('ads_show', [
				'slug' => $ad->getSlug()
			]);
		}

		return $this->render('ad/edit.html.twig', [
			'form' => $form->createView(),
			'ad' => $ad
		]);
	}


	/**
	 * Permet d'afficher une seule annonce
	 * 
	 * @Route("/ads/{slug}", name="ads_show")
	 * @return Response
	 */
	public function show(Ad $ad)
	{
		return $this->render('ad/show.html.twig', [
			'ad' => $ad
		]);
	}
}
