<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Check,
    Headphones,
    Mail,
    RefreshCw,
    Volume2,
} from '@lucide/vue';
import { computed, ref } from 'vue';

defineProps<{ canRegister: boolean }>();

const answer = ref<string | null>(null);
const listening = ref(false);
const correct = computed(() => answer.value === 'M');

const playPrompt = () => {
    listening.value = true;
    window.setTimeout(() => (listening.value = false), 650);
};
const choose = (letter: string) => (answer.value = letter);
const reset = () => (answer.value = null);
</script>

<template>
    <Head title="JomKid, Belajar Bahasa Melayu Melalui Permainan">
        <meta
            name="description"
            content="JomKid menjadikan pembelajaran Bahasa Melayu satu pengalaman bermain yang ringkas, aktif dan mudah diikuti anak."
        />
        <link rel="preload" as="image" href="/images/jomkid-hero.webp" />
    </Head>

    <div class="marketing-page min-h-screen overflow-x-clip">
        <header class="marketing-nav">
            <div
                class="mx-auto flex h-18 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
            >
                <Link
                    href="/"
                    class="brand-link focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[var(--accent)]"
                >
                    <span class="brand-mark">J</span>
                    <span class="text-xl font-black tracking-[-0.04em]"
                        >JomKid</span
                    >
                </Link>

                <nav
                    aria-label="Navigasi utama"
                    class="hidden h-full items-center gap-7 text-sm font-bold md:flex"
                >
                    <a href="#cara-main" class="nav-item">Cara main</a>
                    <a href="#dunia" class="nav-item">Dunia</a>
                    <a href="#ibu-bapa" class="nav-item">Ibu bapa</a>
                    <a href="#pakej" class="nav-item">Pakej</a>
                </nav>

                <div class="flex items-center gap-2">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="
                            $page.props.auth.user.role === 'admin'
                                ? '/admin'
                                : '/dashboard'
                        "
                        class="button-primary min-h-11 px-5 text-sm"
                    >
                        Buka akaun
                    </Link>
                    <template v-else>
                        <Link
                            href="/login"
                            class="hidden min-h-11 items-center px-3 text-sm font-bold sm:inline-flex"
                        >
                            Log masuk
                        </Link>
                        <Link
                            v-if="canRegister"
                            href="/checkout?package=basic"
                            class="button-primary min-h-11 px-5 text-sm"
                        >
                            Pilih pakej
                        </Link>
                    </template>
                </div>
            </div>
        </header>

        <main>
            <section class="hero-shell">
                <div
                    class="mx-auto grid min-h-[calc(100dvh-72px)] max-w-7xl items-center gap-8 px-4 py-8 sm:px-6 md:grid-cols-[.82fr_1.18fr] lg:gap-14 lg:px-8"
                >
                    <div class="relative py-6 md:py-10">
                        <p class="hero-eyebrow">Bahasa Melayu jadi permainan</p>
                        <h1 class="hero-title">
                            Dengar, sentuh,<br />terus faham.
                        </h1>
                        <p class="hero-copy">
                            Aktiviti pendek JomABC membantu anak mengenal bunyi,
                            huruf dan perkataan melalui cubaan aktif.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <Link
                                href="/checkout?package=basic"
                                class="button-primary min-h-14 gap-3 px-7"
                            >
                                Pilih pakej <ArrowRight class="size-5" />
                            </Link>
                            <a
                                href="#cara-main"
                                class="button-secondary min-h-14 px-7"
                            >
                                Lihat cara main
                            </a>
                        </div>
                    </div>

                    <figure class="hero-figure">
                        <img
                            src="/images/jomkid-hero.webp"
                            alt="Seorang kanak-kanak menyusun blok huruf sambil memakai fon kepala"
                            width="1536"
                            height="1024"
                            fetchpriority="high"
                            class="h-full w-full object-cover object-center"
                        />
                    </figure>
                </div>
            </section>

            <section class="price-strip" aria-label="Harga permulaan JomKid">
                <div
                    class="mx-auto grid max-w-7xl gap-5 px-4 py-7 sm:grid-cols-[auto_1fr_auto] sm:items-center sm:px-6 lg:px-8"
                >
                    <p class="text-4xl font-black tracking-[-0.05em]">RM69</p>
                    <p class="max-w-lg text-sm leading-6 font-semibold">
                        Akses Basic lifetime untuk sehingga 3 profil anak. Bayar
                        sekali, kemudian daftar menggunakan kod e-mel.
                    </p>
                    <Link
                        href="/checkout?package=basic"
                        class="inline-flex min-h-11 items-center font-black underline decoration-2 underline-offset-5"
                    >
                        Pilih Basic <ArrowRight class="ml-2 size-4" />
                    </Link>
                </div>
            </section>

            <section id="cara-main" class="section-pad">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl">
                        <h2 class="section-title">
                            Satu arahan pada satu masa.
                        </h2>
                        <p class="section-copy">
                            Anak tahu apa yang perlu didengar, disentuh dan
                            dicuba semula tanpa paparan yang berserabut.
                        </p>
                    </div>

                    <div
                        class="mt-12 grid gap-5 md:grid-cols-[1.35fr_.65fr] md:grid-rows-2"
                    >
                        <article class="demo-panel md:row-span-2">
                            <div class="flex items-start justify-between gap-5">
                                <div>
                                    <p
                                        class="text-sm font-bold text-[var(--muted)]"
                                    >
                                        JomABC
                                    </p>
                                    <h3 class="mt-1 text-2xl font-black">
                                        Cari bunyi M
                                    </h3>
                                </div>
                                <span class="activity-count">1 / 3</span>
                            </div>

                            <div class="mt-8 text-center">
                                <button
                                    type="button"
                                    class="sound-button"
                                    :class="listening ? 'scale-105' : ''"
                                    aria-label="Mainkan arahan bunyi"
                                    @click="playPrompt"
                                >
                                    <Volume2 class="size-7" />
                                </button>
                                <p
                                    class="mt-4 text-sm font-bold text-[var(--muted)]"
                                >
                                    Tekan untuk dengar
                                </p>
                                <p class="mt-7 text-xl font-black">
                                    Huruf mana berbunyi “mmm”?
                                </p>
                                <div
                                    class="mx-auto mt-5 grid max-w-lg grid-cols-3 gap-3"
                                >
                                    <button
                                        v-for="letter in ['N', 'M', 'B']"
                                        :key="letter"
                                        type="button"
                                        class="letter-button"
                                        :class="
                                            answer === letter
                                                ? letter === 'M'
                                                    ? 'letter-correct'
                                                    : 'letter-wrong'
                                                : ''
                                        "
                                        @click="choose(letter)"
                                    >
                                        {{ letter }}
                                    </button>
                                </div>
                            </div>

                            <div aria-live="polite" class="mt-6 min-h-16">
                                <div
                                    v-if="answer && correct"
                                    class="feedback feedback-success"
                                >
                                    <p class="font-black">
                                        <Check
                                            class="mr-2 inline size-5"
                                        />Betul! Ini huruf M.
                                    </p>
                                </div>
                                <div
                                    v-else-if="answer"
                                    class="feedback feedback-error"
                                >
                                    <p class="font-black">
                                        Hampir. Dengar sekali lagi.
                                    </p>
                                    <button
                                        type="button"
                                        class="inline-flex min-h-11 items-center gap-2 font-black"
                                        @click="reset"
                                    >
                                        <RefreshCw class="size-4" /> Ulang
                                    </button>
                                </div>
                                <p
                                    v-else
                                    class="py-4 text-center text-sm font-semibold text-[var(--muted)]"
                                >
                                    Pilih satu huruf untuk mencuba.
                                </p>
                            </div>
                        </article>

                        <article class="principle-panel principle-accent">
                            <Headphones class="size-7" />
                            <h3 class="mt-8 text-2xl font-black">
                                Dengar dahulu.
                            </h3>
                            <p class="mt-2 leading-7">
                                Arahan ringkas memberi satu fokus yang jelas.
                            </p>
                        </article>

                        <article class="principle-panel">
                            <Check class="size-7 text-[var(--accent)]" />
                            <h3 class="mt-8 text-2xl font-black">
                                Terus tahu.
                            </h3>
                            <p class="mt-2 leading-7 text-[var(--muted)]">
                                Jawapan salah boleh dicuba semula serta-merta.
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="dunia" class="world-section">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl">
                        <h2 class="section-title">JomABC dibuka dahulu.</h2>
                        <p class="section-copy">
                            Huruf, bunyi dan perkataan mudah menjadi dunia
                            pertama sebelum JomMengaji dan JomMengira menyusul.
                        </p>
                    </div>
                    <figure class="world-figure mt-10">
                        <img
                            src="/images/jomkid-world.webp"
                            alt="Dunia permainan huruf dengan laluan, fon kepala, buku dan puzzle"
                            width="1822"
                            height="863"
                            class="h-full w-full object-cover"
                        />
                    </figure>
                    <div class="mt-6 grid gap-4 sm:grid-cols-[1.2fr_.9fr_.9fr]">
                        <div class="world-label world-active">
                            <strong>JomABC</strong>
                            <span>Sedia dimainkan dahulu</span>
                        </div>
                        <div class="world-label">
                            <strong>JomMengaji</strong>
                            <span>Akan datang</span>
                        </div>
                        <div class="world-label">
                            <strong>JomMengira</strong>
                            <span>Akan datang</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="ibu-bapa" class="section-pad">
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 md:grid-cols-[1.1fr_.9fr] md:items-center lg:gap-16 lg:px-8"
                >
                    <figure class="family-figure">
                        <img
                            src="/images/jomkid-family.webp"
                            alt="Seorang ibu melihat kemajuan pembelajaran bersama anaknya"
                            width="1536"
                            height="1024"
                            class="h-full w-full object-cover object-left"
                        />
                    </figure>
                    <div>
                        <h2 class="section-title">
                            Anak bermain. Ibu bapa tetap tahu.
                        </h2>
                        <p class="section-copy">
                            Setiap profil menyimpan aktiviti dan topik yang
                            perlu diulang untuk semakan keluarga.
                        </p>
                        <div
                            class="mt-8 grid gap-4 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2"
                        >
                            <div class="parent-fact">
                                <strong>Basic</strong>
                                <span>Sehingga 3 profil anak</span>
                            </div>
                            <div class="parent-fact">
                                <strong>Premium</strong>
                                <span>Profil anak tanpa had</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pakej" class="pricing-section">
                <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl">
                        <p class="pricing-eyebrow">Akses lifetime</p>
                        <h2 class="section-title">Pilih ikut keluarga anda.</h2>
                        <p class="section-copy">
                            Kedua-dua pakej dibayar sekali. Perbezaannya ialah
                            jumlah profil serta hak reseller dan affiliate.
                        </p>
                    </div>

                    <div class="mt-12 grid gap-5 md:grid-cols-[.92fr_1.08fr]">
                        <article class="price-option">
                            <div>
                                <p
                                    class="text-sm font-black text-[var(--muted)]"
                                >
                                    Basic
                                </p>
                                <p
                                    class="mt-3 text-5xl font-black tracking-[-0.06em]"
                                >
                                    RM69
                                </p>
                                <p
                                    class="mt-1 text-sm font-semibold text-[var(--muted)]"
                                >
                                    sekali bayar
                                </p>
                            </div>
                            <div class="mt-9 grid gap-3 font-semibold">
                                <p class="flex gap-3">
                                    <Check
                                        class="size-5 text-[var(--accent)]"
                                    />3 profil anak
                                </p>
                                <p class="flex gap-3">
                                    <Check
                                        class="size-5 text-[var(--accent)]"
                                    />Akses pembelajaran lifetime
                                </p>
                                <p class="flex gap-3">
                                    <Check
                                        class="size-5 text-[var(--accent)]"
                                    />Laporan ibu bapa
                                </p>
                            </div>
                            <Link
                                href="/checkout?package=basic"
                                class="button-secondary mt-9 min-h-14 w-full justify-center"
                            >
                                Pilih Basic
                            </Link>
                        </article>

                        <article class="price-option price-featured">
                            <div>
                                <p class="text-sm font-black">
                                    Premium + Reseller
                                </p>
                                <p
                                    class="mt-3 text-5xl font-black tracking-[-0.06em]"
                                >
                                    RM99
                                </p>
                                <p
                                    class="mt-1 text-sm font-semibold opacity-75"
                                >
                                    sekali bayar
                                </p>
                            </div>
                            <div class="mt-9 grid gap-3 font-semibold">
                                <p class="flex gap-3">
                                    <Check class="size-5" />Profil anak tanpa
                                    had
                                </p>
                                <p class="flex gap-3">
                                    <Check class="size-5" />Reseller license
                                </p>
                                <p class="flex gap-3">
                                    <Check class="size-5" />Affiliate langsung
                                    50%
                                </p>
                            </div>
                            <Link
                                href="/checkout?package=premium"
                                class="featured-button mt-9 min-h-14 w-full justify-center"
                            >
                                Pilih Premium
                            </Link>
                        </article>
                    </div>

                    <p
                        class="mt-8 flex items-start gap-3 text-sm leading-6 text-[var(--muted)]"
                    >
                        <Mail class="mt-0.5 size-5 shrink-0" />Kod pendaftaran
                        dihantar selepas CHIP mengesahkan bayaran.
                    </p>
                </div>
            </section>
        </main>

        <footer class="marketing-footer">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-5 px-4 py-10 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8"
            >
                <div class="brand-link">
                    <span class="brand-mark">J</span>
                    <strong class="text-xl">JomKid</strong>
                </div>
                <p class="text-sm text-[var(--muted)]">
                    Game-first learning web app oleh Stwo Ventures.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.marketing-page {
    --page: #f7f8f4;
    --surface: #fdfefb;
    --surface-soft: #eef1f4;
    --ink: #16213a;
    --muted: #5d687b;
    --line: #dbe0e6;
    --accent: #d84d16;
    --accent-strong: #b83d0d;
    --accent-ink: #fff8f2;
    --sky: #dbeefa;
    color: var(--ink);
    background: var(--page);
}
.marketing-nav {
    position: relative;
    z-index: 20;
    background: color-mix(in srgb, var(--page) 92%, transparent);
    border-bottom: 1px solid var(--line);
    backdrop-filter: blur(16px);
}
.brand-link,
.button-primary,
.button-secondary,
.featured-button,
.nav-item {
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
.nav-item {
    min-width: 2.75rem;
    min-height: 2.75rem;
    justify-content: center;
    padding-inline: 0.25rem;
}
.nav-item:hover {
    color: var(--accent);
}
.button-primary,
.featured-button {
    border-radius: 999px;
    color: var(--accent-ink);
    background: var(--accent);
    font-weight: 900;
    transition:
        transform 240ms cubic-bezier(0.16, 1, 0.3, 1),
        background-color 240ms ease;
}
.button-primary:hover,
.featured-button:hover {
    transform: translateY(-2px);
    background: var(--accent-strong);
}
.button-primary:active,
.featured-button:active {
    transform: translateY(1px) scale(0.98);
}
.button-secondary {
    border: 1px solid var(--line);
    border-radius: 999px;
    color: var(--ink);
    background: var(--surface);
    font-weight: 900;
    transition:
        transform 240ms cubic-bezier(0.16, 1, 0.3, 1),
        border-color 240ms ease;
}
.button-secondary:hover {
    transform: translateY(-2px);
    border-color: var(--ink);
}
.hero-shell {
    background: var(--page);
}
.hero-eyebrow,
.pricing-eyebrow {
    color: var(--accent);
    font-size: 0.82rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.hero-title {
    max-width: 9ch;
    margin-top: 1rem;
    font-size: clamp(3.1rem, 6.2vw, 6rem);
    font-weight: 900;
    letter-spacing: -0.065em;
    line-height: 0.94;
}
.hero-copy {
    max-width: 36rem;
    margin-top: 1.5rem;
    color: var(--muted);
    font-size: clamp(1rem, 1.5vw, 1.2rem);
    font-weight: 600;
    line-height: 1.7;
}
.hero-figure,
.family-figure,
.world-figure {
    overflow: hidden;
    border-radius: 1.5rem;
    background: var(--surface-soft);
}
.hero-figure {
    height: min(72dvh, 680px);
}
.price-strip {
    color: var(--accent-ink);
    background: var(--accent);
}
.section-pad,
.world-section,
.pricing-section {
    padding-block: clamp(5rem, 9vw, 8rem);
}
.world-section {
    background: var(--surface);
}
.pricing-section {
    background: var(--surface-soft);
}
.section-title {
    max-width: 16ch;
    font-size: clamp(2.5rem, 5vw, 4.8rem);
    font-weight: 900;
    letter-spacing: -0.055em;
    line-height: 0.98;
}
.section-copy {
    max-width: 42rem;
    margin-top: 1.25rem;
    color: var(--muted);
    font-size: 1.05rem;
    line-height: 1.75;
}
.demo-panel,
.principle-panel,
.price-option {
    border-radius: 1.25rem;
    background: var(--surface);
}
.demo-panel {
    padding: clamp(1.5rem, 4vw, 2.5rem);
    border: 1px solid var(--line);
}
.activity-count {
    color: var(--muted);
    font-size: 0.8rem;
    font-weight: 800;
}
.sound-button {
    display: grid;
    width: 4rem;
    height: 4rem;
    margin-inline: auto;
    place-items: center;
    border-radius: 999px;
    color: var(--accent-ink);
    background: var(--accent);
    transition: transform 220ms cubic-bezier(0.16, 1, 0.3, 1);
}
.sound-button:active {
    transform: scale(0.96);
}
.letter-button {
    min-height: 6.5rem;
    border: 1px solid var(--line);
    border-radius: 1.25rem;
    color: var(--ink);
    background: var(--page);
    font-size: 2.5rem;
    font-weight: 900;
    transition:
        transform 220ms cubic-bezier(0.16, 1, 0.3, 1),
        border-color 220ms ease;
}
.letter-button:hover {
    transform: translateY(-3px);
    border-color: var(--accent);
}
.letter-button:active {
    transform: translateY(1px) scale(0.98);
}
.letter-correct {
    border-color: #2f855a;
    box-shadow: inset 0 0 0 2px #2f855a;
}
.letter-wrong {
    border-color: #bd3f32;
    box-shadow: inset 0 0 0 2px #bd3f32;
}
.feedback {
    display: flex;
    min-height: 4rem;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    border-radius: 1rem;
    padding: 1rem 1.25rem;
}
.feedback-success {
    color: #245d3c;
    background: #e3f2e8;
}
.feedback-error {
    color: #8e3026;
    background: #f8e4e0;
}
.principle-panel {
    padding: 1.75rem;
    border: 1px solid var(--line);
}
.principle-accent {
    color: var(--accent-ink);
    background: var(--accent);
    border-color: transparent;
}
.world-figure {
    aspect-ratio: 2.1 / 1;
}
.world-label {
    display: grid;
    gap: 0.35rem;
    padding: 1.2rem 1.35rem;
    border-left: 2px solid var(--line);
}
.world-label strong {
    font-size: 1.05rem;
}
.world-label span {
    color: var(--muted);
    font-size: 0.9rem;
}
.world-active {
    border-left-color: var(--accent);
}
.family-figure {
    aspect-ratio: 3 / 2;
}
.parent-fact {
    display: grid;
    gap: 0.35rem;
    padding-left: 1.1rem;
    border-left: 2px solid var(--accent);
}
.parent-fact span {
    color: var(--muted);
    font-size: 0.9rem;
}
.price-option {
    padding: clamp(1.5rem, 4vw, 2.5rem);
    border: 1px solid var(--line);
}
.price-featured {
    color: var(--accent-ink);
    background: var(--accent);
    border-color: transparent;
}
.price-featured .featured-button {
    color: var(--ink);
    background: var(--surface);
}
.marketing-footer {
    border-top: 1px solid var(--line);
    background: var(--surface);
}

@media (prefers-color-scheme: dark) {
    .marketing-page {
        --page: #111827;
        --surface: #172036;
        --surface-soft: #1d2942;
        --ink: #f1f4f8;
        --muted: #b2bdcd;
        --line: #33405a;
        --accent: #f06a32;
        --accent-strong: #ff7942;
        --accent-ink: #151a28;
        --sky: #243a52;
    }
    .hero-figure img,
    .family-figure img,
    .world-figure img {
        opacity: 0.92;
    }
    .feedback-success {
        color: #bce6c9;
        background: #1e4730;
    }
    .feedback-error {
        color: #ffd0c8;
        background: #512b28;
    }
}
@media (max-width: 767px) {
    .hero-title {
        max-width: 10ch;
        font-size: clamp(3rem, 15vw, 4.5rem);
    }
    .hero-copy {
        max-width: 32ch;
    }
    .hero-figure {
        height: 52dvh;
        min-height: 380px;
    }
    .world-figure {
        aspect-ratio: 1 / 1;
    }
    .family-figure {
        aspect-ratio: 1 / 1;
    }
}
@media (prefers-reduced-motion: no-preference) {
    .hero-figure {
        animation: hero-enter 700ms cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    .hero-title,
    .hero-copy,
    .hero-eyebrow {
        animation: copy-enter 620ms cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    .hero-copy {
        animation-delay: 80ms;
    }
}
@keyframes hero-enter {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.98);
    }
}
@keyframes copy-enter {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
}
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;
        transition-duration: 0.01ms !important;
        animation-duration: 0.01ms !important;
    }
}
</style>
