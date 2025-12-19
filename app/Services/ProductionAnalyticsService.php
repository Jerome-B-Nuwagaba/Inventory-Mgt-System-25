<?php

namespace App\Services;

use App\Models\ProcessFlow;
use Carbon\Carbon;

class ProductionAnalyticsService
{
    /**
     * Calculate all production analytics metrics.
     *
     * @return array
     */
    public function getAnalyticsData(): array
    {
        $processFlows = ProcessFlow::all();

        // 1. Summary Production Statistics
        $totalItemsProcessed = $processFlows->count();
        $totalCompletedItems = $processFlows->where('status', 'completed')->count();
        $totalFailedItems = $processFlows->where('status', 'failed')->count();
        $overallYield = ($totalItemsProcessed > 0) ? round(($totalCompletedItems / $totalItemsProcessed) * 100, 2) : 0;

        // 2. Stage Distribution (for pie chart)
        $stageCounts = [
            'raw_materials' => 0,
            'manufacturing' => 0,
            'quality_control' => 0,
            'distribution' => 0,
            'retail' => 0,
            'completed' => 0,
            'failed' => 0,
        ];

        foreach ($processFlows as $flow) {
            if ($flow->status === 'completed') {
                $stageCounts['completed']++;
            } elseif ($flow->status === 'failed') {
                $stageCounts['failed']++;
            } else {
                if (array_key_exists($flow->current_stage, $stageCounts)) {
                    $stageCounts[$flow->current_stage]++;
                }
            }
        }

        $stageLabels = array_keys($stageCounts);
        $stageData = array_values($stageCounts);

        // 3. Stage Duration Analysis
        $stageDurations = [
            'raw_materials' => [],
            'manufacturing' => [],
            'quality_control' => [],
            'distribution' => [],
            'retail' => [],
        ];

        foreach ($processFlows as $flow) {
            if ($flow->entered_stage_at) {
                $start = Carbon::parse($flow->entered_stage_at);
                $end = null;

                if ($flow->status === 'completed' && $flow->completed_stage_at) {
                    $end = Carbon::parse($flow->completed_stage_at);
                } elseif ($flow->status === 'failed') {
                    $end = Carbon::parse($flow->updated_at); // Use updated_at for failed items
                } elseif ($flow->status === 'in_progress') {
                    $end = Carbon::now(); // For items still in progress
                }

                if ($end && $flow->current_stage && array_key_exists($flow->current_stage, $stageDurations)) {
                    $duration = $end->diffInMinutes($start); // Duration in minutes
                    $stageDurations[$flow->current_stage][] = $duration;
                }
            }
        }

        $averageStageDurations = [];
        foreach ($stageDurations as $stage => $durations) {
            $averageStageDurations[$stage] = count($durations) > 0 ? round(array_sum($durations) / count($durations), 2) : 0;
        }

        // 4. Production Rate Over Time
        $completedItemsByDate = $processFlows->where('status', 'completed')
                                            ->groupBy(function($date) {
                                                return Carbon::parse($date->completed_stage_at)->format('Y-m-d');
                                            })
                                            ->map->count();

        $productionRateLabels = $completedItemsByDate->keys()->sort()->values()->toArray();
        $productionRateData = $completedItemsByDate->values()->toArray();

        // 5. Failure Trends Over Time
        $failedItemsByDate = $processFlows->where('status', 'failed')
                                        ->groupBy(function($date) {
                                            return Carbon::parse($date->updated_at)->format('Y-m-d');
                                        })
                                        ->map->count();

        $failureTrendLabels = $failedItemsByDate->keys()->sort()->values()->toArray();
        $failureTrendData = $failedItemsByDate->values()->toArray();

        return compact(
            'stageLabels',
            'stageData',
            'totalItemsProcessed',
            'totalCompletedItems',
            'totalFailedItems',
            'overallYield',
            'averageStageDurations',
            'productionRateLabels',
            'productionRateData',
            'failureTrendLabels',
            'failureTrendData'
        );
    }
}
