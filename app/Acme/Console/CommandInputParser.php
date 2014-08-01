<?php namespace Acme\Console;

class CommandInputParser {

    /**
     * Parse the command input into a usable format.
     *
     * @param $path
     * @param $properties
     * @return CommandInput
     */
    public function parse($path, $properties)
    {
        $segments = explode('\\', str_replace('/', '\\', $path));
        $name = array_pop($segments);
        $namespace = implode('\\', $segments);

        $properties = $this->parseProperties($properties);

        return new CommandInput($name, $namespace, $properties);
    }

    /**
     * Parse the properties into an array.
     *
     * @param $properties
     * @return array
     */
    private function parseProperties($properties)
    {
        return preg_split('/ ?, ?/', $properties, null, PREG_SPLIT_NO_EMPTY);
    }

}
