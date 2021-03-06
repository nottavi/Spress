<?php

/*
 * This file is part of the Yosymfony\Spress.
 *
 * (c) YoSymfony <http://github.com/yosymfony>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Yosymfony\Spress\Plugin\Event;

use Symfony\Component\EventDispatcher\Event;
use Yosymfony\Spress\Configuration;
use Yosymfony\Spress\ContentManager\ConverterInterface;
use Yosymfony\Spress\ContentManager\ConverterManager;
use Yosymfony\Spress\ContentManager\Renderizer;
use Yosymfony\Spress\ContentLocator\ContentLocator;
use Yosymfony\Spress\Plugin\Api\TemplateManager;

class EnviromentEvent extends Event
{
    private $configuration;
    private $converter;
    private $renderizer;
    private $contentLocator;
    
    public function __construct(
        Configuration $configuration, 
        ConverterManager $converter, 
        Renderizer $renderizer, 
        ContentLocator $contentLocator)
    {
        $this->configuration = $configuration;
        $this->converter = $converter;
        $this->renderizer = $renderizer;
        $this->contentLocator = $contentLocator;
    }
    
    /**
     * Get repository configuration
     * 
     * @return Yosymfony\Silex\ConfigServiceProvider\ConfigRepository
     */
    public function getConfigRepository()
    {
        return $this->configuration->getRepository();
    }
    
    /**
     * Get the template TemplateManager
     * 
     * @return Yosymfony\Spress\Plugin\Api\TemplateManager
     */
    public function getTemplateManager()
    {
        return new TemplateManager($this->renderizer);
    }
    
    /**
     * Add new converter
     * 
     * @param ConverterInterface $converter
     */
    public function addConverter(ConverterInterface $converter)
    {
        $this->converter->addConverter($converter);
    }
    
    /**
     * Add a new Twig function
     * 
     * @param string $name Name of function
     * @param callable $function Function implementation
     * @param array $options
     */
    public function addTwigFunction($name, callable $function, array $options = [])
    {
        $this->renderizer->addTwigFunction($name, $function, $options);
    }
    
    /**
     * Add a new Twig filter
     * 
     * @param string $name Name of filter
     * @param callable $filter Filter implementation
     * @param array $options
     */
    public function addTwigFilter($name, callable $filter, array $options = [])
    {
        $this->renderizer->addTwigFilter($name, $filter, $options);
    }
    
    /**
     * Add a new Twig test
     * 
     * @param string $name Name of test
     * @param callable $test Test implementation
     * @param array $options
     */
    public function addTwigTest($name, callable $test, array $options = [])
    {
        $this->renderizer->addTwigTest($name, $test, $options);
    }
    
    public function getSourceDir()
    {
        return $this->contentLocator->getSourceDir();
    }
    
    public function getPostsDir()
    {
        return $this->contentLocator->getPostsDir();
    }
    
    public function getDestinationDir()
    {
        return $this->contentLocator->getDestinationDir();
    }
    
    
    /**
     * Get the absolute paths of includes directory
     * 
     * @return string
     */
    public function getIncludesDir()
    {
        return $this->contentLocator->getIncludesDir();
    }
    
    /**
     * Get the absolute paths of layouts directory
     * 
     * @return string
     */
    public function getLayoutsDir()
    {
        return $this->contentLocator->getLayoutsDir();
    }
}