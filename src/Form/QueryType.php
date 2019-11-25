<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @copyright 2015 Bert Hekman
 */
class QueryType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'demontpx_rigid_search.search',
            'translation_domain' => 'messages',
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getParent()
    {
        return SearchType::class;
    }
}
