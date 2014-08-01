<?php namespace spec\Acme\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Acme\Console\CommandInput;
use Illuminate\Filesystem\Filesystem;
use Mustache_Engine;

class CommandGeneratorSpec extends ObjectBehavior {

    function let(Filesystem $file, Mustache_Engine $mustache)
    {
        $this->beConstructedWith($file, $mustache);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Acme\Console\CommandGenerator');
    }

    function it_generates_a_command_clas(Filesystem $file, Mustache_Engine $mustache)
    {
        $input = new CommandInput('SomeCommand', 'Acme\Bar', ['name', 'email'], '$name, $email');
        $template = 'foo.stub';
        $destination = 'app/Acme/Bar/SomeCommand.php';

        $file->get($template)->shouldBeCalled()->willReturn('template');
        $mustache->render('template', $input)->shouldBeCalled()->willReturn('stub');
        $file->put($destination, 'stub')->shouldBeCalled();

        $this->make($input, $template, $destination);
    }

}
