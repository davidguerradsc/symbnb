<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnoncesType extends AbstractType
{

	/**
	 * Permet d'avoir la configuration de base d'un champ de formulaire
	 *
	 * @param string $label
	 * @param string $placeholder
	 * @param array $options
	 * @return array
	 */
	private function getConfiguration($label, $placeholder, $options = [])
	{
		return array_merge([
			'label' => $label,
			'attr' => [
				'placeholder' => $placeholder
			]
			], $options);
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'title', 
				TextType::class, 
				$this->getConfiguration("Titre", "Tapez un super titre pour votre annonce"))
			->add(
				'slug', 
				TextType::class, 
				$this->getConfiguration("Adresse WEB", "Tapez l'adresse web (automatique)", [
					'required' => false
				]))
			->add(
				'coverImage', 
				UrlType::class, 
				$this->getConfiguration("URL de l'image principale", "Donnez l'adresse d'une image qui donne vraiment envie"))
			->add(
				'introduction', 
				TextType::class, 
				$this->getConfiguration("Introduction", "Donnez une description globale de l'annonce"))
			->add(
				'content', 
				TextareaType::class, 
				$this->getConfiguration("Desciption détaillé", "Tapez une description qui donne vraiment envie de venir chez vous"))
			->add(
				'rooms', 
				IntegerType::class, 
				$this->getConfiguration("Nombre de chambres", "Le nombre de chambre disponible"))
			->add(
				'price', 
				MoneyType::class, 
				$this->getConfiguration("Prix par nuit", "Indiquez le prix pour une nuit"))
			->add(
				'images',
				CollectionType::class,
				[
					'entry_type' => ImageType::class,
					'allow_add' => true,
					'allow_delete' => true
				]
			)
			;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Ad::class,
		]);
	}
}
