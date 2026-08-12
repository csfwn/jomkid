<?php

namespace App\Http\Controllers;

use App\Models\AffiliateCommission;
use App\Models\ChildProfile;
use App\Models\LessonAttempt;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function dashboard(): Response
    {
        $paid = Payment::query()->where('status', Payment::STATUS_PAID);
        $paidCount = (clone $paid)->count();
        $allPaymentCount = Payment::query()->count();
        $revenueSen = (int) (clone $paid)->sum('amount_sen');
        $failedOrders = Payment::query()->whereIn('status', [Payment::STATUS_FAILED, Payment::STATUS_CANCELLED])->count();
        $attempts = LessonAttempt::query();

        $salesTrend = collect(range(6, 0))->map(function (int $daysAgo): array {
            $date = now()->subDays($daysAgo);
            $query = Payment::query()
                ->where('status', Payment::STATUS_PAID)
                ->whereDate('paid_at', $date->toDateString());

            return [
                'date' => $date->format('d M'),
                'sales' => (clone $query)->count(),
                'revenue_sen' => (int) $query->sum('amount_sen'),
            ];
        });

        return Inertia::render('Admin/Dashboard', [
            'metrics' => [
                'users' => User::query()->where('role', '!=', User::ROLE_ADMIN)->count(),
                'students' => ChildProfile::query()->count(),
                'affiliates' => User::query()->where('affiliate_active', true)->count(),
                'revenue_sen' => $revenueSen,
                'paid_orders' => $paidCount,
                'conversion_rate' => $allPaymentCount > 0 ? round(($paidCount / $allPaymentCount) * 100, 1) : 0,
                'failed_orders' => $failedOrders,
                'pending_commission_sen' => (int) AffiliateCommission::query()->where('status', 'pending')->sum('amount_sen'),
                'completed_lessons' => (clone $attempts)->where('status', 'completed')->count(),
                'average_accuracy' => round((float) (clone $attempts)->whereNotNull('accuracy')->avg('accuracy'), 1),
                'active_students_7d' => ChildProfile::query()->whereHas('attempts', fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(7)))->count(),
            ],
            'packageMix' => collect($this->packagesConfig())->map(function (array $package, string $code): array {
                return [
                    'code' => $code,
                    'name' => $package['name'],
                    'users' => User::query()->where('package_code', $code)->count(),
                    'paid_orders' => Payment::query()->where('package_code', $code)->where('status', Payment::STATUS_PAID)->count(),
                    'revenue_sen' => (int) Payment::query()->where('package_code', $code)->where('status', Payment::STATUS_PAID)->sum('amount_sen'),
                ];
            })->values(),
            'salesTrend' => $salesTrend,
            'recentPayments' => Payment::query()->latest()->limit(8)->get([
                'uuid', 'customer_name', 'customer_email', 'package_code', 'status', 'amount_sen', 'created_at',
            ]),
        ]);
    }

    public function users(Request $request): Response
    {
        $search = trim((string) $request->query('search'));
        $users = User::query()
            ->where('role', '!=', User::ROLE_ADMIN)
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $inner) => $inner
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")))
            ->withCount('childProfiles')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Users', ['users' => $users, 'filters' => ['search' => $search]]);
    }

    public function packages(): Response
    {
        $packages = collect($this->packagesConfig())->map(function (array $package, string $code): array {
            return [...$package,
                'code' => $code,
                'users' => User::query()->where('package_code', $code)->count(),
                'paid_orders' => Payment::query()->where('package_code', $code)->where('status', Payment::STATUS_PAID)->count(),
                'revenue_sen' => (int) Payment::query()->where('package_code', $code)->where('status', Payment::STATUS_PAID)->sum('amount_sen'),
            ];
        })->values();

        return Inertia::render('Admin/Packages', ['packages' => $packages]);
    }

    public function students(Request $request): Response
    {
        $search = trim((string) $request->query('search'));
        $students = ChildProfile::query()
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $inner) => $inner
                ->where('display_name', 'like', "%{$search}%")
                ->orWhereHas('user', fn (Builder $userQuery) => $userQuery->where('name', 'like', "%{$search}%"))))
            ->with('user:id,name,email,package_code')
            ->withCount('attempts')
            ->withAvg('attempts', 'accuracy')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Students', ['students' => $students, 'filters' => ['search' => $search], 'currentYear' => now()->year]);
    }

    public function affiliates(Request $request): Response
    {
        $search = trim((string) $request->query('search'));
        $affiliates = User::query()
            ->where('affiliate_active', true)
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $inner) => $inner
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('affiliate_code', 'like', "%{$search}%")))
            ->withCount(['affiliateCommissions as sales_count' => fn (Builder $query) => $query->whereNotIn('status', ['reversed', 'cancelled'])])
            ->withSum(['affiliateCommissions as commission_sen' => fn (Builder $query) => $query->whereNotIn('status', ['reversed', 'cancelled'])], 'amount_sen')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Affiliates', ['affiliates' => $affiliates, 'filters' => ['search' => $search]]);
    }

    /**
     * @return array<string, array{code: string, name: string, price_sen: int, child_limit: int|null, reseller: bool}>
     */
    private function packagesConfig(): array
    {
        /** @var array<string, array{code: string, name: string, price_sen: int, child_limit: int|null, reseller: bool}> $packages */
        $packages = config('packages');

        return $packages;
    }
}
