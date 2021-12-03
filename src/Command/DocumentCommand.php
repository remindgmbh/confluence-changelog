<?php

declare(strict_types=1);

namespace Remind\ConfluenceChangelog\Command;

use Remind\ConfluenceChangelog\ConfluenceClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of DocumentCommand
 */
class DocumentCommand extends Command
{
    /**
     * Define the name of the command.
     * @var string
     */
    public const COMMAND_NAME = 'document';

    /**
     * Define token parameter name.
     *
     * @var string
     */
    public const ARGUMENT_TOKEN = 'token';

    /**
     * Define space key parameter name.
     *
     * @var string
     */
    public const ARGUMENT_SPACE_KEY = 'spaceKey';

    /**
     * Define ancestor parameter name.
     *
     * @var string
     */
    public const ARGUMENT_ANCESTOR = 'ancestor';

    /**
     * Define uri parameter name.
     *
     * @var string
     */
    public const ARGUMENT_URI = 'uri';

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Creates changelogs from git commits in confluence');
        $this->setDefinition(
            new InputDefinition([
                new InputOption(
                    self::ARGUMENT_TOKEN,
                    null,
                    InputOption::VALUE_REQUIRED,
                    'The API token used'
                ),
                new InputOption(
                    self::ARGUMENT_SPACE_KEY,
                    null,
                    InputOption::VALUE_REQUIRED,
                    'The confluence space key'
                ),
                new InputOption(
                    self::ARGUMENT_URI,
                    null,
                    InputOption::VALUE_REQUIRED,
                    'The REST API endpoint'
                ),
                new InputOption(
                    self::ARGUMENT_ANCESTOR,
                    null,
                    InputOption::VALUE_OPTIONAL,
                    'The parent page title'
                )
            ])
        );
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /* Parse data from passed arguments */
        $token = $input->getOption(self::ARGUMENT_TOKEN) ?? '';
        $spaceKey = $input->getOption(self::ARGUMENT_SPACE_KEY) ?? '';
        $ancestor = $input->getOption(self::ARGUMENT_ANCESTOR) ?? '';
        $uri = $input->getOption(self::ARGUMENT_URI) ?? '';

        /* Required arguments are empty */
        if ($token === '' || $spaceKey === '' || $uri === '') {
            return self::FAILURE;
        }

        /* Create a new client */
        $cc = new ConfluenceClient($token, $spaceKey, $uri, $ancestor);
        $cc->setOutput($output);

        /* Passthrough return value */
        return $cc->save();
    }
}
