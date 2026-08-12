<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { BadgeDollarSign, Check, Users } from '@lucide/vue';
type Package = {
    code: string;
    name: string;
    price_sen: number;
    child_limit: number | null;
    reseller: boolean;
    users: number;
    paid_orders: number;
    revenue_sen: number;
};
defineProps<{ packages: Package[] }>();
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
</script>
<template>
    <Head title="Senarai pakej" />
    <div class="space-y-6 p-4 md:p-7">
        <header>
            <p class="text-sm font-black text-indigo-600">ADMIN JOMKID</p>
            <h1 class="mt-1 text-3xl font-black">Senarai pakej</h1>
            <p class="mt-2 text-slate-500">
                Prestasi pakej lifetime dan entitlement pelanggan.
            </p>
        </header>
        <section class="grid gap-5 lg:grid-cols-2">
            <article
                v-for="item in packages"
                :key="item.code"
                class="rounded-3xl border bg-white p-6"
            >
                <div class="flex justify-between gap-4">
                    <div>
                        <p class="text-xs font-black text-indigo-600 uppercase">
                            {{ item.code }}
                        </p>
                        <h2 class="mt-1 text-2xl font-black">
                            {{ item.name }}
                        </h2>
                    </div>
                    <strong class="text-3xl">{{
                        money(item.price_sen)
                    }}</strong>
                </div>
                <ul class="mt-6 grid gap-3 text-sm font-semibold">
                    <li class="flex gap-2">
                        <Check class="size-5 text-emerald-600" />{{
                            item.child_limit === null
                                ? 'Unlimited profil anak'
                                : `Maksimum ${item.child_limit} profil anak`
                        }}
                    </li>
                    <li class="flex gap-2">
                        <Check class="size-5 text-emerald-600" />{{
                            item.reseller
                                ? 'Reseller license + affiliate 50%'
                                : 'Tiada reseller/affiliate license'
                        }}
                    </li>
                </ul>
                <div
                    class="mt-7 grid grid-cols-3 gap-3 border-t pt-5 text-center"
                >
                    <div>
                        <Users class="mx-auto size-5 text-indigo-600" />
                        <p class="mt-2 text-xl font-black">{{ item.users }}</p>
                        <p class="text-xs text-slate-500">Pengguna</p>
                    </div>
                    <div>
                        <BadgeDollarSign
                            class="mx-auto size-5 text-emerald-600"
                        />
                        <p class="mt-2 text-xl font-black">
                            {{ item.paid_orders }}
                        </p>
                        <p class="text-xs text-slate-500">Jualan</p>
                    </div>
                    <div>
                        <p class="text-xl font-black">
                            {{ money(item.revenue_sen) }}
                        </p>
                        <p class="text-xs text-slate-500">Hasil</p>
                    </div>
                </div>
            </article>
        </section>
    </div>
</template>
