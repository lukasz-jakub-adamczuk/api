<?php

namespace Squarezone\Command;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

use Squarezone\Api\Service\Oauth2ClientCreator;
use Squarezone\Exception\Oauth\DuplicatedClientException;

class CreateOauthClientCommand extends Command
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('create-oauth-client')
            ->setDescription('Command for creating Oauth client')
            ->setDefinition([
                new InputArgument('name', InputArgument::REQUIRED, 'Person to be created')
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $logger = new ConsoleLogger($output);

        // $logger->error('Hello, {name}', ['name' => $name]);

        $service = new Oauth2ClientCreator();

        try {
            $client = $service->create($name, $this->db);

            // print_r($client);
            // $values = ['client_id' => $client['client_id'], 'secret' => $client['secret']];
            $values = $client;
            // $values = ['name' => '???'];
            
            $logger->info('Client {name} was created with secret {secret}', $values);
        } catch (DuplicatedClientException $e) {
            $logger->error($e);
        }
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Client for Oauth:',
                function ($name) {
                    if (empty($name)) {
                        throw new \Exception('Name can not be empty');
                    }

                    return $name;
                }
            );
            $input->setArgument('name', $name);
        }
    }
}
