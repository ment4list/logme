<?php

namespace Mentalist\Logme;


class WriteTest extends \PHPUnit\Framework\TestCase // \PHPUnit_Framework_Exception
{
    /**
     * Test that directory exception gets thrown
     * @expectedException Mentalist\Logme\Exceptions\FileDoesNotExistException
     */
    public function testDirDoesNotExistException()
    {
        $Log = new Logme('/bogus/directory/');
    }

    /**
     * Test that file exception gets thrown
     * @expectedException Mentalist\Logme\Exceptions\FileDoesNotExistException
     * @expectedException Mentalist\Logme\Exceptions\FileNotWritableException
     */
    public function testFileNotWritableException()
    {
        $Log = new Logme('/bogus/directory/', 'bogusfile.log');
    }

    /**
     * Test that file gets created
     */
    public function testFileIsCreated()
    {
        $dir = '/var/tmp/';
        $Log = new Logme($dir);

        $Log->write("Test");

        $this->assertFileExists($dir . 'logme.log');

    }

    /**
     * Test that file gets written
     */
    public function testFileIsWritten()
    {
        $dir = '/var/tmp/';

        $content = file_get_contents($dir . 'logme.log');
        $this->assertContains('Test', $content);
        $this->assertContains('[info]', $content);

    }

    /**
     * Test that file gets written
     */
    public function testLogLevels()
    {
        $dir = '/var/tmp/';
        $Log = new Logme($dir);

        $levels = [
            'info', 'debug', 'warn', 'error'
        ];

        $now = date( 'Y-m-d H:i:s' );
        foreach ($levels as $level) {
            $extras = [
                'date' => $now,
                'level' => $level,
            ];
            $Log->{$level}("Logging level {$level}...", $extras);
        }

        $content = file_get_contents($dir . 'logme.log');
        foreach ($levels as $level) {
            $this->assertContains("Logging level {$level}", $content);
            $this->assertContains("[{$level}]", $content);
        }

    }
}
