<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    AudioLines,
    BadgeDollarSign,
    BarChart3,
    Check,
    ChevronRight,
    CircleCheck,
    Cloud,
    Gamepad2,
    Grip,
    KeyRound,
    Mic2,
    MousePointer2,
    Puzzle,
    RotateCcw,
    ShieldCheck,
    Smartphone,
    Sparkles,
    Star,
    Trophy,
    Users,
} from '@lucide/vue';
import { ref } from 'vue';

defineProps<{ canRegister: boolean }>();

const answer = ref<string | null>(null);
const playSound = ref(false);
const chooseLetter = (letter: string) => {
    answer.value = letter;
};
const replayPrompt = () => {
    playSound.value = true;
    window.setTimeout(() => (playSound.value = false), 650);
};
const resetGame = () => {
    answer.value = null;
};

const gameModes = [
    {
        icon: AudioLines,
        name: 'Dengar & Pilih',
        copy: 'Kenal bunyi, kemudian pilih huruf atau gambar yang sepadan.',
        color: 'bg-[#7dd3fc]',
        marker: 'BUNYI',
    },
    {
        icon: Grip,
        name: 'Seret & Padankan',
        copy: 'Padankan huruf dengan bentuk dan perkataan menggunakan sentuhan.',
        color: 'bg-[#f1c84b]',
        marker: 'PADAN',
    },
    {
        icon: Mic2,
        name: 'Sebut Bersama',
        copy: 'Ikut sebut bunyi dan perkataan dalam sesi latihan pendek.',
        color: 'bg-[#ff9f97]',
        marker: 'SUARA',
    },
    {
        icon: Puzzle,
        name: 'Susun Perkataan',
        copy: 'Susun huruf mengikut turutan untuk membina perkataan mudah.',
        color: 'bg-[#a7e8bd]',
        marker: 'SUSUN',
    },
];
</script>

<template>
    <Head title="JomKid, Belajar Bahasa Melayu Melalui Permainan">
        <meta
            name="description"
            content="JomKid ialah game-first web app untuk anak Malaysia. Mulakan dengan permainan interaktif JomABC dan pantau kemajuan anak."
        />
    </Head>

    <div class="min-h-screen overflow-x-clip bg-[#fff9ed] text-[#17203a]">
        <header class="relative z-20 border-b-2 border-[#17203a] bg-[#fff9ed]">
            <div
                class="mx-auto flex min-h-18 max-w-7xl items-center justify-between gap-4 px-5 py-3 lg:px-8"
            >
                <Link
                    href="/"
                    class="flex min-h-11 items-center gap-3 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#9a5b00]"
                >
                    <span
                        class="grid size-10 place-items-center rounded-[14px_14px_14px_4px] border-2 border-[#17203a] bg-[#f6c945] font-black"
                        >J</span
                    >
                    <span class="text-xl font-black tracking-[-0.04em]"
                        >JomKid</span
                    >
                </Link>

                <nav
                    aria-label="Navigasi utama"
                    class="hidden items-center gap-7 text-sm font-black md:flex"
                >
                    <a href="#permainan" class="nav-link">Permainan</a>
                    <a href="#dunia" class="nav-link">Dunia JomKid</a>
                    <a href="#ibu-bapa" class="nav-link">Ibu bapa</a>
                    <a href="#pakej" class="nav-link">Pakej</a>
                </nav>

                <div class="flex items-center gap-2">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="
                            $page.props.auth.user.role === 'admin'
                                ? '/admin'
                                : '/dashboard'
                        "
                        class="inline-flex min-h-11 items-center rounded-[15px_15px_15px_5px] border-2 border-[#17203a] bg-[#17203a] px-5 text-sm font-black text-white focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#ff7369]"
                    >
                        Buka akaun
                    </Link>
                    <template v-else>
                        <Link
                            href="/login"
                            class="hidden min-h-11 items-center px-3 text-sm font-black hover:text-[#9a5b00] focus-visible:outline-3 sm:inline-flex"
                            >Log masuk</Link
                        >
                        <Link
                            v-if="canRegister"
                            href="/checkout"
                            class="inline-flex min-h-11 items-center rounded-[15px_15px_15px_5px] border-2 border-[#17203a] bg-[#17203a] px-5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#9a5b00] focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#ff7369]"
                            >Mula bermain</Link
                        >
                    </template>
                </div>
            </div>
        </header>

        <main>
            <section class="relative border-b-2 border-[#17203a] bg-[#f6c945]">
                <div
                    class="absolute top-8 left-[8%] size-8 rotate-12 border-4 border-[#17203a] bg-[#f1c84b]"
                    aria-hidden="true"
                ></div>
                <div
                    class="absolute right-[5%] bottom-10 size-10 rounded-full border-4 border-[#17203a] bg-[#ff7369]"
                    aria-hidden="true"
                ></div>
                <div
                    class="relative mx-auto grid max-w-7xl gap-12 px-5 py-10 sm:py-14 lg:grid-cols-[.92fr_1.08fr] lg:items-center lg:px-8 lg:py-20"
                >
                    <div class="relative z-10">
                        <p
                            class="inline-flex min-h-10 items-center gap-2 rounded-full border-2 border-[#17203a] bg-[#fff9ed] px-4 text-sm font-black"
                        >
                            <Gamepad2 class="size-5 text-[#9a5b00]" /> WEB APP
                            GAME-FIRST UNTUK ANAK
                        </p>
                        <h1
                            class="mt-5 max-w-3xl text-[clamp(3.25rem,7vw,6.9rem)] leading-[0.86] font-black tracking-[-0.07em] sm:mt-6"
                        >
                            Main.<br />Cuba.<br /><span
                                class="relative inline-block text-[#9a5b00]"
                                >Pandai!<span
                                    class="absolute -top-3 -right-7 text-3xl text-[#ff7369] sm:text-5xl"
                                    >✦</span
                                ></span
                            >
                        </h1>
                        <p
                            class="mt-6 max-w-xl text-lg leading-8 font-semibold text-[#303954] sm:mt-8 sm:text-xl"
                        >
                            JomKid mengubah pembelajaran Bahasa Melayu menjadi
                            permainan pendek yang anak boleh dengar, sentuh,
                            susun dan cuba semula.
                        </p>
                        <div
                            class="mt-6 flex flex-wrap items-center gap-5 sm:mt-8"
                        >
                            <Link
                                href="/checkout?package=basic"
                                class="inline-flex min-h-15 items-center gap-3 rounded-[20px_20px_20px_6px] border-3 border-[#17203a] bg-[#17203a] px-7 text-base font-black text-white transition hover:-translate-y-1 hover:bg-[#9a5b00] focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#ff7369]"
                            >
                                Mulakan dengan JomABC
                                <ChevronRight class="size-5" />
                            </Link>
                            <p class="text-sm leading-6 font-black">
                                RM69 lifetime<br /><span
                                    class="font-semibold text-[#38435f]"
                                    >Web app, beli sekali</span
                                >
                            </p>
                        </div>
                    </div>

                    <div class="relative mx-auto w-full max-w-xl">
                        <div
                            class="absolute -right-3 -bottom-3 h-full w-full rounded-[34px_34px_34px_10px] border-3 border-[#17203a] bg-[#ff7369]"
                        ></div>
                        <article
                            aria-label="Mini permainan JomABC yang boleh dicuba"
                            class="relative rounded-[34px_34px_34px_10px] border-3 border-[#17203a] bg-white p-5 sm:p-7"
                        >
                            <div
                                class="flex items-center justify-between gap-4"
                            >
                                <div>
                                    <p
                                        class="text-xs font-black text-[#9a5b00]"
                                    >
                                        CUBA SEKARANG
                                    </p>
                                    <h2 class="mt-1 text-xl font-black">
                                        Bunyi misteri
                                    </h2>
                                </div>
                                <div
                                    class="flex gap-1"
                                    aria-label="Kemajuan 1 daripada 3"
                                >
                                    <span class="h-2 w-8 bg-[#9a5b00]"></span>
                                    <span class="h-2 w-8 bg-[#d8dbe5]"></span>
                                    <span class="h-2 w-8 bg-[#d8dbe5]"></span>
                                </div>
                            </div>

                            <div
                                class="mt-7 rounded-[24px_24px_24px_7px] bg-[#e8f8ff] p-5 sm:p-7"
                            >
                                <p
                                    class="text-center text-xl font-black sm:text-2xl"
                                >
                                    Pilih huruf yang berbunyi “mmm”
                                </p>
                                <button
                                    type="button"
                                    class="mx-auto mt-5 grid size-16 place-items-center rounded-full border-3 border-[#17203a] bg-[#f1c84b] transition hover:scale-105 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#9a5b00]"
                                    aria-label="Mainkan arahan bunyi"
                                    @click="replayPrompt"
                                >
                                    <AudioLines
                                        class="size-7"
                                        :class="playSound ? 'sound-pulse' : ''"
                                    />
                                </button>
                                <div class="mt-7 grid grid-cols-3 gap-3">
                                    <button
                                        v-for="letter in ['N', 'M', 'B']"
                                        :key="letter"
                                        type="button"
                                        class="grid min-h-22 place-items-center rounded-[20px_20px_20px_6px] border-3 border-[#17203a] text-4xl font-black transition hover:-translate-y-1 focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[#9a5b00]"
                                        :class="[
                                            answer === letter && letter === 'M'
                                                ? 'bg-[#a7e8bd]'
                                                : answer === letter
                                                  ? 'bg-[#ffaaa3]'
                                                  : 'bg-white',
                                        ]"
                                        @click="chooseLetter(letter)"
                                    >
                                        {{ letter }}
                                    </button>
                                </div>
                            </div>

                            <div
                                v-if="answer"
                                aria-live="polite"
                                class="mt-4 flex min-h-14 items-center gap-3 rounded-[17px_17px_17px_5px] border-2 border-[#17203a] p-4 font-black"
                                :class="
                                    answer === 'M'
                                        ? 'bg-[#a7e8bd]'
                                        : 'bg-[#ffddd9]'
                                "
                            >
                                <CircleCheck
                                    v-if="answer === 'M'"
                                    class="size-5 shrink-0"
                                />
                                <RotateCcw v-else class="size-5 shrink-0" />
                                <span>{{
                                    answer === 'M'
                                        ? 'Tepat! Ini huruf M.'
                                        : 'Belum tepat. Cuba sekali lagi.'
                                }}</span>
                                <button
                                    v-if="answer !== 'M'"
                                    type="button"
                                    class="ml-auto min-h-11 underline underline-offset-4"
                                    @click="resetGame"
                                >
                                    Ulang
                                </button>
                            </div>
                            <p
                                v-else
                                class="mt-4 text-center text-sm font-semibold text-[#59627a]"
                            >
                                Tekan satu huruf untuk menjawab.
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="permainan"
                class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28"
            >
                <div
                    class="grid gap-10 lg:grid-cols-[.65fr_1.35fr] lg:items-end"
                >
                    <div>
                        <p class="text-sm font-black text-[#e0443b]">
                            CARA ANAK BERMAIN
                        </p>
                        <h2
                            class="mt-3 text-4xl leading-[.98] font-black tracking-[-0.055em] sm:text-6xl"
                        >
                            Bukan tekan “next” sahaja.
                        </h2>
                    </div>
                    <p
                        class="max-w-xl text-lg leading-8 text-[#59627a] lg:justify-self-end"
                    >
                        Setiap format meminta respons berbeza. Anak bergerak,
                        mendengar dan membuat keputusan dalam sesi yang pendek.
                    </p>
                </div>

                <div
                    class="mt-12 grid border-3 border-[#17203a] md:grid-cols-2"
                >
                    <article
                        v-for="(game, index) in gameModes"
                        :key="game.name"
                        class="group relative min-h-72 p-6 sm:p-8"
                        :class="[
                            game.color,
                            index % 2 === 0
                                ? 'md:border-r-3 md:border-[#17203a]'
                                : '',
                            index < 2
                                ? 'border-b-3 border-[#17203a]'
                                : index === 2
                                  ? 'border-b-3 border-[#17203a] md:border-b-0'
                                  : '',
                        ]"
                    >
                        <div class="flex items-start justify-between gap-5">
                            <span
                                class="grid size-15 place-items-center rounded-[18px_18px_18px_5px] border-3 border-[#17203a] bg-white transition group-hover:scale-105 group-hover:-rotate-3"
                            >
                                <component :is="game.icon" class="size-7" />
                            </span>
                            <span class="text-xs font-black">{{
                                game.marker
                            }}</span>
                        </div>
                        <h3
                            class="mt-10 text-3xl font-black tracking-[-0.04em]"
                        >
                            {{ game.name }}
                        </h3>
                        <p
                            class="mt-3 max-w-md leading-7 font-semibold text-[#35405b]"
                        >
                            {{ game.copy }}
                        </p>
                    </article>
                </div>
                <p class="mt-5 text-sm font-semibold text-[#59627a]">
                    Format permainan dilancarkan secara berperingkat dalam
                    JomABC.
                </p>
            </section>

            <section
                id="dunia"
                class="border-y-3 border-[#17203a] bg-[#f6c945] text-[#17203a]"
            >
                <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-24">
                    <div class="max-w-3xl">
                        <p class="text-sm font-black text-[#9a5b00]">
                            PETA DUNIA JOMKID
                        </p>
                        <h2
                            class="mt-3 text-4xl leading-[.98] font-black tracking-[-0.055em] sm:text-6xl"
                        >
                            Satu dunia dahulu. Lebih banyak menyusul.
                        </h2>
                        <p
                            class="mt-5 max-w-2xl text-lg leading-8 text-[#51472e]"
                        >
                            Kami bermula dengan JomABC supaya pengalaman huruf,
                            bunyi dan perkataan dapat dibina dengan baik sebelum
                            dunia pembelajaran lain dibuka.
                        </p>
                    </div>

                    <div
                        class="relative mt-14 grid gap-8 lg:grid-cols-3 lg:items-center"
                    >
                        <div
                            class="absolute top-1/2 left-[15%] hidden h-1 w-[70%] -translate-y-1/2 border-t-4 border-dashed border-[#f1c84b] lg:block"
                        ></div>
                        <article
                            class="relative z-10 rotate-[-1deg] rounded-[30px_30px_30px_8px] border-3 border-[#17203a] bg-[#7dd3fc] p-7 text-[#17203a]"
                        >
                            <div class="flex items-center justify-between">
                                <span
                                    class="grid size-14 place-items-center rounded-full border-3 border-[#17203a] bg-white text-2xl font-black"
                                    >A</span
                                >
                                <span
                                    class="rounded-full bg-[#17203a] px-4 py-2 text-xs font-black text-white"
                                    >DIBUKA PERTAMA</span
                                >
                            </div>
                            <h3 class="mt-10 text-4xl font-black">JomABC</h3>
                            <p class="mt-3 leading-7 font-semibold">
                                Huruf, bunyi, suku kata dan perkataan asas
                                melalui permainan.
                            </p>
                        </article>
                        <article
                            class="relative z-10 rounded-[30px_30px_30px_8px] border-3 border-[#17203a] bg-[#f1c84b] p-7 text-[#17203a] lg:translate-y-8"
                        >
                            <div class="flex items-center justify-between">
                                <span
                                    class="grid size-14 place-items-center rounded-full border-3 border-[#17203a] bg-white text-2xl font-black"
                                    >ا</span
                                >
                                <span class="text-xs font-black"
                                    >AKAN DATANG</span
                                >
                            </div>
                            <h3 class="mt-10 text-4xl font-black">
                                JomMengaji
                            </h3>
                            <p class="mt-3 leading-7 font-semibold">
                                Dunia pembelajaran mengaji sedang dalam
                                perancangan.
                            </p>
                        </article>
                        <article
                            class="relative z-10 rotate-[1deg] rounded-[30px_30px_30px_8px] border-3 border-[#17203a] bg-[#ff9f97] p-7 text-[#17203a]"
                        >
                            <div class="flex items-center justify-between">
                                <span
                                    class="grid size-14 place-items-center rounded-full border-3 border-[#17203a] bg-white text-2xl font-black"
                                    >1</span
                                >
                                <span class="text-xs font-black"
                                    >AKAN DATANG</span
                                >
                            </div>
                            <h3 class="mt-10 text-4xl font-black">
                                JomMengira
                            </h3>
                            <p class="mt-3 leading-7 font-semibold">
                                Dunia nombor dan kiraan asas sedang dalam
                                perancangan.
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="ibu-bapa"
                class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28"
            >
                <div
                    class="grid gap-12 lg:grid-cols-[.9fr_1.1fr] lg:items-center"
                >
                    <div>
                        <p class="text-sm font-black text-[#e0443b]">
                            UNTUK IBU BAPA
                        </p>
                        <h2
                            class="mt-3 text-4xl leading-[.98] font-black tracking-[-0.055em] sm:text-6xl"
                        >
                            Anak nampak permainan. Anda nampak kemajuan.
                        </h2>
                        <p
                            class="mt-6 max-w-xl text-lg leading-8 text-[#59627a]"
                        >
                            Setiap anak menggunakan profil sendiri. Aktiviti,
                            cubaan dan topik yang perlu diulang disusun untuk
                            semakan ibu bapa.
                        </p>
                        <div class="mt-8 grid gap-5 sm:grid-cols-2">
                            <div class="border-l-4 border-[#9a5b00] pl-4">
                                <p class="font-black">Profil berasingan</p>
                                <p
                                    class="mt-2 text-sm leading-6 text-[#59627a]"
                                >
                                    Basic sehingga 3 anak. Premium tanpa had.
                                </p>
                            </div>
                            <div class="border-l-4 border-[#ff7369] pl-4">
                                <p class="font-black">Kawalan parent</p>
                                <p
                                    class="mt-2 text-sm leading-6 text-[#59627a]"
                                >
                                    Profil anak kekal di bawah akaun ibu bapa.
                                </p>
                            </div>
                        </div>
                    </div>

                    <article class="relative">
                        <div
                            class="absolute -right-3 -bottom-3 h-full w-full rounded-[30px_30px_30px_8px] border-3 border-[#17203a] bg-[#a7e8bd]"
                        ></div>
                        <div
                            class="relative rounded-[30px_30px_30px_8px] border-3 border-[#17203a] bg-white p-5 sm:p-7"
                        >
                            <div
                                class="flex items-center justify-between gap-4 border-b-3 border-[#17203a] pb-5"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="grid size-12 place-items-center rounded-full bg-[#f1c84b] text-xl font-black"
                                        >B</span
                                    >
                                    <div>
                                        <p
                                            class="text-xs font-black text-[#9a5b00]"
                                        >
                                            PROFIL ANAK
                                        </p>
                                        <p class="text-xl font-black">
                                            Bintang
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="rounded-full bg-[#e8f8ff] px-4 py-2 text-xs font-black"
                                    >JomABC</span
                                >
                            </div>
                            <div
                                class="mt-6 grid gap-4 sm:grid-cols-[1fr_160px]"
                            >
                                <div
                                    class="rounded-[22px_22px_22px_6px] bg-[#f4f1ff] p-5"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <p class="font-black">Laluan bunyi</p>
                                        <Trophy class="size-5 text-[#9a5b00]" />
                                    </div>
                                    <div class="mt-6 flex items-center gap-2">
                                        <span
                                            class="grid size-10 place-items-center rounded-full bg-[#9a5b00] font-black text-white"
                                            >M</span
                                        >
                                        <span
                                            class="h-1 flex-1 bg-[#9a5b00]"
                                        ></span>
                                        <span
                                            class="grid size-10 place-items-center rounded-full border-2 border-[#17203a] bg-white font-black"
                                            >B</span
                                        >
                                        <span
                                            class="h-1 flex-1 bg-[#d8dbe5]"
                                        ></span>
                                        <span
                                            class="grid size-10 place-items-center rounded-full border-2 border-[#d8dbe5] bg-white font-black text-[#7a8192]"
                                            >S</span
                                        >
                                    </div>
                                    <p
                                        class="mt-5 text-sm font-semibold text-[#59627a]"
                                    >
                                        Topik seterusnya: bunyi huruf B
                                    </p>
                                </div>
                                <div
                                    class="rounded-[22px_22px_22px_6px] bg-[#f1c84b] p-5"
                                >
                                    <BarChart3 class="size-6" />
                                    <p class="mt-7 text-4xl font-black">3/4</p>
                                    <p class="mt-1 text-sm font-black">
                                        aktiviti selesai
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <section class="border-y-3 border-[#17203a] bg-[#a7e8bd]">
                <div
                    class="mx-auto grid max-w-7xl gap-10 px-5 py-16 lg:grid-cols-[.8fr_1.2fr] lg:items-center lg:px-8 lg:py-20"
                >
                    <div class="relative mx-auto">
                        <div
                            class="h-[290px] w-[165px] rounded-[30px] border-4 border-[#17203a] bg-white p-3"
                        >
                            <div class="h-full rounded-[20px] bg-[#7dd3fc] p-3">
                                <div
                                    class="mx-auto h-1.5 w-14 rounded-full bg-[#17203a]"
                                ></div>
                                <div class="mt-8 grid place-items-center">
                                    <div
                                        class="grid grid-cols-2 gap-2"
                                        aria-hidden="true"
                                    >
                                        <span
                                            class="grid size-14 place-items-center rounded-[16px_16px_16px_5px] border-3 border-[#17203a] bg-white text-2xl font-black"
                                            >A</span
                                        >
                                        <span
                                            class="grid size-14 place-items-center rounded-[16px_16px_16px_5px] border-3 border-[#17203a] bg-[#ff9f97] text-2xl font-black"
                                            >B</span
                                        >
                                        <span
                                            class="col-span-2 grid min-h-12 place-items-center rounded-[16px_16px_16px_5px] border-3 border-[#17203a] bg-[#a7e8bd] text-2xl font-black"
                                            >C</span
                                        >
                                    </div>
                                    <p
                                        class="mt-5 text-center text-xl font-black"
                                    >
                                        Jom main!
                                    </p>
                                    <div
                                        class="mt-5 w-full rounded-[14px_14px_14px_4px] border-2 border-[#17203a] bg-[#f1c84b] py-3 text-center text-sm font-black"
                                    >
                                        Mula JomABC
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Sparkles
                            class="absolute -top-3 -right-10 size-10 text-[#9a5b00]"
                        />
                    </div>
                    <div>
                        <p class="text-sm font-black text-[#17633c]">
                            WEB APP DAHULU
                        </p>
                        <h2
                            class="mt-3 text-4xl leading-[.98] font-black tracking-[-0.055em] sm:text-6xl"
                        >
                            Buka terus melalui browser.
                        </h2>
                        <p
                            class="mt-6 max-w-2xl text-lg leading-8 text-[#354b43]"
                        >
                            JomKid dibina mobile-first dan boleh digunakan
                            melalui browser. Sokongan pemasangan PWA akan
                            ditambah selepas manifest, service worker dan
                            pengalaman offline selesai diuji.
                        </p>
                        <ul class="mt-7 grid gap-4 font-black sm:grid-cols-2">
                            <li class="flex items-center gap-3">
                                <Smartphone class="size-5" />Paparan
                                mobile-first
                            </li>
                            <li class="flex items-center gap-3">
                                <Cloud class="size-5" />Kemajuan disimpan ke
                                akaun
                            </li>
                            <li class="flex items-center gap-3">
                                <MousePointer2 class="size-5" />Sentuhan dan
                                klik
                            </li>
                            <li class="flex items-center gap-3">
                                <KeyRound class="size-5" />Akses melalui kod
                                pembelian
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <section
                id="pakej"
                class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28"
            >
                <div class="max-w-3xl">
                    <p class="text-sm font-black text-[#9a5b00]">
                        AKSES LIFETIME
                    </p>
                    <h2
                        class="mt-3 text-4xl leading-[.98] font-black tracking-[-0.055em] sm:text-6xl"
                    >
                        Pilih berapa ramai anak yang akan bermain.
                    </h2>
                </div>

                <div
                    class="mt-12 grid border-3 border-[#17203a] lg:grid-cols-2"
                >
                    <article
                        class="flex flex-col bg-white p-6 sm:p-9 lg:border-r-3 lg:border-[#17203a]"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-black text-[#9a5b00]">
                                    BASIC
                                </p>
                                <h3 class="mt-2 text-3xl font-black">
                                    Keluarga
                                </h3>
                            </div>
                            <div class="text-right">
                                <p class="text-5xl font-black">RM69</p>
                                <p class="text-sm font-semibold text-[#59627a]">
                                    sekali bayar
                                </p>
                            </div>
                        </div>
                        <ul class="mt-8 grid gap-4 text-sm font-black">
                            <li class="flex gap-3">
                                <Check
                                    class="size-5 shrink-0 text-[#9a5b00]"
                                />Maksimum 3 profil anak
                            </li>
                            <li class="flex gap-3">
                                <Gamepad2
                                    class="size-5 shrink-0 text-[#9a5b00]"
                                />Akses lifetime JomABC
                            </li>
                            <li class="flex gap-3">
                                <BarChart3
                                    class="size-5 shrink-0 text-[#9a5b00]"
                                />Kemajuan setiap profil
                            </li>
                            <li class="flex gap-3 text-[#72798b]">
                                <span class="w-5 text-center">×</span>Tiada
                                reseller atau affiliate
                            </li>
                        </ul>
                        <Link
                            href="/checkout?package=basic"
                            class="mt-9 inline-flex min-h-14 items-center justify-between border-t-3 border-[#17203a] pt-5 font-black text-[#9a5b00] focus-visible:outline-3 focus-visible:outline-offset-4"
                        >
                            <span>Pilih Basic</span><ChevronRight />
                        </Link>
                    </article>

                    <article
                        class="relative flex flex-col bg-[#f1c84b] p-6 sm:p-9"
                    >
                        <span
                            class="absolute top-0 right-5 -translate-y-1/2 rounded-full border-3 border-[#17203a] bg-[#ff7369] px-4 py-2 text-xs font-black text-white"
                            >RESELLER LICENSE</span
                        >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-black text-[#a62e27]">
                                    PREMIUM
                                </p>
                                <h3 class="mt-2 text-3xl font-black">
                                    Keluarga + Reseller
                                </h3>
                            </div>
                            <div class="text-right">
                                <p class="text-5xl font-black">RM99</p>
                                <p class="text-sm font-semibold">
                                    sekali bayar
                                </p>
                            </div>
                        </div>
                        <ul class="mt-8 grid gap-4 text-sm font-black">
                            <li class="flex gap-3">
                                <Users class="size-5 shrink-0" />Profil anak
                                tanpa had
                            </li>
                            <li class="flex gap-3">
                                <ShieldCheck class="size-5 shrink-0" />Reseller
                                license
                            </li>
                            <li class="flex gap-3">
                                <BadgeDollarSign class="size-5 shrink-0" />Link
                                affiliate peribadi
                            </li>
                            <li class="flex gap-3">
                                <Star class="size-5 shrink-0" />Komisen 50%
                                jualan langsung
                            </li>
                        </ul>
                        <Link
                            href="/checkout?package=premium"
                            class="mt-9 inline-flex min-h-14 items-center justify-between border-t-3 border-[#17203a] pt-5 font-black focus-visible:outline-3 focus-visible:outline-offset-4"
                        >
                            <span>Pilih Premium</span><ChevronRight />
                        </Link>
                    </article>
                </div>
                <p class="mt-5 text-sm font-semibold text-[#59627a]">
                    Beli sebelum daftar. Kod sekali guna dihantar selepas
                    bayaran CHIP disahkan.
                </p>
            </section>
        </main>

        <footer class="border-t-3 border-[#17203a] bg-white">
            <div
                class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-5 py-8 text-sm sm:flex-row sm:items-center lg:px-8"
            >
                <div class="flex items-center gap-3">
                    <span
                        class="grid size-10 place-items-center rounded-[14px_14px_14px_4px] border-2 border-[#17203a] bg-[#f6c945] font-black"
                        >J</span
                    >
                    <div>
                        <p class="font-black">JomKid</p>
                        <p class="text-[#59627a]">
                            Game-first learning web app oleh Stwo Ventures.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-5 font-black">
                    <a href="#permainan" class="footer-link">Permainan</a>
                    <a href="#dunia" class="footer-link">Dunia</a>
                    <a href="#ibu-bapa" class="footer-link">Ibu bapa</a>
                    <a href="#pakej" class="footer-link">Pakej</a>
                    <Link href="/login" class="footer-link">Log masuk</Link>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.nav-link,
.footer-link {
    min-height: 44px;
    display: inline-flex;
    align-items: center;
}
.nav-link:hover,
.footer-link:hover {
    color: #9a5b00;
}
.nav-link:focus-visible,
.footer-link:focus-visible {
    outline: 3px solid #9a5b00;
    outline-offset: 4px;
}
.sound-pulse {
    animation: sound-pulse 0.65s ease-in-out;
}
@keyframes sound-pulse {
    0%,
    100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.25);
    }
}
@media (prefers-reduced-motion: reduce) {
    .sound-pulse {
        animation: none;
    }
    * {
        scroll-behavior: auto !important;
    }
}
</style>
