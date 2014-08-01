<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Acme\Console\CommandInputParser;
use Acme\Console\CommandGenerator;

class CommanderGenerateCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'commander:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate command and handler classes.';

    /**
     * @var CommandInputParser
     */
    protected $parser;

    /**
     * @var CommandGenerator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param CommandInputParser $parser
     * @param CommandGenerator $generator
     * @return CommanderGenerateCommand
     */
    public function __construct(CommandInputParser $parser, CommandGenerator $generator)
    {
        parent::__construct();

        $this->parser = $parser;
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        // Parse the input for the Artisan command into a usable format.
        $input = $this->parser->parse(
            $this->argument('path'),
            $this->option('properties')
        );

        // Actually create the file with the correct boilerplate.
        $this->generator->make(
            $input,
            app_path('commands/templates/command.template'),
            $this->getClassPath()
        );

        // Notify the user.
        $this->info('All done!');
    }

    /**
     * @return string
     */
    private function getClassPath()
    {
        return sprintf("%s/%s.php", $this->option('base'), $this->argument('path'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['path', InputArgument::REQUIRED, 'Path to the command class to generate.']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['properties', null, InputOption::VALUE_OPTIONAL, 'List of properties to build.', null],
            ['base', null, InputOption::VALUE_OPTIONAL, 'The base directory to begin from.', './app']
        ];
    }

}
