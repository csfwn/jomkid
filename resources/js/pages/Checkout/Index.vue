<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Check, CreditCard, LockKeyhole, ShieldCheck } from '@lucide/vue';

type Plan = {
    name: string;
    price_sen: number;
    currency: string;
    child_limit: number;
};
type Subscription = { status: string; ends_at: string | null } | null;

defineProps<{ plan: Plan; activeSubscription: Subscription }>();
const form = useForm({ payment: '' });
const pay = () => form.post('/checkout');
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
</script>

<template>
    <Head title="Langgan JomKid" />
    <div class="mx-auto w-full max-w-5xl p-4 md:p-8">
        <header class="mb-8 max-w-2xl">
            <p class="text-sm font-black text-indigo-600">LANGGANAN JOMKID</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">
                Satu langganan untuk semua modul.
            </h1>
            <p class="mt-3 leading-7 text-slate-500">
                Akses JomABC sekarang serta modul JomMengaji dan JomMengira
                apabila dilancarkan.
            </p>
        </header>

        <div class="grid gap-6 lg:grid-cols-[1fr_380px]">
            <section class="rounded-3xl border bg-white p-6 md:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-slate-500">
                            PELAN TAHUNAN
                        </p>
                        <h2 class="mt-1 text-2xl font-black">
                            {{ plan.name }}
                        </h2>
                    </div>
                    <span
                        class="grid size-12 place-items-center rounded-2xl bg-indigo-100 text-indigo-700"
                    >
                        <CreditCard />
                    </span>
                </div>
                <div class="mt-8 flex items-end gap-2 border-b pb-8">
                    <strong class="text-5xl font-black">{{
                        money(plan.price_sen)
                    }}</strong>
                    <span class="pb-1 text-slate-500">/ tahun</span>
                </div>
                <ul class="mt-7 grid gap-4 sm:grid-cols-2">
                    <li class="flex items-center gap-3 font-semibold">
                        <Check class="size-5 text-emerald-600" /> Sehingga
                        {{ plan.child_limit }} profil anak
                    </li>
                    <li class="flex items-center gap-3 font-semibold">
                        <Check class="size-5 text-emerald-600" /> Semua modul
                        JomKid
                    </li>
                    <li class="flex items-center gap-3 font-semibold">
                        <Check class="size-5 text-emerald-600" /> Laporan
                        perkembangan
                    </li>
                    <li class="flex items-center gap-3 font-semibold">
                        <Check class="size-5 text-emerald-600" /> Aktiviti suara
                        & sentuhan
                    </li>
                </ul>
            </section>

            <aside
                class="h-fit rounded-3xl bg-indigo-950 p-6 text-white md:p-7"
            >
                <template v-if="activeSubscription">
                    <ShieldCheck class="size-8 text-yellow-300" />
                    <h2 class="mt-4 text-xl font-black">
                        Langganan anda aktif
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-indigo-100">
                        Akaun ini sudah mempunyai akses aktif ke JomKid.
                    </p>
                    <a
                        href="/learn"
                        class="mt-6 flex justify-center rounded-full bg-yellow-300 px-5 py-3 font-black text-indigo-950"
                        >Teruskan belajar</a
                    >
                </template>
                <template v-else>
                    <LockKeyhole class="size-8 text-yellow-300" />
                    <h2 class="mt-4 text-xl font-black">Pembayaran selamat</h2>
                    <p class="mt-2 text-sm leading-6 text-indigo-100">
                        Anda akan dibawa ke halaman pembayaran CHIP untuk FPX,
                        kad atau kaedah pembayaran yang tersedia.
                    </p>
                    <div
                        class="my-6 flex items-center justify-between border-y border-white/15 py-5"
                    >
                        <span class="font-bold">Jumlah</span>
                        <strong class="text-2xl">{{
                            money(plan.price_sen)
                        }}</strong>
                    </div>
                    <p
                        v-if="form.errors.payment"
                        class="mb-4 rounded-2xl bg-rose-500/20 p-3 text-sm text-rose-100"
                    >
                        {{ form.errors.payment }}
                    </p>
                    <button
                        :disabled="form.processing"
                        class="flex w-full items-center justify-center gap-2 rounded-full bg-yellow-300 px-5 py-3 font-black text-indigo-950 disabled:opacity-50"
                        @click="pay"
                    >
                        <CreditCard class="size-5" />
                        {{
                            form.processing
                                ? 'Menyediakan pembayaran…'
                                : 'Bayar dengan CHIP'
                        }}
                    </button>
                    <p
                        class="mt-4 text-center text-xs leading-5 text-indigo-200"
                    >
                        Status akses hanya diaktifkan selepas CHIP mengesahkan
                        pembayaran pada server JomKid.
                    </p>
                </template>
            </aside>
        </div>
    </div>
</template>
