<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    BadgeDollarSign,
    CheckCircle2,
    Clock3,
    Copy,
    MousePointerClick,
} from '@lucide/vue';
type Summary = {
    pending_sen: number;
    available_sen: number;
    paid_sen: number;
    sales: number;
};
type Commission = {
    id: number;
    amount_sen: number;
    status: string;
    created_at: string;
};
const props = defineProps<{
    affiliateCode: string | null;
    summary: Summary;
    commissions: Commission[];
}>();
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
const link = `${window.location.origin}/?ref=${props.affiliateCode ?? ''}`;
const copy = () => navigator.clipboard.writeText(link);
</script>
<template>
    <Head title="Affiliate" />
    <div class="space-y-7 p-4 md:p-7">
        <header>
            <p class="text-sm font-bold text-indigo-600">JOMKID AFFILIATE</p>
            <h1 class="mt-1 text-3xl font-black">Dapat 50% setiap jualan</h1>
            <p class="mt-2 text-slate-500">
                Program satu peringkat sahaja. Tiada upline, downline atau
                komisen perekrutan.
            </p>
        </header>
        <section class="rounded-3xl bg-indigo-950 p-7 text-white">
            <p class="text-sm font-bold text-indigo-200">PAUTAN ANDA</p>
            <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                <code
                    class="flex-1 overflow-x-auto rounded-2xl bg-white/10 px-4 py-3 text-sm"
                    >{{ link }}</code
                ><button
                    class="flex items-center justify-center gap-2 rounded-full bg-yellow-300 px-5 py-3 font-black text-indigo-950"
                    @click="copy"
                >
                    <Copy class="size-4" /> Salin pautan
                </button>
            </div>
        </section>
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-3xl border bg-white p-5">
                <Clock3 class="text-amber-500" />
                <p class="mt-4 text-2xl font-black">
                    {{ money(summary.pending_sen) }}
                </p>
                <p class="text-sm text-slate-500">Komisen pending</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <CheckCircle2 class="text-emerald-600" />
                <p class="mt-4 text-2xl font-black">
                    {{ money(summary.available_sen) }}
                </p>
                <p class="text-sm text-slate-500">Boleh dikeluarkan</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <BadgeDollarSign class="text-indigo-600" />
                <p class="mt-4 text-2xl font-black">
                    {{ money(summary.paid_sen) }}
                </p>
                <p class="text-sm text-slate-500">Telah dibayar</p>
            </article>
            <article class="rounded-3xl border bg-white p-5">
                <MousePointerClick class="text-rose-500" />
                <p class="mt-4 text-2xl font-black">{{ summary.sales }}</p>
                <p class="text-sm text-slate-500">Jumlah jualan</p>
            </article>
        </section>
        <section class="rounded-3xl border bg-white p-6">
            <h2 class="text-xl font-black">Transaksi terkini</h2>
            <div v-if="commissions.length" class="mt-4 divide-y">
                <div
                    v-for="item in commissions"
                    :key="item.id"
                    class="flex justify-between py-4"
                >
                    <div>
                        <p class="font-bold">Jualan #{{ item.id }}</p>
                        <p class="text-sm text-slate-500">
                            {{
                                new Date(item.created_at).toLocaleDateString(
                                    'ms-MY',
                                )
                            }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-black">{{ money(item.amount_sen) }}</p>
                        <p class="text-xs font-bold text-slate-500 uppercase">
                            {{ item.status }}
                        </p>
                    </div>
                </div>
            </div>
            <p
                v-else
                class="mt-5 rounded-2xl bg-slate-50 p-6 text-center text-slate-500"
            >
                Belum ada jualan affiliate.
            </p>
        </section>
    </div>
</template>
