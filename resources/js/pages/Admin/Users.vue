<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Search, Users } from '@lucide/vue';
import { ref } from 'vue';
type Row = {
    id: number;
    name: string;
    email: string;
    role: string;
    package_code: string | null;
    access_status: string;
    child_profiles_count: number;
    created_at: string;
};
type Pager = {
    data: Row[];
    current_page: number;
    last_page: number;
    prev_page_url: string | null;
    next_page_url: string | null;
    total: number;
};
const props = defineProps<{ users: Pager; filters: { search: string } }>();
const search = ref(props.filters.search);
const submit = () =>
    router.get(
        '/admin/users',
        { search: search.value },
        { preserveState: true, replace: true },
    );
</script>
<template>
    <Head title="Senarai pengguna" />
    <div class="space-y-6 p-4 md:p-7">
        <header>
            <p class="text-sm font-black text-indigo-600">ADMIN JOMKID</p>
            <h1 class="mt-1 text-3xl font-black">Senarai pengguna</h1>
            <p class="mt-2 text-slate-500">
                Semua akaun pelanggan dan akses pakej.
            </p>
        </header>
        <form class="flex max-w-xl gap-2" @submit.prevent="submit">
            <div class="relative flex-1">
                <Search
                    class="absolute top-3.5 left-4 size-5 text-slate-400"
                /><input
                    v-model="search"
                    class="w-full rounded-full border bg-white py-3 pr-4 pl-12"
                    placeholder="Cari nama atau e-mel"
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
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs text-slate-500 uppercase">
                        <tr>
                            <th class="p-4">Pengguna</th>
                            <th>Pakej</th>
                            <th>Akses</th>
                            <th>Profil anak</th>
                            <th>Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="p-4">
                                <p class="font-bold">{{ user.name }}</p>
                                <p class="text-slate-500">{{ user.email }}</p>
                            </td>
                            <td class="font-bold capitalize">
                                {{ user.package_code ?? '—' }}
                            </td>
                            <td>
                                <span
                                    class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700 uppercase"
                                    >{{ user.access_status }}</span
                                >
                            </td>
                            <td>{{ user.child_profiles_count }}</td>
                            <td>
                                {{
                                    new Date(
                                        user.created_at,
                                    ).toLocaleDateString('ms-MY')
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="!users.data.length"
                class="p-10 text-center text-slate-500"
            >
                <Users class="mx-auto mb-3" />Tiada pengguna dijumpai.
            </div>
        </section>
        <div class="flex items-center justify-between text-sm">
            <span>{{ users.total }} pengguna</span>
            <div class="flex gap-2">
                <button
                    :disabled="!users.prev_page_url"
                    class="rounded-full border px-4 py-2 disabled:opacity-40"
                    @click="
                        users.prev_page_url && router.get(users.prev_page_url)
                    "
                >
                    Sebelum</button
                ><button
                    :disabled="!users.next_page_url"
                    class="rounded-full border px-4 py-2 disabled:opacity-40"
                    @click="
                        users.next_page_url && router.get(users.next_page_url)
                    "
                >
                    Seterusnya
                </button>
            </div>
        </div>
    </div>
</template>
