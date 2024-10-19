<script setup lang="ts">
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Label from "@/Components/ui/label/Label.vue";
import Input from "@/Components/ui/input/Input.vue";
import Button from "@/Components/ui/button/Button.vue";

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <AuthLayout>
        <Head title="Restablecer contraseña" />

        <form @submit.prevent="submit">
            <div>
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <p class="mt-2 text-sm text-red-600" v-show="form.errors.email">
                    {{ form.errors.email }}
                </p>
            </div>

            <div class="mt-4">
                <Label for="password">Contraseña</Label>
                <Input
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autofocus
                    autocomplete="new-password"
                />

                <p
                    class="mt-2 text-sm text-red-600"
                    v-show="form.errors.password"
                >
                    {{ form.errors.password }}
                </p>
            </div>

            <div class="mt-4">
                <Label for="password_confirmation">Confirmar contraseña</Label>
                <Input
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    required
                    autofocus
                    autocomplete="new-password"
                />

                <p
                    class="mt-2 text-sm text-red-600"
                    v-show="form.errors.password_confirmation"
                >
                    {{ form.errors.password_confirmation }}
                </p>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Button
                    variant="default"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Restablecer contraseña
                </Button>
            </div>
        </form>
    </AuthLayout>
</template>
