<?php

/*
 * This file is part of the Yosymfony\Spress.
 *
 * (c) YoSymfony <http://github.com/yosymfony>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Yosymfony\Spress\Tests;

use Symfony\Component\Finder\SplFileInfo;

use Yosymfony\Spress\Application;
use Yosymfony\Spress\ContentLocator\FileItem;
use Yosymfony\Spress\ContentManager\PageItem;

class PageItemTest extends \PHPUnit_Framework_TestCase
{
    protected $pagesDir;
    protected $configuration;
    
    public function setUp()
    {
        $this->pagesDir = realpath(__DIR__ .'/../fixtures/project/');
        
        $app = new Application();
        $this->configuration = $app['spress.config'];
    }

    public function testPageItemSubDirMarkdown()
    {
        $path = $this->pagesDir . '/projects/index.md';
        $fileInfo = new SplFileInfo($path, 'projects', 'projects/index.md');
        $fileItem = new FileItem($fileInfo, FileItem::TYPE_PAGE);
        $item = new PageItem($fileItem, $this->configuration);
        $item->setOutExtension('html');
        
        $this->assertEquals('projects-index-md', $item->getId());
        $this->assertEquals('/projects/', $item->getUrl());
        $this->assertTrue($item->hasFrontmatter());
        
        $payload = $item->getPayload();
        
        $this->assertArrayHasKey('id', $payload);
        $this->assertArrayHasKey('url', $payload);
        $this->assertArrayHasKey('path', $payload);
        $this->assertEquals($item->getId(), $payload['id']);
        $this->assertEquals($item->getUrl(), $payload['url']);
        $this->assertEquals('projects/index.html', $payload['path']);
    }
    
    public function testPageItemRootDir()
    {
        $path = $this->pagesDir . '/index.html';
        $fileInfo = new SplFileInfo($path, '', 'index.html');
        $fileItem = new FileItem($fileInfo, FileItem::TYPE_PAGE);
        $item = new PageItem($fileItem, $this->configuration);
        
        $this->assertEquals('index-html', $item->getId());
        $this->assertEquals('/', $item->getUrl());
        $this->assertTrue($item->hasFrontmatter());
        
        $payload = $item->getPayload();
        
        $this->assertArrayHasKey('id', $payload);
        $this->assertArrayHasKey('url', $payload);
        $this->assertArrayHasKey('path', $payload);
        $this->assertEquals($item->getId(), $payload['id']);
        $this->assertEquals($item->getUrl(), $payload['url']);
        $this->assertEquals('index.html', $payload['path']);
    }
}