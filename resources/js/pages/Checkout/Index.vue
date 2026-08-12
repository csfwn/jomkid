<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Check, ChevronLeft, CreditCard, Mail, Users } from '@lucide/vue';
import { computed } from 'vue';

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
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
const pay = () => form.post('/checkout');
</script>

<template>
    <Head title="Pilih akses lifetime JomKid"
        ><meta
            name="description"
            content="Pilih pakej lifetime JomKid dan teruskan pembayaran melalui CHIP."
    /></Head>
    <div class="min-h-screen overflow-x-clip bg-[#FFF9E8] text-[#17213B]">
        <header class="bg-[#FFF9E8]">
            <div
                class="mx-auto flex min-h-20 max-w-6xl items-center justify-between px-5 lg:px-8"
            >
                <Link
                    href="/"
                    class="flex min-h-11 items-center gap-3 rounded-full focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#E0A800]"
                    ><span
                        class="grid size-11 place-items-center rounded-2xl bg-[#FFD84D] text-xl font-black shadow-[0_4px_0_#E0A800]"
                        >J</span
                    ><span class="text-2xl font-black tracking-[-0.04em]"
                        >JomKid</span
                    ></Link
                >
                <Link
                    href="/"
                    class="inline-flex min-h-11 items-center gap-2 rounded-full px-3 text-sm font-bold hover:bg-white"
                    ><ChevronLeft class="size-4" /> Kembali</Link
                >
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-5 pt-6 pb-20 lg:px-8 lg:pt-10">
            <div class="mx-auto max-w-2xl text-center">
                <div
                    class="mx-auto flex max-w-xs items-center gap-3"
                    aria-label="Langkah 1 daripada 2"
                >
                    <span class="h-2 flex-1 rounded-full bg-[#FFD84D]"></span
                    ><span class="h-2 flex-1 rounded-full bg-[#E2E5EC]"></span>
                </div>
                <p class="mt-5 text-sm font-black text-[#B36A00]">
                    LANGKAH 1 DARIPADA 2
                </p>
                <h1
                    class="mt-3 text-4xl leading-tight font-black tracking-[-0.05em] sm:text-6xl"
                >
                    Pilih akses keluarga.
                </h1>
                <p class="mt-4 text-lg leading-8 text-[#65708E]">
                    Bayar sekali. Kod pendaftaran dihantar ke e-mel selepas CHIP
                    mengesahkan bayaran.
                </p>
            </div>

            <div
                class="mt-12 grid gap-8 lg:grid-cols-[1.1fr_.9fr] lg:items-start"
            >
                <section aria-labelledby="package-heading">
                    <h2 id="package-heading" class="text-xl font-black">
                        1. Pilih pakej
                    </h2>
                    <div
                        role="radiogroup"
                        aria-labelledby="package-heading"
                        class="mt-4 grid gap-4 sm:grid-cols-2"
                    >
                        <button
                            v-for="item in packages"
                            :key="item.code"
                            type="button"
                            role="radio"
                            :aria-checked="form.package === item.code"
                            class="relative min-h-72 rounded-[30px] p-6 text-left transition hover:-translate-y-1 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#17213B]"
                            :class="
                                form.package === item.code
                                    ? item.code === 'basic'
                                        ? 'bg-[#FFD84D] shadow-[0_10px_30px_rgba(224,168,0,.2)] ring-3 ring-[#17213B]'
                                        : 'bg-[#17213B] text-white shadow-[0_10px_30px_rgba(23,33,59,.2)] ring-3 ring-[#FFD84D]'
                                    : 'bg-white ring-1 ring-[#DDE1E9]'
                            "
                            @click="form.package = item.code"
                        >
                            <span
                                v-if="form.package === item.code"
                                class="absolute top-5 right-5 grid size-8 place-items-center rounded-full"
                                :class="
                                    item.code === 'premium'
                                        ? 'bg-[#FFD84D] text-[#17213B]'
                                        : 'bg-[#17213B] text-white'
                                "
                                ><Check class="size-4"
                            /></span>
                            <p
                                class="text-xs font-black"
                                :class="
                                    item.code === 'premium' &&
                                    form.package === item.code
                                        ? 'text-[#FFD84D]'
                                        : 'text-[#65708E]'
                                "
                            >
                                {{
                                    item.code === 'premium'
                                        ? 'PREMIUM + RESELLER'
                                        : 'BASIC'
                                }}
                            </p>
                            <p class="mt-4 text-4xl font-black">
                                {{ money(item.price_sen) }}
                            </p>
                            <p class="mt-1 text-sm font-semibold opacity-70">
                                sekali bayar
                            </p>
                            <div class="mt-10">
                                <p class="text-lg font-black">
                                    {{
                                        item.child_limit === null
                                            ? 'Profil anak tanpa had'
                                            : `${item.child_limit} profil anak`
                                    }}
                                </p>
                                <p class="mt-3 text-sm leading-6 opacity-75">
                                    {{
                                        item.reseller
                                            ? 'Termasuk reseller license dan affiliate langsung 50%.'
                                            : 'Untuk keluarga tanpa hak reseller atau affiliate.'
                                    }}
                                </p>
                            </div>
                        </button>
                    </div>

                    <div
                        class="mt-8 rounded-[30px] bg-white p-6 ring-1 ring-[#DDE1E9] sm:p-8"
                    >
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-bold text-[#65708E]">
                                    Pilihan anda
                                </p>
                                <h3 class="mt-1 text-2xl font-black">
                                    {{ selectedPackage.name }}
                                </h3>
                            </div>
                            <strong class="text-3xl">{{
                                money(selectedPackage.price_sen)
                            }}</strong>
                        </div>
                        <ul
                            class="mt-6 grid gap-3 text-sm font-semibold sm:grid-cols-2"
                        >
                            <li class="flex gap-2">
                                <Check class="size-5 text-[#4B9A67]" />{{
                                    selectedPackage.child_limit === null
                                        ? 'Profil tanpa had'
                                        : `Maksimum ${selectedPackage.child_limit} profil`
                                }}
                            </li>
                            <li class="flex gap-2">
                                <Check class="size-5 text-[#4B9A67]" />Akses
                                lifetime
                            </li>
                            <li class="flex gap-2">
                                <Check class="size-5 text-[#4B9A67]" />Laporan
                                ibu bapa
                            </li>
                            <li
                                v-if="selectedPackage.reseller"
                                class="flex gap-2"
                            >
                                <Check class="size-5 text-[#4B9A67]" />Affiliate
                                langsung 50%
                            </li>
                        </ul>
                    </div>
                </section>

                <aside class="lg:sticky lg:top-6">
                    <section class="rounded-[32px] bg-[#DDF2FF] p-6 sm:p-8">
                        <p class="text-sm font-black text-[#2075A5]">
                            LANGKAH 2 DARIPADA 2
                        </p>
                        <h2 class="mt-2 text-3xl font-black tracking-[-0.04em]">
                            Maklumat pembeli
                        </h2>
                        <p class="mt-3 leading-7 text-[#4D6070]">
                            Gunakan e-mel yang boleh dibuka. Kod pendaftaran
                            hanya dihantar ke alamat ini.
                        </p>
                        <form class="mt-7 grid gap-5" @submit.prevent="pay">
                            <label class="grid gap-2 text-sm font-black"
                                >Nama penuh<input
                                    v-model="form.name"
                                    required
                                    autocomplete="name"
                                    class="min-h-14 rounded-2xl bg-white px-4 font-semibold ring-1 ring-[#B7D9EC] placeholder:font-normal focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[#2075A5]"
                                    placeholder="Nama pembeli"
                                /><span
                                    v-if="form.errors.name"
                                    class="font-semibold text-[#A83C28]"
                                    >{{ form.errors.name }}</span
                                ></label
                            >
                            <label class="grid gap-2 text-sm font-black"
                                >E-mel untuk menerima kod<input
                                    v-model="form.email"
                                    required
                                    type="email"
                                    autocomplete="email"
                                    class="min-h-14 rounded-2xl bg-white px-4 font-semibold ring-1 ring-[#B7D9EC] placeholder:font-normal focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[#2075A5]"
                                    placeholder="nama@email.com"
                                /><span
                                    v-if="form.errors.email"
                                    class="font-semibold text-[#A83C28]"
                                    >{{ form.errors.email }}</span
                                ></label
                            >
                            <p
                                v-if="form.errors.package"
                                class="rounded-2xl bg-[#FFE0D8] p-4 text-sm font-semibold text-[#9C3E2B]"
                            >
                                {{ form.errors.package }}
                            </p>
                            <p
                                v-if="form.errors.payment"
                                class="rounded-2xl bg-[#FFE0D8] p-4 text-sm font-semibold text-[#9C3E2B]"
                            >
                                {{ form.errors.payment }}
                            </p>
                            <div
                                class="mt-2 flex items-end justify-between gap-4 rounded-2xl bg-white/65 p-4"
                            >
                                <div>
                                    <p class="text-sm font-bold text-[#4D6070]">
                                        Jumlah bayaran
                                    </p>
                                    <p class="mt-1 text-xs text-[#65708E]">
                                        Tiada bayaran berulang
                                    </p>
                                </div>
                                <strong class="text-3xl">{{
                                    money(selectedPackage.price_sen)
                                }}</strong>
                            </div>
                            <button
                                :disabled="form.processing"
                                type="submit"
                                class="inline-flex min-h-15 w-full items-center justify-center gap-3 rounded-full bg-[#17213B] px-5 font-black text-white shadow-[0_5px_0_#65708E] transition hover:-translate-y-0.5 focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#FFD84D] disabled:cursor-wait disabled:opacity-60"
                            >
                                <CreditCard class="size-5" />{{
                                    form.processing
                                        ? 'Menyediakan CHIP...'
                                        : `Bayar ${money(selectedPackage.price_sen)}`
                                }}
                            </button>
                        </form>
                        <div
                            class="mt-6 flex items-start gap-3 text-xs leading-5 text-[#4D6070]"
                        >
                            <Mail class="mt-0.5 size-4 shrink-0" />
                            <p>
                                Kod hanya dikeluarkan selepas status bayaran
                                disahkan pada server.
                            </p>
                        </div>
                    </section>
                    <div
                        class="mt-4 flex items-center justify-center gap-2 text-sm font-semibold text-[#65708E]"
                    >
                        <Users class="size-4" />Pembelian dibuat sebelum
                        pendaftaran
                    </div>
                </aside>
            </div>
        </main>
    </div>
</template>
