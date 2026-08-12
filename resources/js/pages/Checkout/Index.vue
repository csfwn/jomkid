<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import {
    BadgeDollarSign,
    Check,
    ChevronLeft,
    CircleCheck,
    CreditCard,
    KeyRound,
    Mail,
    ShieldCheck,
    Users,
} from '@lucide/vue';
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
const pay = () => form.post('/checkout');
const money = (sen: number) =>
    new Intl.NumberFormat('ms-MY', {
        style: 'currency',
        currency: 'MYR',
    }).format(sen / 100);
</script>

<template>
    <Head title="Pilih akses lifetime JomKid">
        <meta
            name="description"
            content="Pilih pakej lifetime JomKid dan bayar dengan selamat melalui CHIP."
        />
    </Head>

    <div class="min-h-screen overflow-x-clip bg-[#fffaf0] text-[#17152b]">
        <header class="border-b-2 border-[#17152b] bg-[#fffaf0]">
            <div
                class="mx-auto flex min-h-18 max-w-7xl items-center justify-between gap-4 px-5 py-3 lg:px-8"
            >
                <Link
                    href="/"
                    class="flex min-h-11 items-center gap-3 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#4f46e5]"
                >
                    <span
                        class="grid size-10 place-items-center rounded-[14px_14px_14px_4px] border-2 border-[#17152b] bg-[#ff766b] font-black text-white"
                        >J</span
                    >
                    <span class="text-xl font-black tracking-[-0.03em]"
                        >JomKid</span
                    >
                </Link>
                <Link
                    href="/"
                    class="inline-flex min-h-11 items-center gap-2 text-sm font-black hover:text-[#4f46e5] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#4f46e5]"
                    ><ChevronLeft class="size-4" /> Kembali</Link
                >
            </div>
        </header>

        <main>
            <section class="border-b-2 border-[#17152b]">
                <div
                    class="mx-auto grid max-w-7xl gap-8 px-5 py-10 lg:grid-cols-[1fr_auto] lg:items-end lg:px-8 lg:py-14"
                >
                    <div>
                        <p
                            class="flex items-center gap-3 text-sm font-black text-[#4f46e5]"
                        >
                            <span class="h-1 w-10 bg-[#ff766b]"></span>
                            LANGKAH 1 DARIPADA 2
                        </p>
                        <h1
                            class="mt-4 max-w-3xl text-4xl leading-[0.98] font-black tracking-[-0.05em] sm:text-6xl"
                        >
                            Pilih akses yang sesuai untuk keluarga anda.
                        </h1>
                    </div>
                    <p class="max-w-sm text-base leading-7 text-[#5b586d]">
                        Bayar sekali melalui CHIP. Selepas bayaran disahkan, kod
                        pendaftaran dihantar ke e-mel pembeli.
                    </p>
                </div>
            </section>

            <div
                class="mx-auto grid max-w-7xl gap-10 px-5 py-10 lg:grid-cols-[1.05fr_.95fr] lg:items-start lg:px-8 lg:py-16"
            >
                <section aria-labelledby="package-heading">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm font-black text-[#d9473d]">
                                PILIH PAKEJ
                            </p>
                            <h2
                                id="package-heading"
                                class="mt-2 text-3xl font-black tracking-[-0.04em]"
                            >
                                Akses lifetime
                            </h2>
                        </div>
                        <KeyRound class="size-7 text-[#4f46e5]" />
                    </div>

                    <div
                        role="radiogroup"
                        aria-labelledby="package-heading"
                        class="mt-6 grid border-2 border-[#17152b] sm:grid-cols-2"
                    >
                        <button
                            v-for="(item, index) in packages"
                            :key="item.code"
                            type="button"
                            role="radio"
                            :aria-checked="form.package === item.code"
                            class="relative min-h-60 p-6 text-left transition focus-visible:z-10 focus-visible:outline-3 focus-visible:outline-offset-[-6px] focus-visible:outline-[#4f46e5] sm:p-7"
                            :class="[
                                index === 0
                                    ? 'border-b-2 border-[#17152b] sm:border-r-2 sm:border-b-0'
                                    : '',
                                form.package === item.code
                                    ? item.code === 'premium'
                                        ? 'bg-[#f1c84b]'
                                        : 'bg-white'
                                    : 'bg-[#f5f0e6] hover:bg-white',
                            ]"
                            @click="form.package = item.code"
                        >
                            <span
                                v-if="form.package === item.code"
                                class="absolute top-5 right-5 grid size-7 place-items-center rounded-full bg-[#17152b] text-white"
                                ><Check class="size-4"
                            /></span>
                            <p
                                class="text-xs font-black"
                                :class="
                                    item.code === 'premium'
                                        ? 'text-[#a92d25]'
                                        : 'text-[#4f46e5]'
                                "
                            >
                                {{
                                    item.code === 'premium'
                                        ? 'PREMIUM'
                                        : 'BASIC'
                                }}
                            </p>
                            <p class="mt-3 text-4xl font-black">
                                {{ money(item.price_sen) }}
                            </p>
                            <p class="text-sm font-semibold text-[#5b586d]">
                                sekali bayar
                            </p>
                            <div class="mt-7 border-t-2 border-[#17152b] pt-5">
                                <p class="font-black">
                                    {{
                                        item.child_limit === null
                                            ? 'Profil anak tanpa had'
                                            : `${item.child_limit} profil anak`
                                    }}
                                </p>
                                <p
                                    class="mt-2 text-sm leading-6 text-[#5b586d]"
                                >
                                    {{
                                        item.reseller
                                            ? 'Termasuk reseller license dan affiliate 50%.'
                                            : 'Untuk pembelajaran keluarga tanpa hak reseller.'
                                    }}
                                </p>
                            </div>
                        </button>
                    </div>

                    <div class="mt-8 border-y-2 border-[#17152b] py-7">
                        <div class="flex items-start justify-between gap-5">
                            <div>
                                <p class="text-xs font-black text-[#4f46e5]">
                                    PILIHAN ANDA
                                </p>
                                <h3 class="mt-2 text-2xl font-black">
                                    {{ selectedPackage.name }}
                                </h3>
                            </div>
                            <p class="text-3xl font-black">
                                {{ money(selectedPackage.price_sen) }}
                            </p>
                        </div>
                        <ul
                            class="mt-6 grid gap-4 text-sm font-bold sm:grid-cols-2"
                        >
                            <li class="flex gap-3">
                                <Users class="size-5 shrink-0 text-[#4f46e5]" />
                                {{
                                    selectedPackage.child_limit === null
                                        ? 'Profil anak tanpa had'
                                        : `Maksimum ${selectedPackage.child_limit} profil anak`
                                }}
                            </li>
                            <li class="flex gap-3">
                                <CircleCheck
                                    class="size-5 shrink-0 text-[#4f46e5]"
                                />Akses pembelajaran lifetime
                            </li>
                            <li class="flex gap-3">
                                <ShieldCheck
                                    class="size-5 shrink-0 text-[#4f46e5]"
                                />Laporan kemajuan ibu bapa
                            </li>
                            <li
                                v-if="selectedPackage.reseller"
                                class="flex gap-3"
                            >
                                <BadgeDollarSign
                                    class="size-5 shrink-0 text-[#d9473d]"
                                />Link affiliate dan komisen 50%
                            </li>
                        </ul>
                    </div>

                    <div class="mt-8 grid gap-5 sm:grid-cols-3">
                        <div class="border-l-4 border-[#4f46e5] pl-4">
                            <CreditCard class="size-5" />
                            <p class="mt-3 font-black">Bayar dengan CHIP</p>
                        </div>
                        <div class="border-l-4 border-[#ff766b] pl-4">
                            <Mail class="size-5" />
                            <p class="mt-3 font-black">Kod dihantar ke e-mel</p>
                        </div>
                        <div class="border-l-4 border-[#f1c84b] pl-4">
                            <KeyRound class="size-5" />
                            <p class="mt-3 font-black">
                                Daftar sekali dengan kod
                            </p>
                        </div>
                    </div>
                </section>

                <aside class="relative lg:sticky lg:top-6">
                    <div
                        class="absolute -right-3 -bottom-3 h-full w-full rounded-[28px_28px_28px_7px] border-2 border-[#17152b] bg-[#ff766b]"
                    ></div>
                    <section
                        class="relative rounded-[28px_28px_28px_7px] border-2 border-[#17152b] bg-white p-6 sm:p-8"
                    >
                        <p class="text-sm font-black text-[#d9473d]">
                            LANGKAH 2 DARIPADA 2
                        </p>
                        <h2 class="mt-2 text-3xl font-black tracking-[-0.04em]">
                            Maklumat pembeli
                        </h2>
                        <p class="mt-3 leading-7 text-[#5b586d]">
                            Gunakan e-mel yang boleh diakses. Kod pendaftaran
                            hanya dihantar ke alamat ini.
                        </p>

                        <form class="mt-7 grid gap-5" @submit.prevent="pay">
                            <label class="grid gap-2 text-sm font-black">
                                Nama penuh
                                <input
                                    v-model="form.name"
                                    required
                                    autocomplete="name"
                                    class="min-h-13 w-full rounded-[14px_14px_14px_4px] border-2 border-[#17152b] bg-[#fffaf0] px-4 font-semibold placeholder:font-normal placeholder:text-[#777487] focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[#4f46e5]"
                                    placeholder="Nama pembeli"
                                />
                                <span
                                    v-if="form.errors.name"
                                    class="text-sm font-semibold text-[#a92d25]"
                                    >{{ form.errors.name }}</span
                                >
                            </label>

                            <label class="grid gap-2 text-sm font-black">
                                E-mel untuk menerima kod
                                <input
                                    v-model="form.email"
                                    required
                                    type="email"
                                    autocomplete="email"
                                    class="min-h-13 w-full rounded-[14px_14px_14px_4px] border-2 border-[#17152b] bg-[#fffaf0] px-4 font-semibold placeholder:font-normal placeholder:text-[#777487] focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[#4f46e5]"
                                    placeholder="nama@email.com"
                                />
                                <span
                                    v-if="form.errors.email"
                                    class="text-sm font-semibold text-[#a92d25]"
                                    >{{ form.errors.email }}</span
                                >
                            </label>

                            <div
                                class="mt-2 flex items-end justify-between gap-4 border-y-2 border-[#17152b] py-5"
                            >
                                <div>
                                    <p class="text-sm font-bold text-[#5b586d]">
                                        Jumlah bayaran
                                    </p>
                                    <p class="mt-1 text-xs text-[#5b586d]">
                                        Tiada bayaran berulang
                                    </p>
                                </div>
                                <strong class="text-3xl">{{
                                    money(selectedPackage.price_sen)
                                }}</strong>
                            </div>

                            <p
                                v-if="form.errors.package"
                                class="border-l-4 border-[#d9473d] bg-[#ffebe7] p-4 text-sm font-semibold text-[#7e211b]"
                            >
                                {{ form.errors.package }}
                            </p>
                            <p
                                v-if="form.errors.payment"
                                class="border-l-4 border-[#d9473d] bg-[#ffebe7] p-4 text-sm font-semibold text-[#7e211b]"
                            >
                                {{ form.errors.payment }}
                            </p>

                            <button
                                :disabled="form.processing"
                                class="inline-flex min-h-14 w-full items-center justify-center gap-3 rounded-[18px_18px_18px_5px] border-2 border-[#17152b] bg-[#4f46e5] px-5 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#3730a3] focus-visible:outline-3 focus-visible:outline-offset-4 focus-visible:outline-[#ff766b] disabled:cursor-wait disabled:opacity-60"
                                type="submit"
                            >
                                <CreditCard class="size-5" />
                                {{
                                    form.processing
                                        ? 'Menyediakan halaman CHIP...'
                                        : `Teruskan bayaran ${money(selectedPackage.price_sen)}`
                                }}
                            </button>
                        </form>

                        <p
                            class="mt-5 text-center text-xs leading-5 text-[#5b586d]"
                        >
                            JomKid mengeluarkan kod hanya selepas bayaran
                            disahkan pada server.
                        </p>
                    </section>
                </aside>
            </div>
        </main>
    </div>
</template>
