<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { Plus, ShieldCheck, Trash2 } from '@lucide/vue';

type Child = {
    id: number;
    display_name: string;
    birth_year: number | null;
    avatar_key: string;
    xp: number;
    current_level: number;
    leaderboard_opt_in: boolean;
};
defineProps<{ children: Child[]; limit: number | null }>();
const form = useForm({
    display_name: '',
    birth_year: 2020,
    avatar_key: 'owl-indigo',
    leaderboard_opt_in: false,
});
const submit = () =>
    form.post('/children', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
const remove = (child: Child) => {
    if (window.confirm(`Buang profil ${child.display_name}?`)) {
        router.delete(`/children/${child.id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Profil anak" />
    <div class="grid gap-7 p-4 md:p-7 lg:grid-cols-[1fr_380px]">
        <section>
            <p class="text-sm font-bold text-indigo-600">KELUARGA</p>
            <h1 class="mt-1 text-3xl font-black">Profil anak</h1>
            <p class="mt-2 text-slate-500">
                Gunakan nama panggilan sahaja untuk melindungi privasi anak.
            </p>
            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <article
                    v-for="child in children"
                    :key="child.id"
                    class="rounded-3xl border bg-white p-6"
                >
                    <div class="flex justify-between">
                        <span
                            class="grid size-14 place-items-center rounded-2xl bg-indigo-100 text-2xl"
                            >🦉</span
                        ><button
                            class="grid size-9 place-items-center rounded-full text-slate-400 hover:bg-rose-50 hover:text-rose-600"
                            @click="remove(child)"
                        >
                            <Trash2 class="size-4" />
                        </button>
                    </div>
                    <h2 class="mt-4 text-xl font-black">
                        {{ child.display_name }}
                    </h2>
                    <p class="text-sm text-slate-500">
                        Lahir {{ child.birth_year || '—' }} · Tahap
                        {{ child.current_level }}
                    </p>
                    <div
                        class="mt-4 flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-semibold"
                    >
                        <ShieldCheck class="size-4 text-emerald-600" /> Ranking
                        {{
                            child.leaderboard_opt_in
                                ? 'diaktifkan'
                                : 'tidak diaktifkan'
                        }}
                    </div>
                </article>
                <div
                    v-if="children.length === 0"
                    class="rounded-3xl border border-dashed p-10 text-center text-slate-500 sm:col-span-2"
                >
                    Belum ada profil anak.
                </div>
            </div>
        </section>
        <aside class="h-fit rounded-3xl border bg-white p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-black">Tambah profil</h2>
                <span class="text-sm font-bold text-slate-500"
                    >{{ children.length }}/{{ limit ?? '∞' }}</span
                >
            </div>
            <form class="mt-6 space-y-4" @submit.prevent="submit">
                <label class="block text-sm font-bold"
                    >Nama panggilan<input
                        v-model="form.display_name"
                        class="mt-2 w-full rounded-xl border px-4 py-3 outline-none focus:border-indigo-500"
                        maxlength="40"
                        required /></label
                ><label class="block text-sm font-bold"
                    >Tahun lahir<input
                        v-model.number="form.birth_year"
                        type="number"
                        min="2016"
                        max="2023"
                        class="mt-2 w-full rounded-xl border px-4 py-3 outline-none focus:border-indigo-500" /></label
                ><label class="block text-sm font-bold"
                    >Warna avatar<select
                        v-model="form.avatar_key"
                        class="mt-2 w-full rounded-xl border px-4 py-3"
                    >
                        <option value="owl-indigo">Indigo</option>
                        <option value="owl-coral">Coral</option>
                        <option value="owl-yellow">Kuning</option>
                    </select></label
                ><label class="flex gap-3 rounded-2xl bg-slate-50 p-4 text-sm"
                    ><input
                        v-model="form.leaderboard_opt_in"
                        type="checkbox"
                    /><span
                        ><strong>Benarkan ranking selamat</strong><br /><span
                            class="text-slate-500"
                            >Hanya alias dan avatar akan dipaparkan.</span
                        ></span
                    ></label
                >
                <p
                    v-if="form.errors.display_name"
                    class="text-sm text-rose-600"
                >
                    {{ form.errors.display_name }}
                </p>
                <button
                    :disabled="
                        form.processing ||
                        (limit !== null && children.length >= limit)
                    "
                    class="flex w-full items-center justify-center gap-2 rounded-full bg-indigo-600 px-5 py-3 font-black text-white disabled:opacity-40"
                >
                    <Plus class="size-4" /> Tambah profil
                </button>
            </form>
        </aside>
    </div>
</template>
