<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use ReflectionClass;

class GenerateConstant extends Command
{
    const NAME_PROVIDER = '/js/common/configs/constantGenerate.js';
    const NAME_STUB = 'stubs/constantGenerate.stub';
    const ANCHOR_DEFINE = '{{content}}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'constant:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Constant Gate Provider';

    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $allModelsName = $this->getModels(app_path() . "/Models");
            $arrayModels = [];

            foreach ($allModelsName as $item) {
                $arrayExplode = explode('/', $item);
                $newClass = new ReflectionClass('App\\Models\\' . $arrayExplode[count($arrayExplode) - 1]);
                $filteredConstant = Arr::except($newClass->getConstants(), ['CREATED_AT', 'UPDATED_AT']);
                if ($filteredConstant) {
                    $arrayModels[$arrayExplode[count($arrayExplode) - 1]] = $filteredConstant;
                }
            }

            $stub = $this->files->get(base_path(self::NAME_STUB));
            $stub = str_replace(self::ANCHOR_DEFINE, json_encode($arrayModels, JSON_PRETTY_PRINT), $stub);
            $path = resource_path() . self::NAME_PROVIDER;
            $folder = dirname($path);
            if (!$this->files->exists($folder)) {
                $this->files->makeDirectory($folder, 0775, true, true);
            }
            $this->files->put($path, $stub);

            $this->info('Constant generated successfully.');
        } catch (\Exception $exception) {
            \Log::error($exception);
            $this->info('Constant generated failed.');
        }
    }

    function getModels($path)
    {
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . '/' . $result;
            if (!is_dir($filename)) {
                $out[] = substr($filename, 0, -4);
            }
        }
        return $out;
    }
}
