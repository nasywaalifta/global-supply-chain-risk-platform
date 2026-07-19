<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RiskScoreService;

class CalculateRiskScore extends Command
{
    /**
     * Nama command
     */
    protected $signature = 'risk:calculate';

    /**
     * Deskripsi command
     */
    protected $description = 'Calculate risk score for all countries';

    protected RiskScoreService $riskScoreService;

    public function __construct(RiskScoreService $riskScoreService)
    {
        parent::__construct();

        $this->riskScoreService = $riskScoreService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Calculating risk scores...');

        $this->riskScoreService->calculateAll();

        $this->info('Risk score calculation completed.');
    }
}