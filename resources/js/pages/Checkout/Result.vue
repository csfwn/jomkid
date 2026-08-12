<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    Check,
    ChevronLeft,
    Clock3,
    MailCheck,
    RefreshCw,
    XCircle,
} from '@lucide/vue';
import { computed } from 'vue';

type Payment = {
    uuid: string;
    status: string;
    amount_sen: number;
    currency: string;
    paid_at: string | null;
    email_hint: string;
};

const props = defineProps<{ payment: Payment; successful: boolean }>();
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
const reload = () => window.location.reload();
const processing = computed(
    () =>
        !props.successful &&
        (props.payment.status === 'created' ||
            props.payment.status === 'initialized'),
);
</script>

<template>
    <Head title="Status pembayaran JomKid" />
    <div class="min-h-screen overflow-x-clip bg-[#fffaf0] text-[#17152b]">
        <header class="border-b-2 border-[#17152b] bg-[#f6c945]">
            <div
                class="mx-auto flex min-h-18 max-w-6xl items-center justify-between gap-4 px-5 py-3 lg:px-8"
            >
                <Link
                    href="/"
                    class="flex min-h-11 items-center gap-3 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#9a5b00]"
                >
                    <span
                        class="grid size-10 place-items-center rounded-[14px_14px_14px_4px] border-2 border-[#17152b] bg-[#f6c945] font-black text-[#17152b]"
                        >J</span
                    >
                    <span class="text-xl font-black tracking-[-0.03em]"
                        >JomKid</span
                    >
                </Link>
                <Link
                    href="/"
                    class="inline-flex min-h-11 items-center gap-2 text-sm font-black hover:text-[#9a5b00] focus-visible:outline-2 focus-visible:outline-offset-4"
                    ><ChevronLeft class="size-4" /> Halaman utama</Link
                >
            </div>
        </header>

        <main
            class="mx-auto grid min-h-[calc(100vh-74px)] max-w-6xl items-center gap-10 px-5 py-12 lg:grid-cols-[1fr_380px] lg:px-8"
        >
            <section>
                <template v-if="successful">
                    <p
                        class="flex items-center gap-3 text-sm font-black text-[#1f6b41]"
                    >
                        <span class="h-1 w-10 bg-[#1f6b41]"></span>BAYARAN
                        DISAHKAN
                    </p>
                    <h1
                        class="mt-5 max-w-3xl text-5xl leading-[0.95] font-black tracking-[-0.055em] sm:text-7xl"
                    >
                        Kod anda sedang menuju ke e-mel.
                    </h1>
                    <p class="mt-7 max-w-xl text-lg leading-8 text-[#5b586d]">
                        Kami telah menghantar kod pendaftaran sekali guna ke
                        <strong class="text-[#17152b]">{{
                            payment.email_hint
                        }}</strong
                        >. Buka e-mel tersebut, kemudian daftar menggunakan kod
                        yang diterima.
                    </p>
                    <Link
                        href="/register"
                        class="mt-8 inline-flex min-h-14 items-center gap-3 rounded-[18px_18px_18px_5px] border-2 border-[#17152b] bg-[#f6c945] px-7 font-black text-[#17152b] transition hover:-translate-y-0.5 hover:bg-[#ffd95f] focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#ff766b]"
                    >
                        <Check class="size-5" /> Daftar menggunakan kod
                    </Link>
                </template>

                <template v-else-if="processing">
                    <p
                        class="flex items-center gap-3 text-sm font-black text-[#9b6410]"
                    >
                        <span class="h-1 w-10 bg-[#f6c945]"></span>MENUNGGU
                        PENGESAHAN
                    </p>
                    <h1
                        class="mt-5 max-w-3xl text-5xl leading-[0.95] font-black tracking-[-0.055em] sm:text-7xl"
                    >
                        CHIP masih menyemak bayaran anda.
                    </h1>
                    <p class="mt-7 max-w-xl text-lg leading-8 text-[#5b586d]">
                        Kod belum dikeluarkan. Tekan semak semula selepas CHIP
                        selesai mengesahkan bayaran pada server JomKid.
                    </p>
                    <button
                        type="button"
                        class="mt-8 inline-flex min-h-14 items-center gap-3 rounded-[18px_18px_18px_5px] border-2 border-[#17152b] bg-[#f6c945] px-7 font-black transition hover:-translate-y-0.5 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#9a5b00]"
                        @click="reload"
                    >
                        <RefreshCw class="size-5" /> Semak status semula
                    </button>
                </template>

                <template v-else>
                    <p
                        class="flex items-center gap-3 text-sm font-black text-[#a92d25]"
                    >
                        <span class="h-1 w-10 bg-[#ff766b]"></span>BAYARAN BELUM
                        BERJAYA
                    </p>
                    <h1
                        class="mt-5 max-w-3xl text-5xl leading-[0.95] font-black tracking-[-0.055em] sm:text-7xl"
                    >
                        Tiada kod pendaftaran dikeluarkan.
                    </h1>
                    <p class="mt-7 max-w-xl text-lg leading-8 text-[#5b586d]">
                        Bayaran tidak disahkan. Anda boleh kembali ke checkout,
                        semak pakej dan cuba pembayaran semula.
                    </p>
                    <Link
                        href="/checkout"
                        class="mt-8 inline-flex min-h-14 items-center rounded-[18px_18px_18px_5px] border-2 border-[#17152b] bg-[#17152b] px-7 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#9a5b00] focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#ff766b]"
                        >Kembali ke checkout</Link
                    >
                </template>
            </section>

            <aside class="relative">
                <div
                    class="absolute -right-3 -bottom-3 h-full w-full rounded-[26px_26px_26px_6px] border-2 border-[#17152b]"
                    :class="
                        successful
                            ? 'bg-[#87d6a9]'
                            : processing
                              ? 'bg-[#f6c945]'
                              : 'bg-[#ff766b]'
                    "
                ></div>
                <div
                    class="relative rounded-[26px_26px_26px_6px] border-2 border-[#17152b] bg-white p-6 sm:p-7"
                >
                    <span
                        class="grid size-14 place-items-center rounded-[16px_16px_16px_4px] border-2 border-[#17152b]"
                        :class="
                            successful
                                ? 'bg-[#dff7e9] text-[#1f6b41]'
                                : processing
                                  ? 'bg-[#fff4c4] text-[#79500d]'
                                  : 'bg-[#ffebe7] text-[#a92d25]'
                        "
                    >
                        <MailCheck v-if="successful" />
                        <Clock3 v-else-if="processing" />
                        <XCircle v-else />
                    </span>
                    <p class="mt-6 text-sm font-black text-[#5b586d]">
                        RINGKASAN TRANSAKSI
                    </p>
                    <dl
                        class="mt-4 divide-y-2 divide-[#17152b] border-y-2 border-[#17152b]"
                    >
                        <div class="flex justify-between gap-4 py-4">
                            <dt class="text-sm font-semibold text-[#5b586d]">
                                Jumlah
                            </dt>
                            <dd class="font-black">
                                {{ money(payment.amount_sen) }}
                            </dd>
                        </div>
                        <div class="flex justify-between gap-4 py-4">
                            <dt class="text-sm font-semibold text-[#5b586d]">
                                Rujukan
                            </dt>
                            <dd class="font-mono text-sm font-black">
                                {{ payment.uuid.slice(0, 8).toUpperCase() }}
                            </dd>
                        </div>
                        <div class="flex justify-between gap-4 py-4">
                            <dt class="text-sm font-semibold text-[#5b586d]">
                                Status
                            </dt>
                            <dd class="text-sm font-black uppercase">
                                {{ payment.status }}
                            </dd>
                        </div>
                    </dl>
                    <p class="mt-5 text-xs leading-5 text-[#5b586d]">
                        Browser redirect bukan bukti bayaran. Status ini disemak
                        menggunakan data server CHIP.
                    </p>
                </div>
            </aside>
        </main>
    </div>
</template>
