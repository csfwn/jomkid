<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Check, ChevronLeft, CreditCard, Mail } from '@lucide/vue';
import { computed } from 'vue';

type Package = {
    code: 'basic' | 'premium';
    name: string;
    price_sen: number;
    child_limit: number | null;
    reseller: boolean;
};

const props = defineProps<{
    packages: Package[];
    defaultPackage: 'basic' | 'premium';
}>();

const form = useForm({
    name: '',
    email: '',
    package: props.defaultPackage,
    payment: '',
});
const selectedPackage = computed(() =>
    props.packages.find((item) => item.code === form.package)!,
);
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
const pay = () => form.post('/checkout');
</script>

<template>
    <Head title="Pilih akses lifetime JomKid">
        <meta
            name="description"
            content="Pilih pakej lifetime JomKid dan teruskan pembayaran melalui CHIP."
        />
    </Head>

    <div class="checkout-page min-h-screen overflow-x-clip">
        <header class="checkout-nav">
            <div
                class="mx-auto flex h-18 max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8"
            >
                <Link href="/" class="brand-link">
                    <span class="brand-mark">J</span>
                    <span class="text-xl font-black tracking-[-0.04em]"
                        >JomKid</span
                    >
                </Link>
                <Link href="/" class="back-link">
                    <ChevronLeft class="size-4" /> Kembali
                </Link>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
            <div class="max-w-2xl">
                <p class="checkout-eyebrow">Akses lifetime</p>
                <h1 class="checkout-title">Pilih pakej keluarga.</h1>
                <p class="checkout-copy">
                    Bayar sekali. Kod pendaftaran dihantar selepas CHIP
                    mengesahkan bayaran.
                </p>
            </div>

            <div
                class="mt-11 grid gap-10 lg:grid-cols-[1.08fr_.92fr] lg:items-start"
            >
                <section aria-labelledby="package-heading">
                    <h2 id="package-heading" class="text-lg font-black">
                        Pakej
                    </h2>
                    <div
                        role="radiogroup"
                        aria-labelledby="package-heading"
                        class="mt-4 grid gap-4 sm:grid-cols-2"
                    >
                        <button
                            v-for="item in packages"
                            :key="item.code"
                            type="button"
                            role="radio"
                            :aria-checked="form.package === item.code"
                            class="package-option"
                            :class="{
                                'package-selected': form.package === item.code,
                                'package-premium': item.code === 'premium',
                            }"
                            @click="form.package = item.code"
                        >
                            <span
                                v-if="form.package === item.code"
                                class="selected-check"
                            >
                                <Check class="size-4" />
                            </span>
                            <p class="text-sm font-black">
                                {{
                                    item.code === 'premium'
                                        ? 'Premium + Reseller'
                                        : 'Basic'
                                }}
                            </p>
                            <p
                                class="mt-5 text-4xl font-black tracking-[-0.055em]"
                            >
                                {{ money(item.price_sen) }}
                            </p>
                            <p class="mt-1 text-sm font-semibold opacity-70">
                                sekali bayar
                            </p>
                            <p class="mt-10 text-lg font-black">
                                {{
                                    item.child_limit === null
                                        ? 'Profil anak tanpa had'
                                        : `${item.child_limit} profil anak`
                                }}
                            </p>
                            <p class="mt-3 text-sm leading-6 opacity-75">
                                {{
                                    item.reseller
                                        ? 'Reseller license dan affiliate langsung 50%.'
                                        : 'Untuk keluarga tanpa reseller atau affiliate.'
                                }}
                            </p>
                        </button>
                    </div>

                    <div class="order-summary mt-6">
                        <div class="flex items-start justify-between gap-5">
                            <div>
                                <p
                                    class="text-sm font-bold text-[var(--muted)]"
                                >
                                    Pilihan anda
                                </p>
                                <h3 class="mt-1 text-2xl font-black">
                                    {{ selectedPackage.name }}
                                </h3>
                            </div>
                            <strong class="text-3xl tracking-[-0.04em]">
                                {{ money(selectedPackage.price_sen) }}
                            </strong>
                        </div>
                        <div
                            class="mt-7 grid gap-3 text-sm font-semibold sm:grid-cols-2"
                        >
                            <p class="flex gap-2">
                                <Check class="size-5 text-[var(--accent)]" />
                                {{
                                    selectedPackage.child_limit === null
                                        ? 'Profil tanpa had'
                                        : `Maksimum ${selectedPackage.child_limit} profil`
                                }}
                            </p>
                            <p class="flex gap-2">
                                <Check
                                    class="size-5 text-[var(--accent)]"
                                />Akses lifetime
                            </p>
                            <p class="flex gap-2">
                                <Check
                                    class="size-5 text-[var(--accent)]"
                                />Laporan ibu bapa
                            </p>
                            <p
                                v-if="selectedPackage.reseller"
                                class="flex gap-2"
                            >
                                <Check
                                    class="size-5 text-[var(--accent)]"
                                />Affiliate 50%
                            </p>
                        </div>
                    </div>
                </section>

                <aside class="buyer-panel lg:sticky lg:top-6">
                    <h2 class="text-3xl font-black tracking-[-0.045em]">
                        Maklumat pembeli
                    </h2>
                    <p class="mt-3 leading-7 text-[var(--muted)]">
                        Gunakan e-mel yang boleh dibuka. Kod hanya dihantar ke
                        alamat ini.
                    </p>

                    <form class="mt-7 grid gap-5" @submit.prevent="pay">
                        <label class="input-block">
                            <span>Nama penuh</span>
                            <input
                                v-model="form.name"
                                required
                                autocomplete="name"
                                placeholder="Nama pembeli"
                            />
                            <span v-if="form.errors.name" class="error-text">
                                {{ form.errors.name }}
                            </span>
                        </label>

                        <label class="input-block">
                            <span>E-mel untuk menerima kod</span>
                            <input
                                v-model="form.email"
                                required
                                type="email"
                                autocomplete="email"
                                placeholder="nama@email.com"
                            />
                            <span v-if="form.errors.email" class="error-text">
                                {{ form.errors.email }}
                            </span>
                        </label>

                        <p v-if="form.errors.package" class="error-panel">
                            {{ form.errors.package }}
                        </p>
                        <p v-if="form.errors.payment" class="error-panel">
                            {{ form.errors.payment }}
                        </p>

                        <div class="total-row">
                            <div>
                                <p
                                    class="text-sm font-bold text-[var(--muted)]"
                                >
                                    Jumlah
                                </p>
                                <p class="mt-1 text-xs text-[var(--muted)]">
                                    Tiada bayaran berulang
                                </p>
                            </div>
                            <strong class="text-3xl tracking-[-0.04em]">
                                {{ money(selectedPackage.price_sen) }}
                            </strong>
                        </div>

                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="pay-button"
                        >
                            <CreditCard class="size-5" />
                            {{
                                form.processing
                                    ? 'Menyediakan CHIP...'
                                    : `Bayar ${money(selectedPackage.price_sen)}`
                            }}
                        </button>
                    </form>

                    <p
                        class="mt-6 flex gap-3 text-xs leading-5 text-[var(--muted)]"
                    >
                        <Mail class="mt-0.5 size-4 shrink-0" />Kod dikeluarkan
                        selepas status bayaran disahkan pada server.
                    </p>
                </aside>
            </div>
        </main>
    </div>
</template>

<style scoped>
.checkout-page {
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
.checkout-nav {
    border-bottom: 1px solid var(--line);
}
.brand-link,
.back-link,
.pay-button {
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
.checkout-eyebrow {
    color: var(--accent);
    font-size: 0.82rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.checkout-title {
    margin-top: 0.75rem;
    font-size: clamp(2.8rem, 6vw, 5.25rem);
    font-weight: 900;
    letter-spacing: -0.06em;
    line-height: 0.96;
}
.checkout-copy {
    max-width: 38rem;
    margin-top: 1.25rem;
    color: var(--muted);
    font-size: 1.05rem;
    line-height: 1.7;
}
.package-option {
    position: relative;
    min-height: 18rem;
    padding: 1.5rem;
    border: 1px solid var(--line);
    border-radius: 1.25rem;
    color: var(--ink);
    background: var(--surface);
    text-align: left;
    transition:
        transform 220ms cubic-bezier(0.16, 1, 0.3, 1),
        border-color 220ms ease;
}
.package-option:hover {
    transform: translateY(-3px);
    border-color: var(--accent);
}
.package-option:active {
    transform: translateY(1px) scale(0.99);
}
.package-selected {
    border-color: var(--accent);
    box-shadow: inset 0 0 0 2px var(--accent);
}
.package-premium {
    background: var(--surface-soft);
}
.package-premium.package-selected {
    color: var(--accent-ink);
    background: var(--accent);
}
.selected-check {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    display: grid;
    width: 2rem;
    height: 2rem;
    place-items: center;
    border-radius: 999px;
    color: var(--accent-ink);
    background: var(--accent);
}
.package-premium.package-selected .selected-check {
    color: var(--accent);
    background: var(--surface);
}
.order-summary,
.buyer-panel {
    border: 1px solid var(--line);
    border-radius: 1.25rem;
    background: var(--surface);
}
.order-summary {
    padding: 1.5rem;
}
.buyer-panel {
    padding: clamp(1.5rem, 4vw, 2.25rem);
}
.input-block {
    display: grid;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 800;
}
.input-block input {
    min-height: 3.5rem;
    width: 100%;
    border: 1px solid #aab3c0;
    border-radius: 0.875rem;
    color: var(--ink);
    background: var(--page);
    padding-inline: 1rem;
    font-weight: 650;
}
.input-block input::placeholder {
    color: #697486;
    font-weight: 500;
}
.input-block input:focus-visible {
    outline: 3px solid var(--accent);
    outline-offset: 2px;
}
.error-text {
    color: #9f2f22;
    font-weight: 700;
}
.error-panel {
    border-radius: 0.875rem;
    color: #8e3026;
    background: #f8e4e0;
    padding: 1rem;
    font-size: 0.875rem;
    font-weight: 700;
}
.total-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    padding-block: 1.15rem;
    border-top: 1px solid var(--line);
}
.pay-button {
    min-height: 3.75rem;
    width: 100%;
    justify-content: center;
    gap: 0.75rem;
    border-radius: 999px;
    color: var(--accent-ink);
    background: var(--accent);
    padding-inline: 1.25rem;
    font-weight: 900;
    transition:
        transform 220ms cubic-bezier(0.16, 1, 0.3, 1),
        background-color 220ms ease;
}
.pay-button:hover {
    transform: translateY(-2px);
    background: var(--accent-strong);
}
.pay-button:active {
    transform: translateY(1px) scale(0.98);
}
.pay-button:disabled {
    cursor: wait;
    opacity: 0.6;
}
@media (prefers-color-scheme: dark) {
    .checkout-page {
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
    .input-block input {
        border-color: #6d7a90;
    }
    .input-block input::placeholder {
        color: #aab4c4;
    }
    .error-panel {
        color: #ffd0c8;
        background: #512b28;
    }
    .error-text {
        color: #ffb9ad;
    }
}
@media (max-width: 767px) {
    .checkout-title {
        font-size: clamp(2.75rem, 13vw, 4rem);
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
