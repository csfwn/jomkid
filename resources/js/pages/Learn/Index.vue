<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { BookOpen, LockKeyhole, Mic2, Play, Star } from '@lucide/vue';
type Child = { id: number; display_name: string; avatar_key: string };
type Lesson = {
    id: number;
    title: string;
    description: string;
    duration_minutes: number;
    xp_reward: number;
};
type Module = {
    id: number;
    title: string;
    subject: string;
    description: string;
    lessons: Lesson[];
};
defineProps<{ children: Child[]; modules: Module[] }>();
</script>
<template>
    <Head title="Belajar" />
    <div class="space-y-7 p-4 md:p-7">
        <header>
            <p class="text-sm font-bold text-indigo-600">RUANG BELAJAR</p>
            <h1 class="mt-1 text-3xl font-black">Pilih pelajaran hari ini</h1>
            <p class="mt-2 text-slate-500">
                Sesi pendek 5–10 minit dengan suara, sentuhan dan ganjaran XP.
            </p>
        </header>
        <div
            v-if="!children.length"
            class="rounded-3xl border border-dashed bg-white p-10 text-center"
        >
            <LockKeyhole class="mx-auto text-indigo-500" />
            <h2 class="mt-3 text-xl font-black">Tambah profil anak dahulu</h2>
            <a
                href="/children"
                class="mt-5 inline-flex rounded-full bg-slate-950 px-5 py-3 font-bold text-white"
                >Tambah profil</a
            >
        </div>
        <section
            v-for="module in modules"
            :key="module.id"
            class="rounded-3xl border bg-white p-6 md:p-8"
        >
            <div class="flex flex-col justify-between gap-4 sm:flex-row">
                <div>
                    <span
                        class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-black text-indigo-700"
                        >{{ module.subject }}</span
                    >
                    <h2 class="mt-3 text-2xl font-black">{{ module.title }}</h2>
                    <p class="mt-2 max-w-2xl text-slate-500">
                        {{ module.description }}
                    </p>
                </div>
                <span
                    class="grid size-14 place-items-center rounded-2xl bg-yellow-100 text-yellow-700"
                    ><BookOpen
                /></span>
            </div>
            <div class="mt-6 grid gap-3">
                <article
                    v-for="(lesson, index) in module.lessons"
                    :key="lesson.id"
                    class="flex flex-col items-start justify-between gap-4 rounded-2xl border p-4 sm:flex-row sm:items-center"
                >
                    <div class="flex items-center gap-4">
                        <span
                            class="grid size-11 place-items-center rounded-xl bg-indigo-600 font-black text-white"
                            >{{ index + 1 }}</span
                        >
                        <div>
                            <h3 class="font-black">{{ lesson.title }}</h3>
                            <p class="text-sm text-slate-500">
                                {{ lesson.description }}
                            </p>
                            <div
                                class="mt-2 flex gap-3 text-xs font-bold text-slate-500"
                            >
                                <span class="flex gap-1"
                                    ><Mic2 class="size-3" />
                                    {{ lesson.duration_minutes }} min</span
                                ><span class="flex gap-1"
                                    ><Star class="size-3 text-yellow-600" />
                                    {{ lesson.xp_reward }} XP</span
                                >
                            </div>
                        </div>
                    </div>
                    <button
                        class="flex items-center gap-2 rounded-full bg-slate-950 px-5 py-2.5 text-sm font-black text-white"
                    >
                        <Play class="size-4" /> Mula
                    </button>
                </article>
            </div>
        </section>
    </div>
</template>
