<?php

namespace LumenLogViewer\Test;

use Exception;
use LumenLogViewer\LumenLogViewer;
use LumenLogViewer\Providers\LumenLogViewerServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Class LumenLogViewerTest
 *
 * @package LaravelLogViewer\Test
 */
class LumenLogViewerTest extends OrchestraTestCase {

    private $logViewer;

    /** @noinspection PhpLanguageLevelInspection */
    function setUp(): void {
        parent::setUp();
        // Copy "lumen.log" file to the orchestra package.
        if (!file_exists(storage_path('logs/lumen.log'))) {
            copy(__DIR__ . '/lumen.log', storage_path('logs/lumen.log'));
        }
        $this->logViewer = LumenLogViewer::getInstance();
    }

    /**
     * @throws Exception
     */
    function testSetFile() {
        parent::setUp();
        try {
            $this->logViewer->setFile(storage_path('logs/lumen.log'));
            $this->logViewer->setFile('lumen.log');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->assertEquals('lumen.log', $this->logViewer->getFileName());
    }

    function testSetFileNotExist() {
        try {
            $this->logViewer->setFile('not-exist/lumen.log');
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
        $this->assertFalse(false);
    }

    function testAll() {
        $data = $this->logViewer->all();
        $this->assertEquals('local', $data[0]['context']);
        $this->assertEquals('error', $data[0]['level']);
        $this->assertEquals('danger', $data[0]['level_class']);
        $this->assertEquals('exclamation-triangle', $data[0]['level_img']);
        $this->assertEquals('2018-09-05 20:20:51', $data[0]['date']);
    }

    function testAllWithFileNotExist() {
        try {
            $this->logViewer->setFile('not-exist/lumen.log');
        } catch (Exception $e) {
        }
        $data = $this->logViewer->all();
        $this->assertEquals('local', $data[0]['context']);
        $this->assertEquals('error', $data[0]['level']);
        $this->assertEquals('danger', $data[0]['level_class']);
        $this->assertEquals('exclamation-triangle', $data[0]['level_img']);
        $this->assertEquals('2018-09-05 20:20:51', $data[0]['date']);
    }

    function testGetFolders() {
        $dir_a = storage_path('logs/a');
        $dir_b = storage_path('logs/b');
        $dir_c = storage_path('logs/c');
        if (!is_dir($dir_a) || !is_dir($dir_b) || !is_dir($dir_c)) {
            mkdir(storage_path('logs/a'));
            mkdir(storage_path('logs/b'));
            mkdir(storage_path('logs/c'));
        }
        $this->assertNotEmpty($this->logViewer->getFolders());
    }

    function testGetFolderFiles() {
        $log_viewer = LumenLogViewer::getInstance();
        $data = $log_viewer->getFolderFiles(true);
        $this->assertNotEmpty($data[0], 'Folder files is null');
    }

    function testSetFolder() {
        $this->logViewer->setFolder(storage_path('logs'));
        $this->assertTrue($this->logViewer->getFolderName() === storage_path('logs'));
    }

    function testSetFolderNotExist() {
        $this->logViewer->setFolder('a');
        $this->assertDirectoryExists(storage_path('logs/a'));
    }

    function testController() {
        // TODO:
        $this->assertTrue(true);
    }

    function testProvider() {
        $provider = new LumenLogViewerServiceProvider(app());
        $provider->boot();
        $provider->register();

        $this->assertTrue(true);
    }
}
