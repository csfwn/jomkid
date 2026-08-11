<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle2, Clock3, RefreshCw, XCircle } from '@lucide/vue';

type Payment = {
    uuid: string;
    status: string;
    amount_sen: number;
    currency: string;
    paid_at: string | null;
};

defineProps<{ payment: Payment; successful: boolean }>();
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
const reload = () => window.location.reload();
</script>

<template>
    <Head title="Status pembayaran" />
    <div class="grid min-h-[70vh] place-items-center p-4">
        <section
            class="w-full max-w-xl rounded-3xl border bg-white p-7 text-center md:p-10"
        >
            <template v-if="successful">
                <span
                    class="mx-auto grid size-16 place-items-center rounded-full bg-emerald-100 text-emerald-700"
                    ><CheckCircle2 class="size-8"
                /></span>
                <h1 class="mt-5 text-3xl font-black">Pembayaran berjaya!</h1>
                <p class="mt-3 leading-7 text-slate-500">
                    Akses tahunan JomKid telah diaktifkan untuk akaun anda.
                </p>
                <Link
                    href="/learn"
                    class="mt-7 inline-flex rounded-full bg-indigo-600 px-7 py-3 font-black text-white"
                    >Mula belajar</Link
                >
            </template>
            <template
                v-else-if="
                    payment.status === 'created' ||
                    payment.status === 'initialized'
                "
            >
                <span
                    class="mx-auto grid size-16 place-items-center rounded-full bg-amber-100 text-amber-700"
                    ><Clock3 class="size-8"
                /></span>
                <h1 class="mt-5 text-3xl font-black">
                    Pengesahan sedang diproses
                </h1>
                <p class="mt-3 leading-7 text-slate-500">
                    CHIP belum mengesahkan pembayaran ini. Status akan dikemas
                    kini melalui webhook.
                </p>
                <button
                    class="mt-7 inline-flex items-center gap-2 rounded-full bg-slate-950 px-7 py-3 font-black text-white"
                    @click="reload"
                >
                    <RefreshCw class="size-4" /> Semak semula
                </button>
            </template>
            <template v-else>
                <span
                    class="mx-auto grid size-16 place-items-center rounded-full bg-rose-100 text-rose-700"
                    ><XCircle class="size-8"
                /></span>
                <h1 class="mt-5 text-3xl font-black">
                    Pembayaran belum berjaya
                </h1>
                <p class="mt-3 leading-7 text-slate-500">
                    Tiada caj yang disahkan. Anda boleh kembali ke halaman
                    pembayaran dan cuba semula.
                </p>
                <Link
                    href="/checkout"
                    class="mt-7 inline-flex rounded-full bg-slate-950 px-7 py-3 font-black text-white"
                    >Cuba semula</Link
                >
            </template>
            <div class="mt-8 rounded-2xl bg-slate-50 p-4 text-left text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Jumlah</span
                    ><strong>{{ money(payment.amount_sen) }}</strong>
                </div>
                <div class="mt-2 flex justify-between">
                    <span class="text-slate-500">Rujukan</span
                    ><code>{{ payment.uuid.slice(0, 8).toUpperCase() }}</code>
                </div>
                <div class="mt-2 flex justify-between">
                    <span class="text-slate-500">Status</span
                    ><strong class="uppercase">{{ payment.status }}</strong>
                </div>
            </div>
        </section>
    </div>
</template>
