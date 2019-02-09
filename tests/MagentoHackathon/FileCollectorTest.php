<?php


namespace MagentoHackathon\Service;

use MagentoHackathon\FileCollector;
use MagentoHackathon\Model\FileList;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use Symfony\Component\Finder\Finder;


class FileCollectorTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;
    /**
     * @var FileCollector
     */
    private $fileCollector;

    public function testGetRelevantFilesSuccessfully()
    {
        $file1 = vfsStream::newFile('test.json');
        $file1->at($this->root);
        $file2 = vfsStream::newFile('test.xml');
        $file2->at($this->root);
        $file3 = vfsStream::newFile('test1.php');
        $file3->at($this->root);
        $file4 = vfsStream::newFile('test2.php');
        $file4->at($this->root);
        $file5 = vfsStream::newFile('composer.json');
        $file5->at($this->root);
        $file6 = vfsStream::newFile('test.phtml');
        $file6->at($this->root);

        $result = $this->fileCollector->getRelevantFiles($this->root->url());
        $this->assertCount(2, $result->getPhpFileList());
        $this->assertCount(1, $result->getTemplates());
    }

    /**
     * 
     */
    protected function setUp()
    {
        $this->root = vfsStream::setup();
        $finder = new Finder();
        $fileList = new FileList();
        $this->fileCollector = new FileCollector($finder, $fileList);
    }
}