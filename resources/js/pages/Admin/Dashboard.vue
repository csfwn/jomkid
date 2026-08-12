<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Activity,
    BadgeDollarSign,
    ChartNoAxesCombined,
    CircleDollarSign,
    CreditCard,
    GraduationCap,
    Target,
    TriangleAlert,
    Users,
} from '@lucide/vue';

type Metrics = {
    users: number;
    students: number;
    affiliates: number;
    revenue_sen: number;
    paid_orders: number;
    conversion_rate: number;
    failed_orders: number;
    pending_commission_sen: number;
    completed_lessons: number;
    average_accuracy: number;
    active_students_7d: number;
};
type PackageMix = {
    code: string;
    name: string;
    users: number;
    paid_orders: number;
    revenue_sen: number;
};
type Trend = { date: string; sales: number; revenue_sen: number };
type Payment = {
    uuid: string;
    customer_name: string;
    customer_email: string;
    package_code: string;
    status: string;
    amount_sen: number;
};
const props = defineProps<{
    metrics: Metrics;
    packageMix: PackageMix[];
    salesTrend: Trend[];
    recentPayments: Payment[];
}>();
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
const maxRevenue = Math.max(
    ...props.salesTrend.map((item) => item.revenue_sen),
    1,
);
</script>

<template>
    <Head title="Analitik Admin" />
    <div class="space-y-7 p-4 md:p-7">
        <header
            class="flex flex-col justify-between gap-4 lg:flex-row lg:items-end"
        >
            <div>
                <p class="text-sm font-black text-indigo-600">ADMIN JOMKID</p>
                <h1 class="mt-1 text-3xl font-black">Analitik perniagaan</h1>
                <p class="mt-2 text-slate-500">
                    Data penting jualan, pelanggan, affiliate dan pembelajaran.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <Link
                    href="/admin/users"
                    class="rounded-full border bg-white px-4 py-2 text-sm font-black"
                    >Pengguna</Link
                >
                <Link
                    href="/admin/students"
                    class="rounded-full border bg-white px-4 py-2 text-sm font-black"
                    >Pelajar</Link
                >
                <Link
                    href="/admin/affiliates"
                    class="rounded-full bg-slate-950 px-4 py-2 text-sm font-black text-white"
                    >Affiliate</Link
                >
            </div>
        </header>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-3xl border bg-white p-5">
                <CircleDollarSign class="text-emerald-600" />
                <p class="mt-4 text-3xl font-black">
                    {{ money(metrics.revenue_sen) }}
                </p>
                <p class="text-sm text-slate-500">Jumlah hasil disahkan</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <CreditCard class="text-indigo-600" />
                <p class="mt-4 text-3xl font-black">
                    {{ metrics.paid_orders }}
                </p>
                <p class="text-sm text-slate-500">Pesanan berjaya</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <Target class="text-amber-500" />
                <p class="mt-4 text-3xl font-black">
                    {{ metrics.conversion_rate }}%
                </p>
                <p class="text-sm text-slate-500">Payment success rate</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <TriangleAlert class="text-rose-500" />
                <p class="mt-4 text-3xl font-black">
                    {{ metrics.failed_orders }}
                </p>
                <p class="text-sm text-slate-500">Bayaran gagal/dibatalkan</p>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
            <article class="rounded-3xl border bg-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-indigo-600">7 HARI</p>
                        <h2 class="text-xl font-black">Trend hasil jualan</h2>
                    </div>
                    <ChartNoAxesCombined class="text-indigo-600" />
                </div>
                <div class="mt-8 flex h-52 items-end gap-3">
                    <div
                        v-for="item in salesTrend"
                        :key="item.date"
                        class="flex h-full flex-1 flex-col justify-end gap-2 text-center"
                    >
                        <span class="text-xs font-bold text-slate-500">{{
                            item.sales
                        }}</span>
                        <div
                            class="min-h-1 rounded-t-xl bg-indigo-600"
                            :style="{
                                height: `${Math.max((item.revenue_sen / maxRevenue) * 100, 3)}%`,
                            }"
                        ></div>
                        <span class="text-[11px] text-slate-500">{{
                            item.date
                        }}</span>
                    </div>
                </div>
            </article>
            <article class="rounded-3xl bg-indigo-950 p-6 text-white">
                <p class="text-xs font-black text-yellow-300">
                    TINDAKAN KEWANGAN
                </p>
                <h2 class="mt-2 text-xl font-black">Komisen menunggu</h2>
                <p class="mt-4 text-4xl font-black">
                    {{ money(metrics.pending_commission_sen) }}
                </p>
                <p class="mt-3 text-sm leading-6 text-indigo-100">
                    Komisen telah disahkan dan menunggu pembayaran kepada
                    affiliate.
                </p>
                <Link
                    href="/admin/affiliates"
                    class="mt-7 inline-flex rounded-full bg-yellow-300 px-5 py-3 text-sm font-black text-indigo-950"
                    >Lihat affiliate</Link
                >
            </article>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <article class="rounded-3xl border bg-white p-5">
                <Users class="text-indigo-600" />
                <p class="mt-3 text-3xl font-black">{{ metrics.users }}</p>
                <p class="text-sm text-slate-500">Pelanggan berdaftar</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <GraduationCap class="text-rose-500" />
                <p class="mt-3 text-3xl font-black">{{ metrics.students }}</p>
                <p class="text-sm text-slate-500">Profil pelajar</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <BadgeDollarSign class="text-emerald-600" />
                <p class="mt-3 text-3xl font-black">{{ metrics.affiliates }}</p>
                <p class="text-sm text-slate-500">Affiliate aktif</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <Activity class="text-amber-500" />
                <p class="mt-3 text-3xl font-black">
                    {{ metrics.active_students_7d }}
                </p>
                <p class="text-sm text-slate-500">Pelajar aktif 7 hari</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <ChartNoAxesCombined class="text-cyan-600" />
                <p class="mt-3 text-3xl font-black">
                    {{ metrics.completed_lessons }}
                </p>
                <p class="text-sm text-slate-500">Aktiviti selesai</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <Target class="text-violet-600" />
                <p class="mt-3 text-3xl font-black">
                    {{ metrics.average_accuracy }}%
                </p>
                <p class="text-sm text-slate-500">Purata ketepatan</p>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1fr_1.4fr]">
            <article class="rounded-3xl border bg-white p-6">
                <h2 class="text-xl font-black">Prestasi pakej</h2>
                <div class="mt-5 space-y-4">
                    <div
                        v-for="item in packageMix"
                        :key="item.code"
                        class="rounded-2xl bg-slate-50 p-4"
                    >
                        <div class="flex justify-between gap-3">
                            <div>
                                <p class="font-black">{{ item.name }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ item.users }} pengguna ·
                                    {{ item.paid_orders }} jualan
                                </p>
                            </div>
                            <strong>{{ money(item.revenue_sen) }}</strong>
                        </div>
                    </div>
                </div>
                <Link
                    href="/admin/packages"
                    class="mt-5 inline-flex text-sm font-black text-indigo-600"
                    >Lihat semua pakej →</Link
                >
            </article>
            <article class="overflow-hidden rounded-3xl border bg-white">
                <div class="p-6">
                    <h2 class="text-xl font-black">Transaksi terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead
                            class="bg-slate-50 text-xs text-slate-500 uppercase"
                        >
                            <tr>
                                <th class="p-4">Pelanggan</th>
                                <th>Pakej</th>
                                <th>Status</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr
                                v-for="payment in recentPayments"
                                :key="payment.uuid"
                            >
                                <td class="p-4">
                                    <p class="font-bold">
                                        {{ payment.customer_name }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ payment.customer_email }}
                                    </p>
                                </td>
                                <td class="capitalize">
                                    {{ payment.package_code }}
                                </td>
                                <td>
                                    <span
                                        class="rounded-full bg-slate-100 px-2 py-1 text-xs font-black uppercase"
                                        >{{ payment.status }}</span
                                    >
                                </td>
                                <td class="font-black">
                                    {{ money(payment.amount_sen) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </div>
</template>
