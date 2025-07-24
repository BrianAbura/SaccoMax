<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class MemberReportService
{
    public function generate(string $type, array $filters = []): array
    {
        switch ($type) {
            case 'all':
                return $this->allMembers($filters);
            case 'inactive':
                return $this->inactiveMembers($filters);
            case 'savings':
                return $this->savings($filters);
            case 'withdrawals':
                return $this->withdrawals($filters);
            default:
                return [];
        }
    }

    private function allMembers(array $filters): array
    {
        $query = User::query();
        $dateQuery = User::query(); // Separate query for chart data

        if (!empty($filters['from']) && !empty($filters['to'])) {
            $query->whereBetween('created_at', [
                Carbon::parse($filters['from'])->startOfDay(),
                Carbon::parse($filters['to'])->endOfDay()
            ]);
            $dateQuery->whereBetween('created_at', [
                Carbon::parse($filters['from'])->startOfDay(),
                Carbon::parse($filters['to'])->endOfDay()
            ]);
        }

        // Get monthly registration data for chart
        $chartData = $dateQuery->get()
            ->groupBy(function ($member) {
                return $member->created_at->format('M Y');
            })
            ->map(function ($group) {
                return $group->count();
            });

        // Prepare table data
        $tableData = $query->get()->map(function ($member, $index) {
            return [
                $index + 1,
                $member->first_name . ' ' . $member->last_name,
                $member->phone_number,
                $member->created_at->format('d-m-Y'),
            ];
        })->toArray();

        return [
            'table' => $tableData,
            'chart' => [
                'labels' => $chartData->keys()->toArray(),
                'data' => $chartData->values()->toArray(),
            ],
        ];
    }

    private function inactiveMembers(array $filters): array
    {
        $query = User::where('status', 0);

        return $query->get()->map(function ($member, $index) {
            return [
                $index + 1,
                $member->first_name . ' ' . $member->last_name,
                $member->phone_number,
                optional($member->last_active_at)->format('Y-m-d') ?? 'N/A',
                'Inactive'
            ];
        })->toArray();
    }

    private function savings(array $filters): array
    {
        $members = User::withSum('savings', 'amount')
            ->orderBy('savings_sum_amount', 'desc')
            ->get();

        // Prepare table data
        $tableData = $members->map(function ($member, $index) {
            return [
                $index + 1,
                $member->first_name . ' ' . $member->last_name,
                'UGX ' . number_format($member->savings_sum_amount ?? 0),
            ];
        })->toArray();

        // Prepare chart data
        $chartData = [
            'labels' => $members->map(function ($member) {
                return $member->first_name . ' ' . $member->last_name;
            })->toArray(),
            'data' => $members->map(function ($member) {
                return $member->savings_sum_amount ?? 0;
            })->toArray(),
        ];

        return [
            'table' => $tableData,
            'chart' => $chartData,
        ];
    }

    private function withdrawals(array $filters): array
    {
        $members = User::withSum('withdrawals', 'amount')
            ->orderBy('withdrawals_sum_amount', 'desc')
            ->get();

        // Prepare table data
        $tableData = $members->map(function ($member, $index) {
            return [
                $index + 1,
                $member->first_name . ' ' . $member->last_name,
                'UGX ' . number_format($member->withdrawals_sum_amount ?? 0),
            ];
        })->toArray();

        // Prepare chart data
        $chartData = [
            'labels' => $members->map(function ($member) {
                return $member->first_name . ' ' . $member->last_name;
            })->toArray(),
            'data' => $members->map(function ($member) {
                return $member->withdrawals_sum_amount ?? 0;
            })->toArray(),
        ];

        return [
            'table' => $tableData,
            'chart' => $chartData,
        ];
    }
}
