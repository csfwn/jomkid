<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Search, BadgeDollarSign } from '@lucide/vue';
import { ref } from 'vue';
type Row = {
    id: number;
    name: string;
    email: string;
    affiliate_code: string;
    package_code: string;
    sales_count: number;
    commission_sen: number | null;
    created_at: string;
};
type Pager = {
    data: Row[];
    prev_page_url: string | null;
    next_page_url: string | null;
    total: number;
};
const props = defineProps<{ affiliates: Pager; filters: { search: string } }>();
const search = ref(props.filters.search);
const submit = () =>
    router.get(
        '/admin/affiliates',
        { search: search.value },
        { preserveState: true, replace: true },
    );
const money = (sen: number | null) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format((sen ?? 0) / 100);
</script>
<template>
    <Head title="Senarai affiliate" />
    <div class="space-y-6 p-4 md:p-7">
        <header>
            <p class="text-sm font-black text-indigo-600">ADMIN JOMKID</p>
            <h1 class="mt-1 text-3xl font-black">Senarai affiliate</h1>
            <p class="mt-2 text-slate-500">
                Reseller Premium, referral link dan prestasi komisen.
            </p>
        </header>
        <form class="flex max-w-xl gap-2" @submit.prevent="submit">
            <div class="relative flex-1">
                <Search
                    class="absolute top-3.5 left-4 size-5 text-slate-400"
                /><input
                    v-model="search"
                    class="w-full rounded-full border bg-white py-3 pr-4 pl-12"
                    placeholder="Cari nama, e-mel atau kod"
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
                            <th class="p-4">Affiliate</th>
                            <th>Kod</th>
                            <th>Pakej</th>
                            <th>Jualan</th>
                            <th>Komisen</th>
                            <th>Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="item in affiliates.data" :key="item.id">
                            <td class="p-4">
                                <p class="font-bold">{{ item.name }}</p>
                                <p class="text-slate-500">{{ item.email }}</p>
                            </td>
                            <td>
                                <code
                                    class="rounded bg-indigo-50 px-2 py-1 font-black text-indigo-700"
                                    >{{ item.affiliate_code }}</code
                                >
                            </td>
                            <td class="capitalize">{{ item.package_code }}</td>
                            <td>{{ item.sales_count }}</td>
                            <td class="font-black">
                                {{ money(item.commission_sen) }}
                            </td>
                            <td>
                                {{
                                    new Date(
                                        item.created_at,
                                    ).toLocaleDateString('ms-MY')
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="!affiliates.data.length"
                class="p-10 text-center text-slate-500"
            >
                <BadgeDollarSign class="mx-auto mb-3" />Tiada affiliate
                dijumpai.
            </div>
        </section>
        <div class="flex items-center justify-between text-sm">
            <span>{{ affiliates.total }} affiliate</span>
            <div class="flex gap-2">
                <button
                    :disabled="!affiliates.prev_page_url"
                    class="rounded-full border px-4 py-2 disabled:opacity-40"
                    @click="
                        affiliates.prev_page_url &&
                        router.get(affiliates.prev_page_url)
                    "
                >
                    Sebelum</button
                ><button
                    :disabled="!affiliates.next_page_url"
                    class="rounded-full border px-4 py-2 disabled:opacity-40"
                    @click="
                        affiliates.next_page_url &&
                        router.get(affiliates.next_page_url)
                    "
                >
                    Seterusnya
                </button>
            </div>
        </div>
    </div>
</template>
