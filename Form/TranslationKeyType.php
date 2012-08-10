<?php

namespace Propel\TranslationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * TransUnit form type.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class TranslationKeyType extends AbstractType
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('key_name');
        $builder->add('domain', 'choice', array(
            'choices' => array_combine($options['domains'], $options['domains']),
        ));
        $builder->add('translation_contents', 'collection', array(
            'type' => new TranslationContentType(),
            'required' => false,
            'options' => array(
                'data_class' => $options['translation_content_class']
            )
        ));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getDefaultOptions()
     */
    public function getDefaultOptions(array $options = array())
    {
        $defaults = array(
            'domains' => array('messages'),
            'translation_content_class' => null,
            'data_class' => null
        );

        return array_merge($defaults, $options);
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'translation_key';
    }
}
