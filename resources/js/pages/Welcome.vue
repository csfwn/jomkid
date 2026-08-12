<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BarChart3,
    BookOpen,
    Check,
    ChevronRight,
    Headphones,
    Mail,
    MousePointer2,
    RotateCcw,
    Sparkles,
    Star,
    Users,
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

const activities = [
    {
        icon: Headphones,
        title: 'Dengar bunyi',
        copy: 'Anak dengar arahan pendek.',
        color: 'bg-[#DDF2FF]',
    },
    {
        icon: MousePointer2,
        title: 'Pilih jawapan',
        copy: 'Sentuh huruf atau gambar.',
        color: 'bg-[#FFF0B8]',
    },
    {
        icon: RotateCcw,
        title: 'Cuba semula',
        copy: 'Maklum balas diberi terus.',
        color: 'bg-[#FFE0D8]',
    },
    {
        icon: Star,
        title: 'Buka langkah baru',
        copy: 'Kemajuan disimpan per profil.',
        color: 'bg-[#E4F5E8]',
    },
];
</script>

<template>
    <Head title="JomKid, Belajar Bahasa Melayu Melalui Permainan">
        <meta
            name="description"
            content="JomKid ialah game-first web app untuk anak Malaysia. Main aktiviti JomABC dan pantau kemajuan anak."
        />
    </Head>

    <div class="min-h-screen overflow-x-clip bg-[#FFF9E8] text-[#17213B]">
        <header class="relative z-30 bg-[#FFF9E8]/95 backdrop-blur">
            <div
                class="mx-auto flex min-h-20 max-w-7xl items-center justify-between gap-4 px-5 lg:px-8"
            >
                <Link
                    href="/"
                    class="flex min-h-11 items-center gap-3 rounded-full focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#E0A800]"
                >
                    <span
                        class="grid size-11 place-items-center rounded-2xl bg-[#FFD84D] text-xl font-black shadow-[0_4px_0_#E0A800]"
                        >J</span
                    >
                    <span class="text-2xl font-black tracking-[-0.04em]"
                        >JomKid</span
                    >
                </Link>
                <nav
                    aria-label="Navigasi utama"
                    class="hidden items-center gap-8 text-sm font-bold md:flex"
                >
                    <a
                        href="#cara-main"
                        class="inline-flex min-h-11 items-center hover:text-[#B36A00]"
                        >Cara main</a
                    >
                    <a
                        href="#dunia"
                        class="inline-flex min-h-11 items-center hover:text-[#B36A00]"
                        >Dunia</a
                    >
                    <a
                        href="#ibu-bapa"
                        class="inline-flex min-h-11 items-center hover:text-[#B36A00]"
                        >Ibu bapa</a
                    >
                    <a
                        href="#pakej"
                        class="inline-flex min-h-11 items-center hover:text-[#B36A00]"
                        >Pakej</a
                    >
                </nav>
                <div class="flex items-center gap-2">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="
                            $page.props.auth.user.role === 'admin'
                                ? '/admin'
                                : '/dashboard'
                        "
                        class="inline-flex min-h-11 items-center rounded-full bg-[#17213B] px-5 text-sm font-black text-white focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#FFD84D]"
                        >Buka akaun</Link
                    >
                    <template v-else>
                        <Link
                            href="/login"
                            class="hidden min-h-11 items-center px-3 text-sm font-bold sm:inline-flex"
                            >Log masuk</Link
                        >
                        <Link
                            v-if="canRegister"
                            href="/checkout?package=basic"
                            class="inline-flex min-h-12 items-center rounded-full bg-[#FFD84D] px-5 text-sm font-black shadow-[0_4px_0_#E0A800] transition hover:-translate-y-0.5 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#17213B]"
                            >Mula sekarang</Link
                        >
                    </template>
                </div>
            </div>
        </header>

        <main>
            <section class="relative">
                <div
                    class="absolute inset-x-0 top-0 h-[72%] rounded-b-[56px] bg-[#FFD84D] sm:rounded-b-[88px]"
                    aria-hidden="true"
                ></div>
                <div
                    class="relative mx-auto grid max-w-7xl gap-10 px-5 pt-10 pb-16 lg:grid-cols-[.88fr_1.12fr] lg:items-center lg:px-8 lg:pt-16 lg:pb-24"
                >
                    <div class="max-w-xl">
                        <p
                            class="inline-flex min-h-10 items-center gap-2 rounded-full bg-white/80 px-4 text-sm font-black text-[#845400]"
                        >
                            <Sparkles class="size-4" /> GAME BAHASA MELAYU
                        </p>
                        <h1
                            class="mt-6 text-[clamp(3.2rem,6vw,6.5rem)] leading-[.9] font-black tracking-[-0.065em]"
                        >
                            Belajar bila<br /><span
                                class="text-white drop-shadow-[0_3px_0_#B36A00]"
                                >anak bermain.</span
                            >
                        </h1>
                        <p
                            class="mt-7 max-w-lg text-lg leading-8 font-semibold text-[#3A4055] sm:text-xl"
                        >
                            Aktiviti pendek JomABC mengajak anak dengar, sentuh
                            dan cuba semula. Ibu bapa pula boleh melihat
                            kemajuan setiap profil.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            <Link
                                href="/checkout?package=basic"
                                class="inline-flex min-h-15 items-center gap-3 rounded-full bg-[#17213B] px-7 font-black text-white shadow-[0_6px_0_#65708E] transition hover:-translate-y-1 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-white"
                            >
                                Mulakan JomABC <ArrowRight class="size-5" />
                            </Link>
                            <p class="text-sm font-bold">
                                Dari <strong class="text-lg">RM69</strong
                                ><br /><span class="font-medium"
                                    >sekali bayar</span
                                >
                            </p>
                        </div>
                    </div>

                    <article
                        aria-label="Demo permainan JomABC"
                        class="relative mx-auto w-full max-w-2xl rounded-[36px] bg-white p-5 shadow-[0_22px_70px_rgba(51,44,18,.18)] sm:p-8"
                    >
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="grid size-11 place-items-center rounded-2xl bg-[#DDF2FF] text-[#2075A5]"
                                    ><Volume2 class="size-5"
                                /></span>
                                <div>
                                    <p
                                        class="text-xs font-black text-[#65708E]"
                                    >
                                        JOMABC · AKTIVITI 1
                                    </p>
                                    <h2 class="text-xl font-black">
                                        Cari bunyi M
                                    </h2>
                                </div>
                            </div>
                            <div
                                class="flex gap-1.5"
                                aria-label="Langkah 1 daripada 3"
                            >
                                <span
                                    class="h-2 w-8 rounded-full bg-[#FFD84D]"
                                ></span
                                ><span
                                    class="h-2 w-4 rounded-full bg-[#E8EAF0]"
                                ></span
                                ><span
                                    class="h-2 w-4 rounded-full bg-[#E8EAF0]"
                                ></span>
                            </div>
                        </div>

                        <div
                            class="mt-7 rounded-[28px] bg-[#78C9FF] px-5 py-8 text-center sm:px-8 sm:py-10"
                        >
                            <button
                                type="button"
                                class="mx-auto grid min-h-16 min-w-16 place-items-center rounded-full bg-white text-[#2075A5] shadow-[0_5px_0_#3798D4] transition hover:-translate-y-1 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#17213B]"
                                :class="listening ? 'scale-110' : ''"
                                aria-label="Mainkan arahan bunyi"
                                @click="playPrompt"
                            >
                                <Volume2 class="size-7" />
                            </button>
                            <p class="mt-4 text-sm font-black text-[#174E72]">
                                Tekan untuk dengar
                            </p>
                            <h3 class="mt-6 text-2xl font-black text-white">
                                Huruf mana berbunyi “mmm”?
                            </h3>
                            <div class="mt-6 grid grid-cols-3 gap-3">
                                <button
                                    v-for="letter in ['N', 'M', 'B']"
                                    :key="letter"
                                    type="button"
                                    class="min-h-24 rounded-[24px] bg-white text-4xl font-black shadow-[0_6px_0_rgba(23,78,114,.32)] transition hover:-translate-y-1 focus-visible:outline-3 focus-visible:outline-offset-3 focus-visible:outline-[#FFD84D]"
                                    :class="
                                        answer === letter
                                            ? letter === 'M'
                                                ? 'ring-4 ring-[#4B9A67]'
                                                : 'ring-4 ring-[#E96E55]'
                                            : ''
                                    "
                                    @click="choose(letter)"
                                >
                                    {{ letter }}
                                </button>
                            </div>
                        </div>

                        <div aria-live="polite" class="mt-5 min-h-16">
                            <div
                                v-if="answer && correct"
                                class="flex items-center justify-between gap-4 rounded-2xl bg-[#E4F5E8] px-5 py-4 text-[#28653D]"
                            >
                                <p class="font-black">
                                    <Check class="mr-2 inline size-5" />Betul!
                                    Ini huruf M.
                                </p>
                                <span class="text-2xl">★</span>
                            </div>
                            <div
                                v-else-if="answer"
                                class="flex items-center justify-between gap-4 rounded-2xl bg-[#FFE0D8] px-5 py-4 text-[#9C3E2B]"
                            >
                                <p class="font-black">
                                    Hampir! Dengar sekali lagi.
                                </p>
                                <button
                                    type="button"
                                    class="inline-flex min-h-11 items-center gap-2 rounded-full bg-white px-4 text-sm font-black"
                                    @click="reset"
                                >
                                    <RotateCcw class="size-4" /> Ulang
                                </button>
                            </div>
                            <p
                                v-else
                                class="py-4 text-center text-sm font-semibold text-[#65708E]"
                            >
                                Pilih satu huruf untuk mencuba demo.
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section
                id="cara-main"
                class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28"
            >
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-sm font-black text-[#B36A00]">
                        SATU SESI, EMPAT LANGKAH
                    </p>
                    <h2
                        class="mt-3 text-4xl leading-tight font-black tracking-[-0.045em] sm:text-5xl"
                    >
                        Mudah difahami oleh anak.
                    </h2>
                    <p class="mt-5 text-lg leading-8 text-[#65708E]">
                        Setiap aktiviti fokus pada satu arahan supaya anak tahu
                        apa yang perlu dibuat seterusnya.
                    </p>
                </div>
                <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <article
                        v-for="(item, index) in activities"
                        :key="item.title"
                        class="rounded-[28px] p-6"
                        :class="item.color"
                    >
                        <span
                            class="grid size-12 place-items-center rounded-2xl bg-white"
                            ><component :is="item.icon" class="size-5"
                        /></span>
                        <p class="mt-8 text-sm font-black text-[#65708E]">
                            0{{ index + 1 }}
                        </p>
                        <h3 class="mt-2 text-xl font-black">
                            {{ item.title }}
                        </h3>
                        <p class="mt-2 leading-7 text-[#4D566E]">
                            {{ item.copy }}
                        </p>
                    </article>
                </div>
            </section>

            <section id="dunia" class="bg-white py-20 lg:py-28">
                <div
                    class="mx-auto grid max-w-7xl gap-12 px-5 lg:grid-cols-[.8fr_1.2fr] lg:items-center lg:px-8"
                >
                    <div>
                        <p class="text-sm font-black text-[#B36A00]">
                            DUNIA JOMKID
                        </p>
                        <h2
                            class="mt-3 text-4xl leading-tight font-black tracking-[-0.045em] sm:text-5xl"
                        >
                            Mula dengan huruf dan bunyi.
                        </h2>
                        <p class="mt-5 text-lg leading-8 text-[#65708E]">
                            JomABC dibuka dahulu. JomMengaji dan JomMengira akan
                            menyusul selepas pengalaman setiap dunia siap dibina
                            dan diuji.
                        </p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <article
                            class="rounded-[32px] bg-[#FFD84D] p-6 shadow-[0_10px_30px_rgba(224,168,0,.18)]"
                        >
                            <span
                                class="grid size-16 place-items-center rounded-full bg-white text-3xl font-black"
                                >A</span
                            >
                            <p class="mt-10 text-xs font-black text-[#845400]">
                                SEDIA DAHULU
                            </p>
                            <h3 class="mt-2 text-2xl font-black">JomABC</h3>
                            <p class="mt-2 leading-7">
                                Huruf, bunyi dan perkataan mudah.
                            </p>
                        </article>
                        <article class="rounded-[32px] bg-[#F2EEFF] p-6">
                            <span
                                class="grid size-16 place-items-center rounded-full bg-white text-3xl font-black"
                                >ا</span
                            >
                            <p class="mt-10 text-xs font-black text-[#6A58A8]">
                                AKAN DATANG
                            </p>
                            <h3 class="mt-2 text-2xl font-black">JomMengaji</h3>
                            <p class="mt-2 leading-7 text-[#65708E]">
                                Pengenalan huruf dan bunyi.
                            </p>
                        </article>
                        <article class="rounded-[32px] bg-[#E4F5E8] p-6">
                            <span
                                class="grid size-16 place-items-center rounded-full bg-white text-3xl font-black"
                                >1</span
                            >
                            <p class="mt-10 text-xs font-black text-[#3E7D52]">
                                AKAN DATANG
                            </p>
                            <h3 class="mt-2 text-2xl font-black">JomMengira</h3>
                            <p class="mt-2 leading-7 text-[#65708E]">
                                Nombor dan operasi asas.
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="ibu-bapa"
                class="mx-auto grid max-w-7xl gap-12 px-5 py-20 lg:grid-cols-2 lg:items-center lg:px-8 lg:py-28"
            >
                <div
                    class="order-2 rounded-[36px] bg-[#17213B] p-7 text-white shadow-[0_18px_60px_rgba(23,33,59,.18)] sm:p-9 lg:order-1"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-[#AEB6CA]">
                                PROFIL ANAK
                            </p>
                            <h3 class="mt-1 text-2xl font-black">
                                Alya · JomABC
                            </h3>
                        </div>
                        <span
                            class="grid size-12 place-items-center rounded-full bg-[#FFD84D] font-black text-[#17213B]"
                            >A</span
                        >
                    </div>
                    <div class="mt-8 rounded-[26px] bg-white/10 p-6">
                        <div class="flex justify-between text-sm font-bold">
                            <span>Aktiviti semasa</span><span>Huruf M</span>
                        </div>
                        <div class="mt-4 h-3 rounded-full bg-white/15">
                            <div
                                class="h-full w-2/3 rounded-full bg-[#FFD84D]"
                            ></div>
                        </div>
                        <p class="mt-4 text-sm text-[#C8CEDE]">
                            Seterusnya: ulang bunyi B
                        </p>
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-4">
                        <div
                            class="rounded-[22px] bg-[#78C9FF] p-5 text-[#173F59]"
                        >
                            <BarChart3 class="size-5" />
                            <p class="mt-5 text-sm font-bold">
                                Kemajuan aktiviti
                            </p>
                        </div>
                        <div
                            class="rounded-[22px] bg-[#FF8F78] p-5 text-[#692C20]"
                        >
                            <Users class="size-5" />
                            <p class="mt-5 text-sm font-bold">
                                Profil berasingan
                            </p>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <p class="text-sm font-black text-[#B36A00]">
                        UNTUK IBU BAPA
                    </p>
                    <h2
                        class="mt-3 text-4xl leading-tight font-black tracking-[-0.045em] sm:text-5xl"
                    >
                        Anak nampak permainan. Anda nampak kemajuan.
                    </h2>
                    <p class="mt-5 text-lg leading-8 text-[#65708E]">
                        Setiap profil menyimpan aktiviti dan topik yang perlu
                        diulang. Basic menyokong sehingga 3 profil; Premium
                        tanpa had.
                    </p>
                </div>
            </section>

            <section id="pakej" class="bg-[#FFD84D] py-20 lg:py-28">
                <div class="mx-auto max-w-6xl px-5 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="text-sm font-black text-[#845400]">
                            AKSES LIFETIME
                        </p>
                        <h2
                            class="mt-3 text-4xl font-black tracking-[-0.045em] sm:text-5xl"
                        >
                            Bayar sekali. Pilih ikut keluarga.
                        </h2>
                    </div>
                    <div class="mt-12 grid gap-5 md:grid-cols-2">
                        <article class="rounded-[32px] bg-white p-7 sm:p-9">
                            <p class="text-sm font-black text-[#65708E]">
                                BASIC
                            </p>
                            <div class="mt-3 flex items-end gap-2">
                                <strong class="text-5xl font-black">RM69</strong
                                ><span class="pb-1 font-semibold text-[#65708E]"
                                    >lifetime</span
                                >
                            </div>
                            <ul class="mt-7 space-y-3 font-semibold">
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 text-[#4B9A67]"
                                    />Maksimum 3 profil anak
                                </li>
                                <li class="flex gap-3">
                                    <Check class="size-5 text-[#4B9A67]" />Akses
                                    pembelajaran lifetime
                                </li>
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 text-[#4B9A67]"
                                    />Laporan kemajuan ibu bapa
                                </li>
                            </ul>
                            <Link
                                href="/checkout?package=basic"
                                class="mt-8 inline-flex min-h-14 w-full items-center justify-center gap-2 rounded-full bg-[#17213B] px-6 font-black text-white"
                                >Pilih Basic <ChevronRight class="size-5"
                            /></Link>
                        </article>
                        <article
                            class="rounded-[32px] bg-[#17213B] p-7 text-white sm:p-9"
                        >
                            <p class="text-sm font-black text-[#FFD84D]">
                                PREMIUM + RESELLER
                            </p>
                            <div class="mt-3 flex items-end gap-2">
                                <strong class="text-5xl font-black">RM99</strong
                                ><span class="pb-1 font-semibold text-[#C8CEDE]"
                                    >lifetime</span
                                >
                            </div>
                            <ul class="mt-7 space-y-3 font-semibold">
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 text-[#FFD84D]"
                                    />Profil anak tanpa had
                                </li>
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 text-[#FFD84D]"
                                    />Reseller license
                                </li>
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 text-[#FFD84D]"
                                    />Affiliate langsung 50%
                                </li>
                            </ul>
                            <Link
                                href="/checkout?package=premium"
                                class="mt-8 inline-flex min-h-14 w-full items-center justify-center gap-2 rounded-full bg-[#FFD84D] px-6 font-black text-[#17213B]"
                                >Pilih Premium <ChevronRight class="size-5"
                            /></Link>
                        </article>
                    </div>
                    <div
                        class="mt-8 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-sm font-semibold text-[#53451A]"
                    >
                        <span class="flex items-center gap-2"
                            ><Mail class="size-4" />Kod dihantar selepas bayaran
                            disahkan</span
                        ><span class="flex items-center gap-2"
                            ><BookOpen class="size-4" />Daftar menggunakan kod
                            sekali guna</span
                        >
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-[#17213B] py-10 text-white">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-5 px-5 sm:flex-row sm:items-center sm:justify-between lg:px-8"
            >
                <div class="flex items-center gap-3">
                    <span
                        class="grid size-10 place-items-center rounded-2xl bg-[#FFD84D] font-black text-[#17213B]"
                        >J</span
                    ><strong class="text-xl">JomKid</strong>
                </div>
                <p class="text-sm text-[#AEB6CA]">
                    Game-first learning web app oleh Stwo Ventures.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
html {
    scroll-behavior: smooth;
}
a,
button {
    -webkit-tap-highlight-color: transparent;
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
