<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { BookOpen, CreditCard, ShieldCheck, Users } from '@lucide/vue';
type Metrics = {
    users: number;
    children: number;
    modules: number;
    active_subscriptions: number;
    pending_commission_sen: number;
};
type User = {
    id: number;
    name: string;
    email: string;
    role: string;
    created_at: string;
};
defineProps<{ metrics: Metrics; recentUsers: User[] }>();
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
</script>
<template>
    <Head title="Admin" />
    <div class="space-y-7 p-4 md:p-7">
        <header>
            <div class="flex items-center gap-3">
                <span
                    class="grid size-12 place-items-center rounded-2xl bg-slate-950 text-white"
                    ><ShieldCheck
                /></span>
                <div>
                    <p class="text-sm font-bold text-indigo-600">
                        ADMIN JOMABC
                    </p>
                    <h1 class="text-3xl font-black">Gambaran sistem</h1>
                </div>
            </div>
        </header>
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-3xl border bg-white p-6">
                <Users class="text-indigo-600" />
                <p class="mt-4 text-3xl font-black">{{ metrics.users }}</p>
                <p class="text-sm text-slate-500">Pengguna</p>
            </article>
            <article class="rounded-3xl border bg-white p-6">
                <Users class="text-rose-500" />
                <p class="mt-4 text-3xl font-black">{{ metrics.children }}</p>
                <p class="text-sm text-slate-500">Profil anak</p>
            </article>
            <article class="rounded-3xl border bg-white p-6">
                <BookOpen class="text-amber-500" />
                <p class="mt-4 text-3xl font-black">{{ metrics.modules }}</p>
                <p class="text-sm text-slate-500">Modul pembelajaran</p>
            </article>
            <article class="rounded-3xl border bg-white p-6">
                <CreditCard class="text-emerald-600" />
                <p class="mt-4 text-3xl font-black">
                    {{ metrics.active_subscriptions }}
                </p>
                <p class="text-sm text-slate-500">Langganan aktif</p>
            </article>
        </section>
        <section class="grid gap-6 xl:grid-cols-[1fr_320px]">
            <div class="rounded-3xl border bg-white p-6">
                <h2 class="text-xl font-black">Pengguna terbaru</h2>
                <div class="mt-4 divide-y">
                    <div
                        v-for="user in recentUsers"
                        :key="user.id"
                        class="flex items-center justify-between gap-4 py-4"
                    >
                        <div>
                            <p class="font-bold">{{ user.name }}</p>
                            <p class="text-sm text-slate-500">
                                {{ user.email }}
                            </p>
                        </div>
                        <span
                            class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black uppercase"
                            >{{ user.role }}</span
                        >
                    </div>
                </div>
            </div>
            <aside class="rounded-3xl bg-indigo-950 p-6 text-white">
                <p class="text-sm font-bold text-indigo-200">KOMISEN PENDING</p>
                <p class="mt-3 text-3xl font-black">
                    {{ money(metrics.pending_commission_sen) }}
                </p>
                <p class="mt-3 text-sm leading-6 text-indigo-100">
                    Komisen hanya boleh tersedia selepas tempoh refund tamat.
                </p>
            </aside>
        </section>
    </div>
</template>
