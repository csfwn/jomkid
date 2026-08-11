<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';

defineProps<{
    passwordRules: string;
    accessCode: string;
}>();

defineOptions({
    layout: {
        title: 'Daftar akaun JomKid',
        description: 'Gunakan kod sekali guna yang dihantar selepas pembelian',
    },
});
</script>

<template>
    <Head title="Daftar dengan kod akses" />

    <Form
        v-bind="store.form()"
        :reset-on-success="['access_code', 'password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="access_code">Kod akses sekali guna</Label>
                <Input
                    id="access_code"
                    type="text"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="one-time-code"
                    name="access_code"
                    :default-value="accessCode"
                    placeholder="JOMKID-XXXX-XXXX-XXXX"
                    class="font-mono uppercase"
                />
                <InputError :message="errors.access_code" />
            </div>

            <div class="grid gap-2">
                <Label for="name">Nama penuh</Label>
                <Input
                    id="name"
                    type="text"
                    required
                    :tabindex="2"
                    autocomplete="name"
                    name="name"
                    placeholder="Nama penuh"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Alamat e-mel pembelian</Label>
                <Input
                    id="email"
                    type="email"
                    required
                    :tabindex="3"
                    autocomplete="email"
                    name="email"
                    placeholder="email@example.com"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">Kata laluan</Label>
                <PasswordInput
                    id="password"
                    required
                    :tabindex="4"
                    autocomplete="new-password"
                    name="password"
                    placeholder="Kata laluan"
                    :passwordrules="passwordRules"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Sahkan kata laluan</Label>
                <PasswordInput
                    id="password_confirmation"
                    required
                    :tabindex="5"
                    autocomplete="new-password"
                    name="password_confirmation"
                    placeholder="Sahkan kata laluan"
                    :passwordrules="passwordRules"
                />
                <InputError :message="errors.password_confirmation" />
            </div>

            <Button
                type="submit"
                class="mt-2 w-full"
                tabindex="6"
                :disabled="processing"
                data-test="register-user-button"
            >
                <Spinner v-if="processing" />
                Daftar dan aktifkan akses
            </Button>
        </div>

        <div class="text-center text-sm text-muted-foreground">
            Belum beli kod akses?
            <TextLink href="/checkout" class="underline underline-offset-4"
                >Pilih pakej</TextLink
            >
        </div>
        <div class="text-center text-sm text-muted-foreground">
            Sudah mempunyai akaun?
            <TextLink
                :href="login()"
                class="underline underline-offset-4"
                :tabindex="7"
                >Log masuk</TextLink
            >
        </div>
    </Form>
</template>
