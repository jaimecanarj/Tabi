<script setup lang="ts">
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Label from "@/Components/ui/label/Label.vue";
import Input from "@/Components/ui/input/Input.vue";
import Button from "@/Components/ui/button/Button.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <AuthLayout>
        <Head title="Registrarse" />

        <form @submit.prevent="submit">
            <div>
                <Label for="name">Nombre</Label>
                <Input
                    id="name"
                    type="text"
                    v-model="form.name"
                    autofocus
                    required
                    autocomplete="name"
                />
                <p class="mt-2 text-sm text-red-600" v-show="form.errors.name">
                    {{ form.errors.name }}
                </p>
            </div>

            <div class="mt-4">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
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
                <Link
                    :href="route('login')"
                    class="text-sm underline rounded-md text-muted-foreground hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                >
                    ¿Ya tienes cuenta?
                </Link>

                <Button
                    variant="default"
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Registrarse
                </Button>
            </div>
        </form>
    </AuthLayout>
</template>
