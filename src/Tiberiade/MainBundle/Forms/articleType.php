<?php

namespace Tiberiade\MainBundle\Forms;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Tiberiade\MainBundle\Entity\Article;

class articleType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('titre', TextType::class, array(
                    'constraints' => array(new NotBlank(), new Length(array(
                            'min' => 5,
                            'max' => 50,
                            'minMessage' => 'Le titre de l\'article doit comporter au minimum {{ limit }} caractères',
                            'maxMessage' => 'Le titre de l\'article doit comporter au maximum {{ limit }} caractères',
                                ))),
                    'label' => 'Titre de l\'article : '
                ))
                ->add('description', TextareaType::class, array(
                    'constraints' => array(new NotBlank(), new Length(array(
                            'min' => 20,
                            'max' => 2000,
                            'minMessage' => 'La description de l\'article doit comporter au minimum {{ limit }} caractères',
                            'maxMessage' => 'La description de l\'article doit comporter au maximum {{ limit }} caractères',
                                ))),
                    'label' => 'Description de l\'article : '
                ))
                ->add('resume', TextType::class, array(
                    'constraints' => array(new NotBlank(), new Length(array(
                            'min' => 5,
                            'max' => 50,
                            'minMessage' => 'Le résumé de l\'article doit comporter au minimum {{ limit }} caractères',
                            'maxMessage' => 'Le résumé de l\'article doit comporter au maximum {{ limit }} caractères',
                                ))),
                    'label' => 'Résumé de l\'article : '
                ))
                ->add('file', FileType::class, array(
                    'label' => "Image de l'article : ",
                    'attr' => array(
                        'accept' => "image/*",
                    ),
                    'constraints' => array(
                        new Image(array(
                            'maxWidth' => 500,
                            'maxHeight' => 500,
                            'maxSizeMessage' => "L'image est trop lourde",
                            'maxWidthMessage' => "L'image est trop large",
                            'maxHeightMessage' => "L'image est trop haute"
                        ))
                    )
                ))
                ->add('valider', 'submit');
        
        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event){
            $data = $event->getData();
            /** @var Article $data */
            $data->setDatePublication(new DateTime());
        });
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            "data_class" => "Tiberiade\MainBundle\Entity\Article"
        ));
    }
    
    public function getBlockPrefix() {
        return "article_type";
    }
           
}
