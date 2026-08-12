<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BookOpen,
    Check,
    Mic2,
    ShieldCheck,
    Star,
    Users,
} from '@lucide/vue';

defineProps<{ canRegister: boolean }>();
</script>

<template>
    <Head title="Belajar sambil bermain">
        <meta
            name="description"
            content="JomKid membantu anak 5–8 tahun belajar melalui modul interaktif seperti JomABC, JomMengaji dan JomMengira."
        />
    </Head>

    <div class="min-h-screen bg-[#fffdfa] text-slate-950">
        <header
            class="sticky top-0 z-40 border-b border-slate-200/80 bg-[#fffdfa]/95 backdrop-blur"
        >
            <div
                class="mx-auto flex h-18 max-w-7xl items-center justify-between px-5 lg:px-8"
            >
                <Link
                    href="/"
                    class="flex items-center gap-3 font-black tracking-tight"
                >
                    <span
                        class="grid size-10 place-items-center rounded-2xl bg-indigo-600 text-xl text-white"
                        >J</span
                    >
                    <span class="text-xl"
                        >Jom<span class="text-indigo-600">Kid</span></span
                    >
                </Link>
                <nav
                    class="hidden items-center gap-8 text-sm font-semibold md:flex"
                >
                    <a href="#cara" class="hover:text-indigo-600"
                        >Cara belajar</a
                    >
                    <a href="#ibu-bapa" class="hover:text-indigo-600"
                        >Untuk ibu bapa</a
                    >
                    <a href="#harga" class="hover:text-indigo-600">Harga</a>
                </nav>
                <div class="flex items-center gap-2">
                    <Link
                        v-if="$page.props.auth.user"
                        href="/dashboard"
                        class="rounded-full bg-slate-950 px-5 py-2.5 text-sm font-bold text-white"
                        >Dashboard</Link
                    >
                    <template v-else>
                        <Link
                            href="/login"
                            class="hidden px-4 py-2 text-sm font-bold sm:block"
                            >Log masuk</Link
                        >
                        <Link
                            v-if="canRegister"
                            href="/checkout"
                            class="rounded-full bg-slate-950 px-5 py-2.5 text-sm font-bold text-white"
                            >Cuba sekarang</Link
                        >
                    </template>
                </div>
            </div>
        </header>

        <main>
            <section class="overflow-hidden border-b border-slate-200">
                <div
                    class="mx-auto grid max-w-7xl items-center gap-14 px-5 py-16 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:py-24"
                >
                    <div>
                        <!-- <div
                            class="mb-6 inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-indigo-50 px-4 py-2 text-sm font-bold text-indigo-700"
                        >
                            <Sparkles class="size-4" /> Belajar dua hala untuk
                            umur 5–8 tahun
                        </div> -->
                        <h1
                            class="max-w-3xl text-5xl leading-[1.04] font-black tracking-[-0.045em] sm:text-6xl lg:text-7xl"
                        >
                            Anak dengar, jawab dan
                            <span class="text-indigo-600">terus faham.</span>
                        </h1>
                        <p
                            class="mt-6 max-w-2xl text-lg leading-8 text-slate-600 sm:text-xl"
                        >
                            Aktiviti Bahasa Melayu dan matematik yang pendek,
                            interaktif dan menyeronokkan—dipandu watak JomKid
                            melalui suara dan sentuhan.
                        </p>
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <Link
                                href="/checkout"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-indigo-600 px-7 py-4 font-black text-white transition hover:bg-indigo-700"
                            >
                                Mulakan pembelajaran
                                <ArrowRight class="size-5" />
                            </Link>
                            <a
                                href="#cara"
                                class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-4 font-bold"
                                >Lihat cara ia berfungsi</a
                            >
                        </div>
                        <div
                            class="mt-7 flex flex-wrap gap-x-6 gap-y-2 text-sm font-semibold text-slate-600"
                        >
                            <span class="flex items-center gap-2"
                                ><Check class="size-4 text-emerald-600" /> 3
                                atau unlimited profil anak</span
                            >
                            <span class="flex items-center gap-2"
                                ><Check class="size-4 text-emerald-600" />
                                Laporan ibu bapa</span
                            >
                            <span class="flex items-center gap-2"
                                ><Check class="size-4 text-emerald-600" /> Dari
                                RM69 lifetime</span
                            >
                        </div>
                    </div>

                    <div class="relative mx-auto w-full max-w-xl">
                        <div
                            class="rounded-[2.25rem] border-2 border-slate-900 bg-white p-5 sm:p-7"
                        >
                            <div
                                class="flex items-center justify-between border-b border-slate-200 pb-5"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="grid size-12 place-items-center rounded-2xl bg-indigo-600 text-2xl"
                                        >🦉</span
                                    >
                                    <div>
                                        <p class="font-black">Hai, Bintang!</p>
                                        <p class="text-sm text-slate-500">
                                            Sedia untuk belajar?
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-black text-yellow-800"
                                    >⭐ 240 XP</span
                                >
                            </div>
                            <div class="py-8 text-center">
                                <p
                                    class="text-sm font-black tracking-widest text-indigo-600 uppercase"
                                >
                                    Bunyi huruf
                                </p>
                                <p class="mt-3 text-2xl font-black">
                                    Huruf manakah berbunyi “mmm”?
                                </p>
                                <button
                                    class="bg-coral-100 mx-auto mt-5 grid size-16 place-items-center rounded-full bg-rose-100 text-rose-600"
                                >
                                    <Mic2 class="size-7" />
                                </button>
                                <div class="mt-7 grid grid-cols-3 gap-3">
                                    <button
                                        class="rounded-2xl border-2 border-slate-200 py-5 text-3xl font-black"
                                    >
                                        N
                                    </button>
                                    <button
                                        class="rounded-2xl border-2 border-indigo-600 bg-indigo-50 py-5 text-3xl font-black text-indigo-700"
                                    >
                                        M
                                    </button>
                                    <button
                                        class="rounded-2xl border-2 border-slate-200 py-5 text-3xl font-black"
                                    >
                                        B
                                    </button>
                                </div>
                            </div>
                            <div
                                class="rounded-2xl bg-emerald-50 p-4 text-center font-bold text-emerald-700"
                            >
                                Hebat! Jawapan kamu betul 🎉
                            </div>
                        </div>
                        <div
                            class="absolute -right-3 -bottom-5 rotate-3 rounded-2xl border border-slate-200 bg-yellow-300 px-5 py-3 font-black"
                        >
                            7 minit sehari
                        </div>
                    </div>
                </div>
            </section>

            <section id="cara" class="mx-auto max-w-7xl px-5 py-20 lg:px-8">
                <div class="max-w-2xl">
                    <p class="font-black text-indigo-600">CARA JOMKID</p>
                    <h2
                        class="mt-3 text-4xl font-black tracking-tight sm:text-5xl"
                    >
                        Satu sesi kecil, satu kemajuan besar.
                    </h2>
                </div>
                <div class="mt-12 grid gap-5 md:grid-cols-3">
                    <article
                        class="rounded-3xl border border-slate-200 bg-white p-7"
                    >
                        <span
                            class="grid size-12 place-items-center rounded-2xl bg-indigo-100 text-indigo-700"
                            ><BookOpen
                        /></span>
                        <h3 class="mt-5 text-xl font-black">Tonton & dengar</h3>
                        <p class="mt-2 leading-7 text-slate-600">
                            Watak JomKid menerangkan satu konsep dengan ayat
                            pendek dan visual jelas.
                        </p>
                    </article>
                    <article
                        class="rounded-3xl border border-slate-200 bg-white p-7"
                    >
                        <span
                            class="grid size-12 place-items-center rounded-2xl bg-rose-100 text-rose-600"
                            ><Mic2
                        /></span>
                        <h3 class="mt-5 text-xl font-black">Jawab & cuba</h3>
                        <p class="mt-2 leading-7 text-slate-600">
                            Anak menjawab melalui suara, pilihan sentuhan atau
                            susunan huruf.
                        </p>
                    </article>
                    <article
                        class="rounded-3xl border border-slate-200 bg-white p-7"
                    >
                        <span
                            class="grid size-12 place-items-center rounded-2xl bg-yellow-100 text-yellow-700"
                            ><Star
                        /></span>
                        <h3 class="mt-5 text-xl font-black">
                            Dapat maklum balas
                        </h3>
                        <p class="mt-2 leading-7 text-slate-600">
                            Jawapan disemak serta-merta dan kemajuan disimpan
                            untuk ibu bapa.
                        </p>
                    </article>
                </div>
            </section>

            <section
                id="ibu-bapa"
                class="border-y border-slate-200 bg-indigo-950 text-white"
            >
                <div
                    class="mx-auto grid max-w-7xl gap-12 px-5 py-20 lg:grid-cols-2 lg:px-8"
                >
                    <div>
                        <p class="font-black text-yellow-300">UNTUK IBU BAPA</p>
                        <h2
                            class="mt-3 text-4xl font-black tracking-tight sm:text-5xl"
                        >
                            Nampak apa yang anak kuasai.
                        </h2>
                        <p class="mt-5 text-lg leading-8 text-indigo-100">
                            Pantau masa belajar, skor, streak, topik kuat dan
                            bahagian yang perlukan perhatian—tanpa tekanan
                            ranking terbuka.
                        </p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-white/20 p-6">
                            <Users class="text-yellow-300" />
                            <h3 class="mt-4 font-black">
                                3 atau unlimited anak
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-indigo-100">
                                Ikut pakej, dengan profil, tahap dan cadangan
                                pembelajaran berasingan.
                            </p>
                        </div>
                        <div class="rounded-3xl border border-white/20 p-6">
                            <ShieldCheck class="text-yellow-300" />
                            <h3 class="mt-4 font-black">Privasi dahulu</h3>
                            <p class="mt-2 text-sm leading-6 text-indigo-100">
                                Ranking hanya guna alias dan avatar dengan
                                pilihan ibu bapa.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section
                id="harga"
                class="mx-auto max-w-5xl px-5 py-20 text-center lg:px-8"
            >
                <p class="font-black text-indigo-600">PELAN KELUARGA</p>
                <h2 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">
                    Pilih pakej lifetime anda.
                </h2>
                <div
                    class="mx-auto mt-10 grid max-w-4xl gap-5 text-left md:grid-cols-2"
                >
                    <article
                        class="rounded-[2rem] border-2 border-slate-300 bg-white p-8"
                    >
                        <p class="font-black text-indigo-600">BASIC</p>
                        <div class="mt-3 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xl font-black">JomKid Basic</p>
                                <p class="mt-1 text-sm text-slate-500">
                                    Belajar bersama keluarga
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-4xl font-black">RM69</span>
                                <p class="text-xs text-slate-500">
                                    sekali sahaja
                                </p>
                            </div>
                        </div>
                        <ul class="mt-7 grid gap-3 text-sm font-semibold">
                            <li class="flex gap-2">
                                <Check class="size-5 text-emerald-600" />
                                Maksimum 3 profil anak
                            </li>
                            <li class="flex gap-2">
                                <Check class="size-5 text-emerald-600" /> Akses
                                lifetime pembelajaran
                            </li>
                            <li class="flex gap-2 text-slate-400">
                                Tiada reseller atau affiliate license
                            </li>
                        </ul>
                        <a
                            href="/checkout?package=basic"
                            class="mt-8 flex w-full items-center justify-center gap-2 rounded-full bg-slate-950 px-6 py-4 font-black text-white"
                            >Pilih Basic <ArrowRight class="size-5"
                        /></a>
                    </article>

                    <article
                        class="relative rounded-[2rem] border-2 border-indigo-600 bg-indigo-950 p-8 text-white"
                    >
                        <span
                            class="absolute -top-3 right-6 rounded-full bg-yellow-300 px-4 py-1 text-xs font-black text-indigo-950"
                            >RESELLER</span
                        >
                        <p class="font-black text-yellow-300">PREMIUM</p>
                        <div class="mt-3 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xl font-black">
                                    Premium + Reseller
                                </p>
                                <p class="mt-1 text-sm text-indigo-200">
                                    Belajar dan jana komisen
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-4xl font-black">RM99</span>
                                <p class="text-xs text-indigo-200">
                                    sekali sahaja
                                </p>
                            </div>
                        </div>
                        <ul class="mt-7 grid gap-3 text-sm font-semibold">
                            <li class="flex gap-2">
                                <Check class="size-5 text-yellow-300" />
                                Unlimited profil anak
                            </li>
                            <li class="flex gap-2">
                                <Check class="size-5 text-yellow-300" />
                                Reseller license + link affiliate
                            </li>
                            <li class="flex gap-2">
                                <Check class="size-5 text-yellow-300" /> Komisen
                                50% setiap jualan referral
                            </li>
                        </ul>
                        <a
                            href="/checkout?package=premium"
                            class="mt-8 flex w-full items-center justify-center gap-2 rounded-full bg-yellow-300 px-6 py-4 font-black text-indigo-950"
                            >Pilih Premium <ArrowRight class="size-5"
                        /></a>
                    </article>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-200">
            <div
                class="mx-auto flex max-w-7xl flex-col justify-between gap-3 px-5 py-8 text-sm text-slate-500 sm:flex-row lg:px-8"
            >
                <p>© 2026 Stwo Ventures. JomKid.</p>
                <p>Belajar dengan selamat di jomkid.com</p>
            </div>
        </footer>
    </div>
</template>
