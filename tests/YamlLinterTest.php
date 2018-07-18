<?php

/*
 * This file is part of the Yaml Linter package.
 *
 * (c) Jules Pietri <jules@heahprod.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Heah\YamlLinter\Tests;

use Heah\YamlLinter\YamlLinter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\ApplicationTester;

class YamlLinterTest extends TestCase
{
    /** @var YamlLinter */
    private $linter;

    protected function setUp()
    {
        $app = new YamlLinter();
        $app->setAutoExit(false);

        $this->linter = new ApplicationTester($app);
    }

    protected function tearDown()
    {
        $this->linter = null;
    }

    public function testDefaultCommand()
    {
        $this->assertSame(0, $this->linter->run(['--help']));
        $this->assertContains('The lint:yaml command lints a YAML file and outputs to STDOUT', $this->linter->getDisplay());
    }

    public function testArgumentIsRequired()
    {
        $this->assertSame(1, $this->linter->run([]));
        $this->assertContains('Please provide a filename or pipe file content to STDIN.', $this->linter->getDisplay());
    }

    public function testArgumentMustBeValidStream()
    {
        $this->assertSame(1, $this->linter->run(['filename' => 'toto']));
        $this->assertContains('File or directory "toto" is not readable.', $this->linter->getDisplay());
    }

    public function testLintValidFile()
    {
        $this->assertSame(0, $this->linter->run(['filename' => __DIR__.'/fixtures/valid.yaml']));
        $this->assertContains('[OK] All 1 YAML files contain valid syntax.', $this->linter->getDisplay());
    }

    public function testLintInvalidFile()
    {
        $this->assertSame(1, $this->linter->run(['filename' => __DIR__.'/fixtures/invalid.yaml']));
        $this->assertContains('[WARNING] 0 YAML files have valid syntax and 1 contain errors.', $this->linter->getDisplay());
    }
}
