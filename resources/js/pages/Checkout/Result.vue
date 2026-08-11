<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    CheckCircle2,
    Clock3,
    MailCheck,
    RefreshCw,
    XCircle,
} from '@lucide/vue';

type Payment = {
    uuid: string;
    status: string;
    amount_sen: number;
    currency: string;
    paid_at: string | null;
    email_hint: string;
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
    <div class="min-h-screen bg-slate-50 text-slate-950">
        <header class="border-b bg-white">
            <div
                class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 md:px-8"
            >
                <Link href="/" class="text-xl font-black">JomKid</Link>
                <Link href="/login" class="text-sm font-bold text-slate-600"
                    >Log masuk</Link
                >
            </div>
        </header>
        <main class="grid min-h-[80vh] place-items-center p-4">
            <section
                class="w-full max-w-xl rounded-3xl border bg-white p-7 text-center md:p-10"
            >
                <template v-if="successful">
                    <span
                        class="mx-auto grid size-16 place-items-center rounded-full bg-emerald-100 text-emerald-700"
                        ><MailCheck class="size-8"
                    /></span>
                    <h1 class="mt-5 text-3xl font-black">
                        Pembayaran berjaya!
                    </h1>
                    <p class="mt-3 leading-7 text-slate-500">
                        Kod pendaftaran sekali guna telah dihantar ke
                        <strong>{{ payment.email_hint }}</strong
                        >. Buka e-mel itu dan gunakan kod untuk mendaftar.
                    </p>
                    <Link
                        href="/register"
                        class="mt-7 inline-flex items-center gap-2 rounded-full bg-indigo-600 px-7 py-3 font-black text-white"
                        ><CheckCircle2 class="size-5" /> Daftar dengan kod</Link
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
                        CHIP belum mengesahkan pembayaran. Kod hanya akan
                        dihantar selepas webhook pembayaran berjaya diterima.
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
                        Tiada kod pendaftaran dikeluarkan. Anda boleh kembali
                        dan cuba semula.
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
                        ><code>{{
                            payment.uuid.slice(0, 8).toUpperCase()
                        }}</code>
                    </div>
                    <div class="mt-2 flex justify-between">
                        <span class="text-slate-500">Status</span
                        ><strong class="uppercase">{{ payment.status }}</strong>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
