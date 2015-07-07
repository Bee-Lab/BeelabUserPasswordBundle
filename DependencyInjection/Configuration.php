<?php

namespace Beelab\UserPasswordBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('beelab_user_password');

        $rootNode
            ->children()
                ->scalarNode('password_min_length')
                    ->defaultValue(8)
                ->end()
                ->scalarNode('password_reset_class')
                    ->isRequired()
                ->end()
                ->scalarNode('password_reset_form_type')
                    ->cannotBeEmpty()
                    ->defaultValue('Beelab\UserPasswordBundle\Form\Type\PasswordResetType')
                ->end()
                ->scalarNode('new_password_form_type')
                    ->cannotBeEmpty()
                    ->defaultValue('Beelab\UserPasswordBundle\Form\Type\NewPasswordType')
                ->end()
                ->arrayNode('email_parameters')
                    ->scalarNode('template')
                        ->isRequired()
                    ->end()
                    ->scalarNode('subject')
                        ->isRequired()
                    ->end()
                    ->scalarNode('sender')
                        ->isRequired()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
