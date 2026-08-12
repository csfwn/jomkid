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
const tone = computed(() =>
    props.successful
        ? { bg: 'bg-[#E4F5E8]', ink: 'text-[#28653D]', ring: 'ring-[#8ED39F]' }
        : processing.value
          ? {
                bg: 'bg-[#FFF0B8]',
                ink: 'text-[#845400]',
                ring: 'ring-[#FFD84D]',
            }
          : {
                bg: 'bg-[#FFE0D8]',
                ink: 'text-[#9C3E2B]',
                ring: 'ring-[#FF8F78]',
            },
);
</script>

<template>
    <Head title="Status pembayaran JomKid" />
    <div class="min-h-screen overflow-x-clip bg-[#FFF9E8] text-[#17213B]">
        <header>
            <div
                class="mx-auto flex min-h-20 max-w-5xl items-center justify-between px-5 lg:px-8"
            >
                <Link href="/" class="flex min-h-11 items-center gap-3"
                    ><span
                        class="grid size-11 place-items-center rounded-2xl bg-[#FFD84D] text-xl font-black shadow-[0_4px_0_#E0A800]"
                        >J</span
                    ><span class="text-2xl font-black">JomKid</span></Link
                ><Link
                    href="/"
                    class="inline-flex min-h-11 items-center gap-2 rounded-full px-3 text-sm font-bold hover:bg-white"
                    ><ChevronLeft class="size-4" /> Utama</Link
                >
            </div>
        </header>

        <main
            class="mx-auto grid min-h-[calc(100vh-80px)] max-w-5xl items-center gap-10 px-5 py-12 lg:grid-cols-[1fr_360px] lg:px-8"
        >
            <section>
                <div
                    class="grid size-28 place-items-center rounded-full ring-8"
                    :class="[tone.bg, tone.ink, tone.ring]"
                >
                    <MailCheck v-if="successful" class="size-12" /><Clock3
                        v-else-if="processing"
                        class="size-12"
                    /><XCircle v-else class="size-12" />
                </div>
                <template v-if="successful"
                    ><p class="mt-8 text-sm font-black text-[#28653D]">
                        BAYARAN DISAHKAN
                    </p>
                    <h1
                        class="mt-3 max-w-2xl text-5xl leading-[.98] font-black tracking-[-0.055em] sm:text-7xl"
                    >
                        Semak e-mel untuk kod anda.
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-[#65708E]">
                        Kod pendaftaran sekali guna dihantar ke
                        <strong class="text-[#17213B]">{{
                            payment.email_hint
                        }}</strong
                        >. Gunakan kod itu bersama e-mel pembelian semasa
                        mendaftar.
                    </p>
                    <Link
                        href="/register"
                        class="mt-8 inline-flex min-h-15 items-center gap-3 rounded-full bg-[#17213B] px-7 font-black text-white shadow-[0_5px_0_#65708E]"
                        ><Check class="size-5" />Daftar menggunakan kod</Link
                    ></template
                >
                <template v-else-if="processing"
                    ><p class="mt-8 text-sm font-black text-[#845400]">
                        MENUNGGU PENGESAHAN
                    </p>
                    <h1
                        class="mt-3 max-w-2xl text-5xl leading-[.98] font-black tracking-[-0.055em] sm:text-7xl"
                    >
                        CHIP masih menyemak bayaran.
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-[#65708E]">
                        Kod belum dikeluarkan. Semak semula selepas status
                        bayaran selesai disahkan pada server JomKid.
                    </p>
                    <button
                        type="button"
                        class="mt-8 inline-flex min-h-15 items-center gap-3 rounded-full bg-[#FFD84D] px-7 font-black shadow-[0_5px_0_#E0A800]"
                        @click="reload"
                    >
                        <RefreshCw class="size-5" />Semak status semula
                    </button></template
                >
                <template v-else
                    ><p class="mt-8 text-sm font-black text-[#9C3E2B]">
                        BAYARAN BELUM BERJAYA
                    </p>
                    <h1
                        class="mt-3 max-w-2xl text-5xl leading-[.98] font-black tracking-[-0.055em] sm:text-7xl"
                    >
                        Tiada kod dikeluarkan.
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-[#65708E]">
                        Bayaran belum disahkan. Kembali ke checkout untuk semak
                        pakej dan cuba semula.
                    </p>
                    <Link
                        href="/checkout"
                        class="mt-8 inline-flex min-h-15 items-center rounded-full bg-[#17213B] px-7 font-black text-white shadow-[0_5px_0_#65708E]"
                        >Kembali ke checkout</Link
                    ></template
                >
            </section>

            <aside
                class="rounded-[32px] bg-white p-7 shadow-[0_18px_55px_rgba(23,33,59,.1)]"
            >
                <p class="text-sm font-black text-[#65708E]">
                    RINGKASAN BAYARAN
                </p>
                <dl class="mt-5 space-y-4">
                    <div
                        class="flex justify-between gap-4 border-b border-[#E2E5EC] pb-4"
                    >
                        <dt class="text-sm text-[#65708E]">Jumlah</dt>
                        <dd class="font-black">
                            {{ money(payment.amount_sen) }}
                        </dd>
                    </div>
                    <div
                        class="flex justify-between gap-4 border-b border-[#E2E5EC] pb-4"
                    >
                        <dt class="text-sm text-[#65708E]">Rujukan</dt>
                        <dd class="font-mono text-sm font-black">
                            {{ payment.uuid.slice(0, 8).toUpperCase() }}
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-[#65708E]">Status</dt>
                        <dd class="text-sm font-black uppercase">
                            {{ payment.status }}
                        </dd>
                    </div>
                </dl>
                <p
                    class="mt-6 rounded-2xl bg-[#F3F5F8] p-4 text-xs leading-5 text-[#65708E]"
                >
                    Browser redirect bukan bukti bayaran. Status ini datang
                    daripada semakan server CHIP.
                </p>
            </aside>
        </main>
    </div>
</template>
