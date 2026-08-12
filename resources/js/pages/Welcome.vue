<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    AudioLines,
    BadgeDollarSign,
    BarChart3,
    BookOpenText,
    Check,
    ChevronRight,
    CircleCheck,
    Eye,
    Mic2,
    MousePointer2,
    ShieldCheck,
    Users,
} from '@lucide/vue';

defineProps<{ canRegister: boolean }>();
</script>

<template>
    <Head title="Belajar Bahasa Melayu dengan JomKid">
        <meta
            name="description"
            content="JomKid ialah platform pembelajaran interaktif untuk anak 5 hingga 8 tahun. Mulakan dengan JomABC melalui aktiviti suara, sentuhan dan laporan ibu bapa."
        />
    </Head>

    <div class="min-h-screen overflow-x-clip bg-[#fffaf0] text-[#17152b]">
        <header class="border-b-2 border-[#17152b] bg-[#fffaf0]">
            <div
                class="mx-auto flex min-h-18 max-w-7xl items-center justify-between gap-4 px-5 py-3 lg:px-8"
            >
                <Link
                    href="/"
                    class="flex min-h-11 items-center gap-3 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#4f46e5]"
                >
                    <span
                        class="grid size-10 place-items-center rounded-[14px_14px_14px_4px] border-2 border-[#17152b] bg-[#ff766b] font-black text-white"
                        >J</span
                    >
                    <span class="text-xl font-black tracking-[-0.03em]"
                        >JomKid</span
                    >
                </Link>

                <nav
                    aria-label="Navigasi utama"
                    class="hidden items-center gap-7 text-sm font-bold md:flex"
                >
                    <a
                        class="hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-4"
                        href="#jomabc"
                        >JomABC</a
                    >
                    <a
                        class="hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-4"
                        href="#ibu-bapa"
                        >Untuk ibu bapa</a
                    >
                    <a
                        class="hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-4"
                        href="#pakej"
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
                        class="inline-flex min-h-11 items-center border-b-2 border-[#17152b] px-3 text-sm font-black focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#4f46e5]"
                    >
                        Buka akaun
                    </Link>
                    <template v-else>
                        <Link
                            href="/login"
                            class="hidden min-h-11 items-center px-3 text-sm font-bold hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-2 sm:inline-flex"
                            >Log masuk</Link
                        >
                        <Link
                            v-if="canRegister"
                            href="/checkout"
                            class="inline-flex min-h-11 items-center rounded-[14px_14px_14px_4px] border-2 border-[#17152b] bg-[#17152b] px-5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#4f46e5]"
                            >Pilih pakej</Link
                        >
                    </template>
                </div>
            </div>
        </header>

        <main>
            <section class="relative border-b-2 border-[#17152b]">
                <div
                    class="absolute inset-y-0 right-0 hidden w-[38%] bg-[#f1c84b] lg:block"
                ></div>
                <div
                    class="relative mx-auto grid max-w-7xl gap-12 px-5 py-14 sm:py-20 lg:grid-cols-[1.04fr_.96fr] lg:items-center lg:px-8 lg:py-24"
                >
                    <div class="max-w-3xl">
                        <p
                            class="mb-5 flex items-center gap-3 text-sm font-black text-[#4f46e5]"
                        >
                            <span class="h-1 w-10 bg-[#ff766b]"></span>UNTUK
                            ANAK 5 HINGGA 8 TAHUN
                        </p>
                        <h1
                            class="text-[clamp(3rem,7vw,6.6rem)] leading-[0.9] font-black tracking-[-0.065em]"
                        >
                            Dengar.<br />Jawab.<br /><span
                                class="relative inline-block text-[#4f46e5]"
                                >Terus faham.<span
                                    class="absolute -bottom-2 left-1 h-2 w-3/4 -rotate-1 bg-[#ff766b]"
                                ></span
                            ></span>
                        </h1>
                        <p
                            class="mt-9 max-w-xl text-lg leading-8 text-[#45425c] sm:text-xl"
                        >
                            JomKid membantu anak belajar Bahasa Melayu melalui
                            suara, sentuhan dan aktiviti pendek. Ibu bapa boleh
                            melihat kemajuan setiap profil anak dalam satu
                            akaun.
                        </p>
                        <Link
                            href="/checkout"
                            class="mt-8 inline-flex min-h-14 items-center gap-4 rounded-[18px_18px_18px_5px] border-2 border-[#17152b] bg-[#4f46e5] px-7 text-base font-black text-white transition hover:-translate-y-1 hover:bg-[#3730a3] focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#ff766b]"
                        >
                            Pilih akses lifetime
                            <ChevronRight class="size-5" />
                        </Link>
                        <p class="mt-4 text-sm font-semibold text-[#5b586d]">
                            Bermula RM69 sekali bayar. Kod pendaftaran dihantar
                            selepas bayaran CHIP disahkan.
                        </p>
                    </div>

                    <div class="relative mx-auto w-full max-w-lg lg:mx-0">
                        <div
                            class="absolute -top-4 -left-4 h-full w-full rounded-[30px_30px_30px_8px] border-2 border-[#17152b] bg-[#ff766b]"
                        ></div>
                        <article
                            aria-label="Contoh paparan aktiviti JomABC"
                            class="relative rounded-[30px_30px_30px_8px] border-2 border-[#17152b] bg-white p-5 sm:p-7"
                        >
                            <div
                                class="flex items-center justify-between border-b-2 border-[#17152b] pb-5"
                            >
                                <div>
                                    <p
                                        class="text-sm font-black text-[#4f46e5]"
                                    >
                                        JOMABC
                                    </p>
                                    <p class="mt-1 text-lg font-black">
                                        Bunyi huruf
                                    </p>
                                </div>
                                <span
                                    class="rounded-[12px_12px_12px_3px] border-2 border-[#17152b] bg-[#f1c84b] px-3 py-2 text-xs font-black"
                                    >AKTIVITI 04</span
                                >
                            </div>
                            <div class="py-8 sm:py-10">
                                <p
                                    class="max-w-sm text-2xl leading-tight font-black sm:text-3xl"
                                >
                                    Huruf manakah berbunyi “mmm”?
                                </p>
                                <div class="mt-7 flex items-center gap-4">
                                    <span
                                        class="grid size-15 shrink-0 place-items-center rounded-full border-2 border-[#17152b] bg-[#ffebe7] text-[#d9473d]"
                                        ><AudioLines
                                    /></span>
                                    <div class="h-2 flex-1 bg-[#17152b]"></div>
                                    <div class="h-7 w-2 bg-[#ff766b]"></div>
                                    <div class="h-12 w-2 bg-[#4f46e5]"></div>
                                    <div class="h-5 w-2 bg-[#f1c84b]"></div>
                                    <div class="h-2 flex-1 bg-[#17152b]"></div>
                                </div>
                                <div class="mt-8 grid grid-cols-3 gap-3">
                                    <span
                                        class="grid min-h-20 place-items-center rounded-[18px_18px_18px_5px] border-2 border-[#17152b] text-3xl font-black"
                                        >N</span
                                    >
                                    <span
                                        class="grid min-h-20 place-items-center rounded-[18px_18px_18px_5px] border-2 border-[#17152b] bg-[#4f46e5] text-3xl font-black text-white"
                                        >M</span
                                    >
                                    <span
                                        class="grid min-h-20 place-items-center rounded-[18px_18px_18px_5px] border-2 border-[#17152b] text-3xl font-black"
                                        >B</span
                                    >
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-3 rounded-[16px_16px_16px_4px] bg-[#dff7e9] p-4 font-bold text-[#165b36]"
                            >
                                <CircleCheck class="size-5 shrink-0" /> Betul.
                                Ini bunyi huruf M.
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="jomabc"
                class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28"
            >
                <div
                    class="grid gap-12 lg:grid-cols-[.72fr_1.28fr] lg:items-start"
                >
                    <div class="lg:sticky lg:top-8">
                        <p class="text-sm font-black text-[#d9473d]">
                            MODUL PERTAMA
                        </p>
                        <h2
                            class="mt-3 text-4xl leading-[1.02] font-black tracking-[-0.045em] sm:text-5xl"
                        >
                            JomABC bukan video untuk ditonton diam-diam.
                        </h2>
                        <p class="mt-5 text-lg leading-8 text-[#5b586d]">
                            Anak mendengar arahan, memberi jawapan dan menerima
                            maklum balas dalam sesi yang sama.
                        </p>
                    </div>

                    <div class="border-y-2 border-[#17152b]">
                        <article
                            class="grid gap-5 border-b-2 border-[#17152b] py-8 sm:grid-cols-[72px_1fr] sm:items-start"
                        >
                            <span
                                class="grid size-16 place-items-center rounded-[18px_18px_18px_5px] bg-[#f1c84b]"
                                ><BookOpenText
                            /></span>
                            <div>
                                <p class="text-xs font-black text-[#4f46e5]">
                                    01
                                </p>
                                <h3 class="mt-1 text-2xl font-black">
                                    Konsep pendek, bahasa jelas
                                </h3>
                                <p
                                    class="mt-2 max-w-2xl leading-7 text-[#5b586d]"
                                >
                                    Setiap aktiviti memberi satu arahan dan satu
                                    fokus. Anak tidak perlu menavigasi halaman
                                    yang padat.
                                </p>
                            </div>
                        </article>
                        <article
                            class="grid gap-5 border-b-2 border-[#17152b] py-8 sm:grid-cols-[72px_1fr] sm:items-start sm:pl-10"
                        >
                            <span
                                class="grid size-16 place-items-center rounded-full border-2 border-[#17152b] bg-[#ffebe7]"
                                ><Mic2
                            /></span>
                            <div>
                                <p class="text-xs font-black text-[#d9473d]">
                                    02
                                </p>
                                <h3 class="mt-1 text-2xl font-black">
                                    Respons melalui suara atau sentuhan
                                </h3>
                                <p
                                    class="mt-2 max-w-2xl leading-7 text-[#5b586d]"
                                >
                                    Aktiviti menggunakan bentuk respons yang
                                    sesuai dengan kandungan, termasuk pilihan
                                    huruf, susunan dan suara.
                                </p>
                            </div>
                        </article>
                        <article
                            class="grid gap-5 py-8 sm:grid-cols-[72px_1fr] sm:items-start"
                        >
                            <span
                                class="grid size-16 place-items-center rounded-[18px_18px_18px_5px] bg-[#4f46e5] text-white"
                                ><CircleCheck
                            /></span>
                            <div>
                                <p class="text-xs font-black text-[#4f46e5]">
                                    03
                                </p>
                                <h3 class="mt-1 text-2xl font-black">
                                    Jawapan disemak terus
                                </h3>
                                <p
                                    class="mt-2 max-w-2xl leading-7 text-[#5b586d]"
                                >
                                    Maklum balas muncul selepas respons supaya
                                    anak tahu apa yang betul dan boleh mencuba
                                    semula.
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section
                id="ibu-bapa"
                class="border-y-2 border-[#17152b] bg-[#17152b] text-white"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-12 px-5 py-20 lg:grid-cols-[1fr_1.05fr] lg:items-center lg:px-8 lg:py-24"
                >
                    <div>
                        <p class="text-sm font-black text-[#f1c84b]">
                            PANDANGAN IBU BAPA
                        </p>
                        <h2
                            class="mt-3 max-w-xl text-4xl leading-[1.02] font-black tracking-[-0.045em] sm:text-5xl"
                        >
                            Tahu bahagian yang anak sudah kuasai.
                        </h2>
                        <p
                            class="mt-5 max-w-xl text-lg leading-8 text-[#d7d4e5]"
                        >
                            Setiap profil menyimpan kemajuan sendiri. Lihat
                            aktiviti, skor dan ketepatan tanpa mencampurkan
                            rekod adik-beradik.
                        </p>
                        <dl class="mt-9 grid gap-6 sm:grid-cols-2">
                            <div class="border-l-4 border-[#ff766b] pl-4">
                                <dt class="font-black">Profil berasingan</dt>
                                <dd
                                    class="mt-2 text-sm leading-6 text-[#c6c3d4]"
                                >
                                    Basic menyokong 3 profil. Premium menyokong
                                    profil tanpa had.
                                </dd>
                            </div>
                            <div class="border-l-4 border-[#f1c84b] pl-4">
                                <dt class="font-black">Privasi terkawal</dt>
                                <dd
                                    class="mt-2 text-sm leading-6 text-[#c6c3d4]"
                                >
                                    Leaderboard menggunakan alias dan avatar
                                    apabila ibu bapa memilih untuk menyertai.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <article
                        class="relative bg-[#fffaf0] p-5 text-[#17152b] sm:p-7"
                    >
                        <div
                            class="absolute -top-3 -right-3 h-full w-full border-2 border-[#f1c84b]"
                        ></div>
                        <div
                            class="relative border-2 border-[#17152b] bg-white p-5 sm:p-7"
                        >
                            <div
                                class="flex items-start justify-between gap-4 border-b-2 border-[#17152b] pb-5"
                            >
                                <div>
                                    <p
                                        class="text-xs font-black text-[#4f46e5]"
                                    >
                                        PROFIL ANAK
                                    </p>
                                    <p class="mt-1 text-2xl font-black">
                                        Bintang
                                    </p>
                                </div>
                                <span
                                    class="rounded-[12px_12px_12px_3px] bg-[#ffebe7] px-3 py-2 text-xs font-black text-[#a92d25]"
                                    >JomABC</span
                                >
                            </div>
                            <div
                                class="mt-6 grid gap-5 sm:grid-cols-[1fr_150px]"
                            >
                                <div>
                                    <p class="text-sm font-bold text-[#5b586d]">
                                        Topik semasa
                                    </p>
                                    <p class="mt-1 text-xl font-black">
                                        Bunyi huruf M
                                    </p>
                                    <div
                                        class="mt-4 h-3 border-2 border-[#17152b] bg-white"
                                    >
                                        <div
                                            class="h-full w-3/4 bg-[#4f46e5]"
                                        ></div>
                                    </div>
                                    <p class="mt-2 text-sm text-[#5b586d]">
                                        3 daripada 4 aktiviti selesai
                                    </p>
                                </div>
                                <div
                                    class="rounded-[18px_18px_18px_5px] bg-[#f1c84b] p-4"
                                >
                                    <BarChart3 class="size-5" />
                                    <p class="mt-4 text-3xl font-black">75%</p>
                                    <p class="text-sm font-semibold">
                                        Ketepatan topik
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <div class="border-2 border-[#17152b] p-4">
                                    <Eye class="size-5 text-[#4f46e5]" />
                                    <p class="mt-3 font-black">
                                        Aktiviti terakhir
                                    </p>
                                    <p class="mt-1 text-sm text-[#5b586d]">
                                        Padankan huruf
                                    </p>
                                </div>
                                <div class="border-2 border-[#17152b] p-4">
                                    <Users class="size-5 text-[#d9473d]" />
                                    <p class="mt-3 font-black">Cadangan</p>
                                    <p class="mt-1 text-sm text-[#5b586d]">
                                        Ulang bunyi M
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-24">
                <div
                    class="grid gap-8 border-b-2 border-[#17152b] pb-12 lg:grid-cols-[.65fr_1.35fr]"
                >
                    <h2
                        class="text-3xl font-black tracking-[-0.04em] sm:text-4xl"
                    >
                        JomKid berkembang bersama anak.
                    </h2>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="bg-[#4f46e5] p-5 text-white">
                            <p class="text-xs font-black text-[#f1c84b]">
                                TERSEDIA
                            </p>
                            <p class="mt-2 text-xl font-black">JomABC</p>
                            <p class="mt-2 text-sm leading-6 text-indigo-100">
                                Asas Bahasa Melayu melalui huruf, bunyi dan
                                perkataan.
                            </p>
                        </div>
                        <div class="border-2 border-[#17152b] p-5">
                            <p class="text-xs font-black text-[#d9473d]">
                                AKAN DATANG
                            </p>
                            <p class="mt-2 text-xl font-black">JomMengaji</p>
                            <p class="mt-2 text-sm leading-6 text-[#5b586d]">
                                Modul pembelajaran mengaji sedang dirancang.
                            </p>
                        </div>
                        <div class="border-2 border-[#17152b] p-5">
                            <p class="text-xs font-black text-[#d9473d]">
                                AKAN DATANG
                            </p>
                            <p class="mt-2 text-xl font-black">JomMengira</p>
                            <p class="mt-2 text-sm leading-6 text-[#5b586d]">
                                Modul asas nombor dan kiraan sedang dirancang.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pakej" class="pb-20 lg:pb-28">
                <div class="mx-auto max-w-7xl px-5 lg:px-8">
                    <div class="max-w-3xl">
                        <p class="text-sm font-black text-[#4f46e5]">
                            AKSES LIFETIME
                        </p>
                        <h2
                            class="mt-3 text-4xl leading-[1.02] font-black tracking-[-0.045em] sm:text-6xl"
                        >
                            Bayar sekali. Pilih ikut cara keluarga menggunakan
                            JomKid.
                        </h2>
                    </div>
                    <div
                        class="mt-12 grid border-2 border-[#17152b] lg:grid-cols-2"
                    >
                        <article
                            class="flex flex-col bg-white p-6 sm:p-9 lg:border-r-2 lg:border-[#17152b]"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p
                                        class="text-sm font-black text-[#4f46e5]"
                                    >
                                        BASIC
                                    </p>
                                    <h3 class="mt-2 text-3xl font-black">
                                        Untuk keluarga
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-5xl font-black">RM69</p>
                                    <p
                                        class="text-sm font-semibold text-[#5b586d]"
                                    >
                                        sekali bayar
                                    </p>
                                </div>
                            </div>
                            <ul class="mt-8 grid gap-4 text-sm font-bold">
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 shrink-0 text-[#4f46e5]"
                                    />Maksimum 3 profil anak
                                </li>
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 shrink-0 text-[#4f46e5]"
                                    />Akses lifetime pembelajaran
                                </li>
                                <li class="flex gap-3">
                                    <Check
                                        class="size-5 shrink-0 text-[#4f46e5]"
                                    />Laporan kemajuan ibu bapa
                                </li>
                                <li class="flex gap-3 text-[#777487]">
                                    <span class="w-5 shrink-0 text-center"
                                        >×</span
                                    >Tiada reseller atau affiliate license
                                </li>
                            </ul>
                            <Link
                                href="/checkout?package=basic"
                                class="mt-9 inline-flex min-h-13 items-center justify-between border-t-2 border-[#17152b] pt-5 font-black text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-4"
                                ><span>Beli JomKid Basic</span><ChevronRight
                            /></Link>
                        </article>

                        <article
                            class="relative flex flex-col bg-[#f1c84b] p-6 sm:p-9"
                        >
                            <span
                                class="absolute top-0 right-5 -translate-y-1/2 rounded-[11px_11px_11px_3px] border-2 border-[#17152b] bg-[#ff766b] px-4 py-2 text-xs font-black text-white"
                                >RESELLER LICENSE</span
                            >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p
                                        class="text-sm font-black text-[#a92d25]"
                                    >
                                        PREMIUM
                                    </p>
                                    <h3 class="mt-2 text-3xl font-black">
                                        Untuk belajar dan menjual
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-5xl font-black">RM99</p>
                                    <p class="text-sm font-semibold">
                                        sekali bayar
                                    </p>
                                </div>
                            </div>
                            <ul class="mt-8 grid gap-4 text-sm font-bold">
                                <li class="flex gap-3">
                                    <Check class="size-5 shrink-0" />Profil anak
                                    tanpa had
                                </li>
                                <li class="flex gap-3">
                                    <ShieldCheck
                                        class="size-5 shrink-0"
                                    />Reseller license
                                </li>
                                <li class="flex gap-3">
                                    <BadgeDollarSign
                                        class="size-5 shrink-0"
                                    />Link affiliate peribadi
                                </li>
                                <li class="flex gap-3">
                                    <Check class="size-5 shrink-0" />Komisen 50%
                                    untuk jualan referral langsung
                                </li>
                            </ul>
                            <Link
                                href="/checkout?package=premium"
                                class="mt-9 inline-flex min-h-13 items-center justify-between border-t-2 border-[#17152b] pt-5 font-black focus-visible:outline-2 focus-visible:outline-offset-4"
                                ><span>Beli Premium + Reseller</span
                                ><ChevronRight
                            /></Link>
                        </article>
                    </div>
                    <div
                        class="grid gap-4 border-x-2 border-b-2 border-[#17152b] bg-[#fffaf0] p-5 text-sm sm:grid-cols-3 sm:p-6"
                    >
                        <p class="flex items-center gap-3 font-bold">
                            <ShieldCheck class="size-5 text-[#4f46e5]" />Bayaran
                            melalui CHIP
                        </p>
                        <p class="flex items-center gap-3 font-bold">
                            <MousePointer2 class="size-5 text-[#4f46e5]" />Beli
                            sebelum daftar
                        </p>
                        <p class="flex items-center gap-3 font-bold">
                            <CircleCheck class="size-5 text-[#4f46e5]" />Kod
                            pendaftaran sekali guna
                        </p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t-2 border-[#17152b] bg-white">
            <div
                class="mx-auto flex max-w-7xl flex-col justify-between gap-5 px-5 py-8 text-sm sm:flex-row sm:items-center lg:px-8"
            >
                <div>
                    <p class="font-black">JomKid</p>
                    <p class="mt-1 text-[#5b586d]">
                        Platform pembelajaran interaktif oleh Stwo Ventures.
                    </p>
                </div>
                <div class="flex flex-wrap gap-5 font-bold">
                    <a
                        href="#jomabc"
                        class="inline-flex min-h-11 items-center hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-2"
                        >JomABC</a
                    >
                    <a
                        href="#ibu-bapa"
                        class="inline-flex min-h-11 items-center hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-2"
                        >Ibu bapa</a
                    >
                    <a
                        href="#pakej"
                        class="inline-flex min-h-11 items-center hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-2"
                        >Pakej</a
                    >
                    <Link
                        href="/login"
                        class="inline-flex min-h-11 items-center hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-2"
                        >Log masuk</Link
                    >
                </div>
            </div>
        </footer>
    </div>
</template>
