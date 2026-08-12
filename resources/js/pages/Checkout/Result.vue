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
const stateClass = computed(() =>
    props.successful
        ? 'state-success'
        : processing.value
          ? 'state-processing'
          : 'state-error',
);
</script>

<template>
    <Head title="Status pembayaran JomKid" />

    <div class="result-page min-h-screen overflow-x-clip">
        <header class="result-nav">
            <div
                class="mx-auto flex h-18 max-w-5xl items-center justify-between px-4 sm:px-6 lg:px-8"
            >
                <Link href="/" class="brand-link">
                    <span class="brand-mark">J</span>
                    <span class="text-xl font-black">JomKid</span>
                </Link>
                <Link href="/" class="back-link">
                    <ChevronLeft class="size-4" /> Utama
                </Link>
            </div>
        </header>

        <main
            class="mx-auto grid min-h-[calc(100dvh-72px)] max-w-5xl items-center gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1fr_360px] lg:px-8"
        >
            <section>
                <div class="state-icon" :class="stateClass">
                    <MailCheck v-if="successful" class="size-11" />
                    <Clock3 v-else-if="processing" class="size-11" />
                    <XCircle v-else class="size-11" />
                </div>

                <template v-if="successful">
                    <p class="state-label state-success-text">
                        Bayaran disahkan
                    </p>
                    <h1 class="result-title">Kod sudah dihantar.</h1>
                    <p class="result-copy">
                        Semak {{ payment.email_hint }}, kemudian daftar
                        menggunakan kod sekali guna bersama e-mel pembelian.
                    </p>
                    <Link href="/register" class="result-button">
                        <Check class="size-5" />Daftar dengan kod
                    </Link>
                </template>

                <template v-else-if="processing">
                    <p class="state-label">Menunggu pengesahan</p>
                    <h1 class="result-title">CHIP sedang menyemak bayaran.</h1>
                    <p class="result-copy">
                        Kod belum dikeluarkan. Semak semula selepas status
                        bayaran selesai disahkan.
                    </p>
                    <button type="button" class="result-button" @click="reload">
                        <RefreshCw class="size-5" />Semak semula
                    </button>
                </template>

                <template v-else>
                    <p class="state-label state-error-text">
                        Bayaran belum berjaya
                    </p>
                    <h1 class="result-title">Tiada kod dikeluarkan.</h1>
                    <p class="result-copy">
                        Kembali ke checkout untuk menyemak pakej dan mencuba
                        semula.
                    </p>
                    <Link href="/checkout" class="result-button">
                        Kembali ke checkout
                    </Link>
                </template>
            </section>

            <aside class="transaction-panel">
                <h2 class="text-sm font-black text-[var(--muted)]">
                    Ringkasan bayaran
                </h2>
                <dl class="mt-6 grid gap-5">
                    <div class="transaction-row">
                        <dt>Jumlah</dt>
                        <dd>{{ money(payment.amount_sen) }}</dd>
                    </div>
                    <div class="transaction-row">
                        <dt>Rujukan</dt>
                        <dd class="font-mono text-sm">
                            {{ payment.uuid.slice(0, 8).toUpperCase() }}
                        </dd>
                    </div>
                    <div class="transaction-row">
                        <dt>Status</dt>
                        <dd class="text-sm uppercase">{{ payment.status }}</dd>
                    </div>
                </dl>
                <p class="server-note">
                    Browser redirect bukan bukti bayaran. Status ini datang
                    daripada semakan server CHIP.
                </p>
            </aside>
        </main>
    </div>
</template>

<style scoped>
.result-page {
    --page: #f7f8f4;
    --surface: #fdfefb;
    --surface-soft: #eef1f4;
    --ink: #16213a;
    --muted: #5d687b;
    --line: #dbe0e6;
    --accent: #d84d16;
    --accent-strong: #b83d0d;
    --accent-ink: #fff8f2;
    color: var(--ink);
    background: var(--page);
}
.result-nav {
    border-bottom: 1px solid var(--line);
}
.brand-link,
.back-link,
.result-button {
    display: inline-flex;
    align-items: center;
}
.brand-link {
    min-height: 2.75rem;
    gap: 0.75rem;
}
.brand-mark {
    display: grid;
    width: 2.5rem;
    height: 2.5rem;
    place-items: center;
    border-radius: 0.875rem;
    color: var(--accent-ink);
    background: var(--accent);
    font-weight: 900;
}
.back-link {
    min-height: 2.75rem;
    gap: 0.4rem;
    font-size: 0.875rem;
    font-weight: 800;
}
.state-icon {
    display: grid;
    width: 6rem;
    height: 6rem;
    place-items: center;
    border: 1px solid currentColor;
    border-radius: 1.25rem;
}
.state-success {
    color: #245d3c;
    background: #e3f2e8;
}
.state-processing {
    color: var(--accent);
    background: #f6e9e1;
}
.state-error {
    color: #8e3026;
    background: #f8e4e0;
}
.state-label {
    margin-top: 2rem;
    color: var(--accent);
    font-size: 0.82rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.state-success-text {
    color: #2f7450;
}
.state-error-text {
    color: #9f2f22;
}
.result-title {
    max-width: 12ch;
    margin-top: 0.75rem;
    font-size: clamp(3rem, 7vw, 5.8rem);
    font-weight: 900;
    letter-spacing: -0.065em;
    line-height: 0.95;
}
.result-copy {
    max-width: 36rem;
    margin-top: 1.5rem;
    color: var(--muted);
    font-size: 1.05rem;
    line-height: 1.75;
}
.result-button {
    min-height: 3.5rem;
    margin-top: 2rem;
    justify-content: center;
    gap: 0.75rem;
    border-radius: 999px;
    color: var(--accent-ink);
    background: var(--accent);
    padding-inline: 1.75rem;
    font-weight: 900;
    transition:
        transform 220ms cubic-bezier(0.16, 1, 0.3, 1),
        background-color 220ms ease;
}
.result-button:hover {
    transform: translateY(-2px);
    background: var(--accent-strong);
}
.result-button:active {
    transform: translateY(1px) scale(0.98);
}
.transaction-panel {
    border: 1px solid var(--line);
    border-radius: 1.25rem;
    background: var(--surface);
    padding: 1.75rem;
}
.transaction-row {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}
.transaction-row dt {
    color: var(--muted);
    font-size: 0.875rem;
}
.transaction-row dd {
    font-weight: 900;
}
.server-note {
    margin-top: 1.75rem;
    border-radius: 0.875rem;
    color: var(--muted);
    background: var(--surface-soft);
    padding: 1rem;
    font-size: 0.75rem;
    line-height: 1.65;
}
@media (prefers-color-scheme: dark) {
    .result-page {
        --page: #111827;
        --surface: #172036;
        --surface-soft: #1d2942;
        --ink: #f1f4f8;
        --muted: #b2bdcd;
        --line: #33405a;
        --accent: #f06a32;
        --accent-strong: #ff7942;
        --accent-ink: #151a28;
    }
    .state-success {
        color: #bce6c9;
        background: #1e4730;
    }
    .state-processing {
        color: #ffb491;
        background: #4d2c21;
    }
    .state-error {
        color: #ffd0c8;
        background: #512b28;
    }
    .state-success-text {
        color: #8fd3a6;
    }
    .state-error-text {
        color: #ffb9ad;
    }
}
@media (max-width: 767px) {
    .result-title {
        font-size: clamp(3rem, 14vw, 4.5rem);
    }
}
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        transition-duration: 0.01ms !important;
        animation-duration: 0.01ms !important;
    }
}
</style>
