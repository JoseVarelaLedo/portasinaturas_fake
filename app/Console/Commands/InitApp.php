<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;


class InitApp extends Command
{
   
    protected $signature = 'app:init';

    protected $description = 'Levantar servizos necesarios para executar aplicación';

     public function handle(): int
    {
        $this->info('Executando npm install...');
        if (!$this->runProcess(['npm', 'install'])) {
            return self::FAILURE;
        }
        
        $this->info('Executando npm run dev...');
        if (!$this->runProcess(['npm', 'run', 'dev'])) {
            return self::FAILURE;
        }
        
        $this->info('Iniciando php artisan serve...');
        $this->runProcess(['php', 'artisan', 'serve'], timeout: null);

        return self::SUCCESS;
    }

    private function runProcess(array $command, ?float $timeout = 60): bool
    {
        $process = new Process($command, base_path(), timeout: $timeout);
        
        $process->run(function (string $type, string $output) {
            $this->output->write($output);
        });

        if (!$process->isSuccessful()) {
            $this->error('Erro ao executar: ' . implode(' ', $command));
            $this->error($process->getErrorOutput());
            return false;
        }

        return true;
    }
}
