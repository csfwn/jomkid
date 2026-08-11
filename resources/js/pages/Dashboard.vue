<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BookOpen,
    CalendarDays,
    Plus,
    Sparkles,
    Star,
} from '@lucide/vue';

type Child = {
    id: number;
    display_name: string;
    avatar_key: string;
    xp: number;
    current_level: number;
    streak_days: number;
};
type Module = {
    id: number;
    title: string;
    subject: string;
    description: string;
    lessons_count: number;
};
defineProps<{
    children: Child[];
    modules: Module[];
}>();
</script>

<template>
    <Head title="Dashboard" />
    <div class="space-y-7 p-4 md:p-7">
        <section
            class="overflow-hidden rounded-3xl bg-indigo-950 p-7 text-white md:p-9"
        >
            <div class="max-w-2xl">
                <p class="font-bold text-yellow-300">
                    SELAMAT DATANG KE JOMKID
                </p>
                <h1 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">
                    Bina rutin belajar yang anak suka.
                </h1>
                <p class="mt-3 text-indigo-100">
                    Pilih profil anak dan teruskan sesi 5–10 minit hari ini.
                </p>
                <Link
                    href="/learn"
                    class="mt-6 inline-flex items-center gap-2 rounded-full bg-yellow-300 px-6 py-3 font-black text-indigo-950"
                    >Mula belajar <ArrowRight class="size-4"
                /></Link>
            </div>
        </section>

        <section>
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-indigo-600">
                        KELUARGA ANDA
                    </p>
                    <h2 class="text-2xl font-black">Profil anak</h2>
                </div>
                <Link
                    href="/children"
                    class="flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-bold"
                    ><Plus class="size-4" /> Urus profil</Link
                >
            </div>
            <div v-if="children.length" class="grid gap-4 md:grid-cols-3">
                <article
                    v-for="child in children"
                    :key="child.id"
                    class="rounded-3xl border bg-white p-6"
                >
                    <div class="flex items-center gap-4">
                        <span
                            class="grid size-14 place-items-center rounded-2xl bg-indigo-100 text-2xl"
                            >🦉</span
                        >
                        <div>
                            <h3 class="text-lg font-black">
                                {{ child.display_name }}
                            </h3>
                            <p class="text-sm text-slate-500">
                                Tahap {{ child.current_level }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-yellow-50 p-3">
                            <Star class="size-4 text-yellow-600" />
                            <p class="mt-1 text-xl font-black">
                                {{ child.xp }}
                            </p>
                            <p class="text-xs text-slate-500">Jumlah XP</p>
                        </div>
                        <div class="rounded-2xl bg-rose-50 p-3">
                            <CalendarDays class="size-4 text-rose-600" />
                            <p class="mt-1 text-xl font-black">
                                {{ child.streak_days }}
                            </p>
                            <p class="text-xs text-slate-500">Hari streak</p>
                        </div>
                    </div>
                </article>
            </div>
            <div
                v-else
                class="rounded-3xl border border-dashed bg-white p-10 text-center"
            >
                <Sparkles class="mx-auto text-indigo-500" />
                <h3 class="mt-3 text-xl font-black">
                    Tambah profil anak pertama
                </h3>
                <p class="mt-2 text-slate-500">
                    Setiap akaun boleh mempunyai sehingga tiga profil.
                </p>
                <Link
                    href="/children"
                    class="mt-5 inline-flex rounded-full bg-slate-950 px-5 py-3 font-bold text-white"
                    >Tambah profil</Link
                >
            </div>
        </section>

        <section>
            <div class="mb-4">
                <p class="text-sm font-bold text-indigo-600">MODUL TERSEDIA</p>
                <h2 class="text-2xl font-black">Apa yang boleh dipelajari</h2>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <article
                    v-for="module in modules"
                    :key="module.id"
                    class="rounded-3xl border bg-white p-6"
                >
                    <div class="flex items-start justify-between">
                        <span
                            class="grid size-12 place-items-center rounded-2xl bg-indigo-100 text-indigo-700"
                            ><BookOpen /></span
                        ><span
                            class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700"
                            >{{ module.lessons_count }} pelajaran</span
                        >
                    </div>
                    <h3 class="mt-5 text-xl font-black">{{ module.title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        {{ module.description }}
                    </p>
                </article>
            </div>
        </section>
    </div>
</template>
