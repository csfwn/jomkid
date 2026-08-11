<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    Check,
    CreditCard,
    KeyRound,
    LockKeyhole,
    MailCheck,
} from '@lucide/vue';

type Package = {
    code: 'basic' | 'premium';
    name: string;
    price_sen: number;
    child_limit: number | null;
    reseller: boolean;
};

const props = defineProps<{
    packages: Package[];
    defaultPackage: 'basic' | 'premium';
}>();
const form = useForm({
    name: '',
    email: '',
    package: props.defaultPackage,
    payment: '',
});
const selectedPackage = computed(() =>
    props.packages.find((item) => item.code === form.package)!,
);
const pay = () => form.post('/checkout');
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
</script>

<template>
    <Head title="Beli akses lifetime JomKid" />
    <div class="min-h-screen bg-slate-50 text-slate-950">
        <header class="border-b bg-white">
            <div
                class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 md:px-8"
            >
                <Link href="/" class="text-xl font-black">JomKid</Link>
                <Link href="/login" class="text-sm font-bold text-slate-600"
                    >Log masuk</Link
                >
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl p-4 py-10 md:p-8 md:py-16">
            <header class="mb-8 max-w-2xl">
                <p class="text-sm font-black text-indigo-600">
                    AKSES LIFETIME JOMKID
                </p>
                <h1 class="mt-2 text-3xl font-black tracking-tight md:text-5xl">
                    Bayar sekali. Belajar tanpa had masa.
                </h1>
                <p class="mt-4 leading-7 text-slate-500">
                    Selepas CHIP mengesahkan pembayaran, satu kod pendaftaran
                    sekali guna akan dihantar ke e-mel anda.
                </p>
            </header>

            <div class="grid gap-6 lg:grid-cols-[1fr_400px]">
                <section class="rounded-3xl border bg-white p-6 md:p-8">
                    <div class="mb-8 grid gap-3 sm:grid-cols-2">
                        <button
                            v-for="item in packages"
                            :key="item.code"
                            type="button"
                            class="rounded-2xl border-2 p-4 text-left transition"
                            :class="
                                form.package === item.code
                                    ? 'border-indigo-600 bg-indigo-50'
                                    : 'border-slate-200 hover:border-slate-400'
                            "
                            @click="form.package = item.code"
                        >
                            <span class="text-sm font-black text-indigo-600">{{
                                item.code === 'premium'
                                    ? 'PREMIUM + RESELLER'
                                    : 'BASIC'
                            }}</span>
                            <strong class="mt-1 block text-2xl">{{
                                money(item.price_sen)
                            }}</strong>
                            <span class="text-sm text-slate-500">
                                {{
                                    item.child_limit === null
                                        ? 'Unlimited profil anak + affiliate'
                                        : `${item.child_limit} profil anak`
                                }}
                            </span>
                        </button>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-500">
                                BAYARAN SEKALI
                            </p>
                            <h2 class="mt-1 text-2xl font-black">
                                {{ selectedPackage.name }}
                            </h2>
                        </div>
                        <span
                            class="grid size-12 place-items-center rounded-2xl bg-indigo-100 text-indigo-700"
                        >
                            <KeyRound />
                        </span>
                    </div>
                    <div class="mt-8 flex items-end gap-2 border-b pb-8">
                        <strong class="text-5xl font-black">{{
                            money(selectedPackage.price_sen)
                        }}</strong>
                        <span class="pb-1 text-slate-500">sekali sahaja</span>
                    </div>
                    <ul class="mt-7 grid gap-4 sm:grid-cols-2">
                        <li class="flex items-center gap-3 font-semibold">
                            <Check class="size-5 text-emerald-600" />
                            {{
                                selectedPackage.child_limit === null
                                    ? 'Unlimited profil anak'
                                    : `Sehingga ${selectedPackage.child_limit} profil anak`
                            }}
                        </li>
                        <li class="flex items-center gap-3 font-semibold">
                            <Check class="size-5 text-emerald-600" /> Akses
                            lifetime
                        </li>
                        <li class="flex items-center gap-3 font-semibold">
                            <Check class="size-5 text-emerald-600" /> Semua
                            modul JomKid
                        </li>
                        <li class="flex items-center gap-3 font-semibold">
                            <Check class="size-5 text-emerald-600" /> Laporan
                            perkembangan
                        </li>
                        <li
                            v-if="selectedPackage.reseller"
                            class="flex items-center gap-3 font-semibold"
                        >
                            <Check class="size-5 text-emerald-600" /> Reseller
                            license + link affiliate 50%
                        </li>
                    </ul>
                    <div
                        class="mt-8 grid gap-3 rounded-2xl bg-slate-50 p-5 text-sm text-slate-600"
                    >
                        <p class="flex items-center gap-3">
                            <CreditCard class="size-5 text-indigo-600" /> 1.
                            Bayar {{ money(selectedPackage.price_sen) }} melalui
                            CHIP
                        </p>
                        <p class="flex items-center gap-3">
                            <MailCheck class="size-5 text-indigo-600" /> 2. Kod
                            sekali guna dihantar ke e-mel
                        </p>
                        <p class="flex items-center gap-3">
                            <KeyRound class="size-5 text-indigo-600" /> 3.
                            Daftar menggunakan kod tersebut
                        </p>
                    </div>
                </section>

                <aside
                    class="h-fit rounded-3xl bg-indigo-950 p-6 text-white md:p-7"
                >
                    <LockKeyhole class="size-8 text-yellow-300" />
                    <h2 class="mt-4 text-xl font-black">Maklumat pembeli</h2>
                    <p class="mt-2 text-sm leading-6 text-indigo-100">
                        Pastikan e-mel betul. Kod pendaftaran akan dihantar ke
                        alamat ini sahaja.
                    </p>
                    <form class="mt-6 grid gap-4" @submit.prevent="pay">
                        <label class="grid gap-2 text-sm font-bold">
                            Nama penuh
                            <input
                                v-model="form.name"
                                required
                                autocomplete="name"
                                class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 font-normal text-white outline-none placeholder:text-indigo-300 focus:border-yellow-300"
                                placeholder="Nama penuh"
                            />
                            <span
                                v-if="form.errors.name"
                                class="text-xs text-rose-200"
                                >{{ form.errors.name }}</span
                            >
                        </label>
                        <label class="grid gap-2 text-sm font-bold">
                            E-mel untuk menerima kod
                            <input
                                v-model="form.email"
                                required
                                type="email"
                                autocomplete="email"
                                class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 font-normal text-white outline-none placeholder:text-indigo-300 focus:border-yellow-300"
                                placeholder="email@example.com"
                            />
                            <span
                                v-if="form.errors.email"
                                class="text-xs text-rose-200"
                                >{{ form.errors.email }}</span
                            >
                        </label>
                        <div
                            class="mt-2 flex items-center justify-between border-y border-white/15 py-5"
                        >
                            <span class="font-bold">Jumlah</span>
                            <strong class="text-2xl">{{
                                money(selectedPackage.price_sen)
                            }}</strong>
                        </div>
                        <p
                            v-if="form.errors.payment"
                            class="rounded-2xl bg-rose-500/20 p-3 text-sm text-rose-100"
                        >
                            {{ form.errors.payment }}
                        </p>
                        <button
                            :disabled="form.processing"
                            class="flex w-full items-center justify-center gap-2 rounded-full bg-yellow-300 px-5 py-3 font-black text-indigo-950 disabled:opacity-50"
                            type="submit"
                        >
                            <CreditCard class="size-5" />
                            {{
                                form.processing
                                    ? 'Menyediakan pembayaran…'
                                    : `Bayar ${money(selectedPackage.price_sen)} dengan CHIP`
                            }}
                        </button>
                    </form>
                    <p
                        class="mt-4 text-center text-xs leading-5 text-indigo-200"
                    >
                        Kod hanya dikeluarkan selepas pembayaran disahkan pada
                        server JomKid.
                    </p>
                </aside>
            </div>
        </main>
    </div>
</template>
