<?php


namespace App\Form\Type;


use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Name can not be blank'
                    ]),
                ]
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Description can not be blank'
                    ]),
                ]
            ])
            ->add('localization', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Localization can not be blank'
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}