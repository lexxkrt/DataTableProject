<?php
namespace Modules\DataTable\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakePage extends Command
{
    protected $signature = 'make:page {name} {--model=Model} {--directory=Directory}';

    protected $description = 'Create a new table page';

    public function handle()
    {
        $name = Str::finish($this->argument('name'), 'Page');
        $model = $this->option('model');
        $directory = Str::title($this->option('directory'));

        $namespace = "App\\Livewire\\";
        $directory and $namespace .= $directory . "\\";
        $namespace .= "Pages";

        $stub = file_get_contents(__DIR__ . '/../../resources/stubs/page.stub');
        $stub = str_replace('{{model}}', $model, $stub);
        $stub = str_replace('{{namespace}}', $namespace, $stub);

        $path = app_path("Livewire/{$directory}/Pages/{$name}.php");

        File::ensureDirectoryExists(dirname($path));

        if (!File::exists($path) || $this->confirm($this->argument('name') . ' already exists. Overwrite it?')) {
            File::put($path, $stub);
            $this->info($this->argument('name') . ' was made!');
        }

        $this->info("Page created successfully at {$path}");
    }
}
