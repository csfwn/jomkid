<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Search, GraduationCap } from '@lucide/vue';
import { ref } from 'vue';
type Row = {
    id: number;
    display_name: string;
    birth_year: number | null;
    leaderboard_opt_in: boolean;
    attempts_count: number;
    attempts_avg_accuracy: string | null;
    created_at: string;
    user: { name: string; email: string; package_code: string };
};
type Pager = {
    data: Row[];
    prev_page_url: string | null;
    next_page_url: string | null;
    total: number;
};
const props = defineProps<{
    students: Pager;
    filters: { search: string };
    currentYear: number;
}>();
const search = ref(props.filters.search);
const submit = () =>
    router.get(
        '/admin/students',
        { search: search.value },
        { preserveState: true, replace: true },
    );
</script>
<template>
    <Head title="Senarai pelajar" />
    <div class="space-y-6 p-4 md:p-7">
        <header>
            <p class="text-sm font-black text-indigo-600">ADMIN JOMKID</p>
            <h1 class="mt-1 text-3xl font-black">Senarai pelajar</h1>
            <p class="mt-2 text-slate-500">
                Profil anak, pemilik akaun dan aktiviti pembelajaran.
            </p>
        </header>
        <form class="flex max-w-xl gap-2" @submit.prevent="submit">
            <div class="relative flex-1">
                <Search
                    class="absolute top-3.5 left-4 size-5 text-slate-400"
                /><input
                    v-model="search"
                    class="w-full rounded-full border bg-white py-3 pr-4 pl-12"
                    placeholder="Cari pelajar atau ibu bapa"
                />
            </div>
            <button
                class="rounded-full bg-slate-950 px-5 font-black text-white"
            >
                Cari
            </button>
        </form>
        <section class="overflow-hidden rounded-3xl border bg-white">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs text-slate-500 uppercase">
                        <tr>
                            <th class="p-4">Pelajar</th>
                            <th>Ibu bapa</th>
                            <th>Pakej</th>
                            <th>Umur</th>
                            <th>Aktiviti</th>
                            <th>Ketepatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="student in students.data" :key="student.id">
                            <td class="p-4 font-bold">
                                {{ student.display_name }}
                            </td>
                            <td>
                                <p class="font-semibold">
                                    {{ student.user.name }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    {{ student.user.email }}
                                </p>
                            </td>
                            <td class="capitalize">
                                {{ student.user.package_code }}
                            </td>
                            <td>
                                {{
                                    student.birth_year
                                        ? currentYear - student.birth_year
                                        : '—'
                                }}
                            </td>
                            <td>{{ student.attempts_count }} cubaan</td>
                            <td>
                                {{
                                    student.attempts_avg_accuracy
                                        ? `${Number(student.attempts_avg_accuracy).toFixed(1)}%`
                                        : '—'
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="!students.data.length"
                class="p-10 text-center text-slate-500"
            >
                <GraduationCap class="mx-auto mb-3" />Tiada pelajar dijumpai.
            </div>
        </section>
        <div class="flex items-center justify-between text-sm">
            <span>{{ students.total }} pelajar</span>
            <div class="flex gap-2">
                <button
                    :disabled="!students.prev_page_url"
                    class="rounded-full border px-4 py-2 disabled:opacity-40"
                    @click="
                        students.prev_page_url &&
                        router.get(students.prev_page_url)
                    "
                >
                    Sebelum</button
                ><button
                    :disabled="!students.next_page_url"
                    class="rounded-full border px-4 py-2 disabled:opacity-40"
                    @click="
                        students.next_page_url &&
                        router.get(students.next_page_url)
                    "
                >
                    Seterusnya
                </button>
            </div>
        </div>
    </div>
</template>
