<?php
// src/Form/EquipmentsType.php
namespace App\Form;

use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class EquipmentsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('description', TextType::class)
			->add('quantity', TextType::class)
			->add('price', TextType::class, [
			'attr'=> [
				'placeholder' => "en euro"
				]
			])
			->add('brand', TextType::class)
			#->add('users', )
			->add('save', SubmitType::class)
		;
	}
	 
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipement::class,
        ]);
    }
}