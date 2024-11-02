<script setup lang="ts">
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Label from "@/Components/ui/label/Label.vue";
import Input from "@/Components/ui/input/Input.vue";
import Checkbox from "@/Components/ui/checkbox/Checkbox.vue";
import Button from "@/Components/ui/button/Button.vue";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <AuthLayout>
        <Head title="Iniciar sesión" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

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
                    type="password"
                    id="password"
                    required
                    v-model="form.password"
                    autocomplete="current-password"
                />
                <p
                    class="mt-2 text-sm text-red-600"
                    v-show="form.errors.password"
                >
                    {{ form.errors.password }}
                </p>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm underline rounded-md text-muted-foreground hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                >
                    ¿Olvidó su contraseña?
                </Link>
            </div>

            <div class="flex items-center gap-2 mt-4">
                <Checkbox id="remember" v-model:checked="form.remember" />
                <Label for="remember">Recordarme</Label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('register')"
                    class="text-sm underline rounded-md text-muted-foreground hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                >
                    ¿No tiene cuenta?
                </Link>

                <Button
                    variant="default"
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Iniciar sesión
                </Button>
            </div>
        </form>
    </AuthLayout>
</template>
