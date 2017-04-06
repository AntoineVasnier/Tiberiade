<?php

namespace Tiberiade\MainBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Tiberiade\MainBundle\Entity\Article;

class actualiteType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('titre', TextareaType::class, array(
                    'constraints' => array(new NotBlank(), new Length(array(
                            'min' => 5,
                            'max' => 2000,
                            'minMessage' => "Le titre de l'actualité doit comporter au minimum {{ limit }} caractères",
                            'maxMessage' => "Le titre de l'actualité doit comporter au maximum {{ limit }} caractères",
                                ))),
                    'label' => 'Titre de l\'actualité : '
                ))
                ->add('dateDebut', DateType::class, array(
                    'constraints' => array(new NotBlank()),
                    'widget' => "single_text",
                    'html5' => false,
                    'format' => 'dd/MM/yyyy',
                    'attr' => ['class' => 'js-datepicker'],
                    'label' => 'Date de début : ',
                ))
                ->add('dateFin', DateType::class, array(
                    'widget' => "single_text",
                    'html5' => false,
                    'attr' => ['class' => 'js-datepicker'],
                    'label' => 'Date de fin : ',
                    'required' => false
                ))
                ->add('file', FileType::class, array(
                    'label' => "Image de l'actualité : ",
                    'attr' => array(
                        'accept' => "image/*",
                    ),
                    'constraints' => array(
                        new Image(array(
                            'maxWidth' => 500,
                            'maxHeight' => 500,
                            'maxWidthMessage' => "L'image est trop large",
                            'maxHeightMessage' => "L'image est trop haute"
                        ))
                    )
                ))
                ->add('valider', 'submit');
        
        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event){
            $data = $event->getData();
            /** @var Article $data */
            if (!isset($data->getDateFin))
            {
               $data->setDateFin($data->getDateDebut()); 
            }                 
        });
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            "data_class" => "Tiberiade\MainBundle\Entity\Actualite"
        ));
    }
    
    public function getBlockPrefix() {
        return "actualite_type";
    }
           
}
