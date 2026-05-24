<?php

namespace App\Http\Controllers;

use App\Models\FoodDonationItem;
use App\Models\MealService;
use App\Models\SocialPantryDistribution;
use Illuminate\View\View;

class SocialPantryReportController extends Controller
{
    public function audience(): View
    {
        $mealTotals = [
            'members' => (int) MealService::query()->sum('member_count'),
            'community' => (int) MealService::query()->sum('community_count'),
            'volunteers' => (int) MealService::query()->sum('volunteer_count'),
        ];

        $mealTotals['total'] = array_sum($mealTotals);

        $distributionTotals = [
            'member_families' => SocialPantryDistribution::query()->where('audience_type', 'member')->count(),
            'community_families' => SocialPantryDistribution::query()->where('audience_type', 'community')->count(),
            'people' => (int) SocialPantryDistribution::query()->sum('family_size'),
        ];

        $expiringItems = FoodDonationItem::query()
            ->with(['donation.donorMember', 'asset'])
            ->whereNotNull('expires_on')
            ->whereDate('expires_on', '>=', now()->toDateString())
            ->whereDate('expires_on', '<=', now()->addDays(30)->toDateString())
            ->orderBy('expires_on')
            ->limit(50)
            ->get();

        $recentDistributions = SocialPantryDistribution::query()
            ->with(['member', 'items'])
            ->latest('distributed_on')
            ->limit(20)
            ->get();

        return view('social-pantry.reports.audience', [
            'mealTotals' => $mealTotals,
            'distributionTotals' => $distributionTotals,
            'expiringItems' => $expiringItems,
            'recentDistributions' => $recentDistributions,
        ]);
    }
}
