<?php

namespace Beelab\UserPasswordBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
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
                    ->defaultValue('Beelab\UserPasswordBundle\Form\Type\ResetPasswordType')
                ->end()
                ->scalarNode('new_password_form_type')
                    ->cannotBeEmpty()
                    ->defaultValue('Beelab\UserPasswordBundle\Form\Type\NewPasswordType')
                ->end()
                ->arrayNode('email_parameters')
                    ->children()
                        ->scalarNode('template')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('subject')
                            ->isRequired()
                        ->end()
                        ->scalarNode('sender')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('bcc')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
