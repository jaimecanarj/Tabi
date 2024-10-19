<script setup lang="ts">
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Label from "@/Components/ui/label/Label.vue";
import Input from "@/Components/ui/input/Input.vue";
import Button from "@/Components/ui/button/Button.vue";

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <AuthLayout>
        <Head title="Olvidó contraseña" />

        <div class="pr-6 mb-4 text-sm text-muted-foreground">
            ¿Olvidó su contraseña? <br />
            Escriba su correo electrónico y le enviaremos un enlace para
            restablecer su contraseña y elegir una nueva.
        </div>

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

            <div class="flex items-center justify-end mt-4">
                <Button
                    variant="default"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Enviar correo
                </Button>
            </div>
        </form>
    </AuthLayout>
</template>
