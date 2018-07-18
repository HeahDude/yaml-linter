<?php

/*
 * This file is part of the YamlLinter package.
 *
 * (c) Jules Pietri <jules@heahprod.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Heah\YamlLinter;

use Symfony\Component\Console\Application;
use Symfony\Component\Yaml\Command\LintCommand;

/**
 * @author Jules Pietri jules.pietri@sensiolabs.com
 */
class YamlLinter extends Application
{
    public const NAME = 'YAML Linter';
    public const VERSION = '1.0.0';

    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);

        $command = new LintCommand();
        $this
            ->add($command)
            ->setHelp(\str_replace('%command.full_name%', './bin/yaml-linter', $command->getHelp()))
        ;
        $this->setDefaultCommand(LintCommand::getDefaultName(), true);
    }
}
