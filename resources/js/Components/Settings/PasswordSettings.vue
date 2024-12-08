<script setup lang="ts">
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { useForm } from "@inertiajs/vue3";
import { toast } from "@/Components/ui/toast";
import { Button } from "@/Components/ui/button";

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.put(route("password.update"), {
        onSuccess: () => {
            form.reset();
            toast({
                title: "Contraseña actualizada",
            });
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <form
        @submit.prevent="submit"
        class="mt-10 flex flex-col items-center rounded-md bg-card p-5 md:items-start"
    >
        <h2 class="text-3xl font-semibold">Cambiar contraseña</h2>
        <div class="mt-6 flex flex-col gap-4 lg:flex-row">
            <!-- Contraseña actual -->
            <div>
                <Label for="name" class="flex items-end gap-1 text-xl">
                    Contraseña actual
                </Label>
                <Input
                    type="password"
                    name="current_password"
                    required
                    v-model="form.current_password"
                    class="mt-2 w-64 sm:w-72"
                />
                <p
                    class="mt-2 text-sm text-red-600"
                    v-show="form.errors.current_password"
                >
                    {{ form.errors.current_password }}
                </p>
            </div>
            <div class="flex flex-col gap-4 md:flex-row">
                <!-- Nueva contraseña -->
                <div>
                    <Label for="name" class="flex items-end gap-1 text-xl">
                        Nueva contraseña
                    </Label>
                    <Input
                        type="password"
                        name="password"
                        required
                        v-model="form.password"
                        class="mt-2 w-64 sm:w-72"
                    />
                    <p
                        class="mt-2 text-sm text-red-600"
                        v-show="form.errors.password"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>
                <!-- Confirmar contraseña -->
                <div>
                    <Label for="name" class="flex items-end gap-1 text-xl">
                        Confirmar contraseña
                    </Label>
                    <Input
                        type="password"
                        name="password_confirmation"
                        required
                        v-model="form.password_confirmation"
                        class="mt-2 w-64 sm:w-72"
                    />
                    <p
                        class="mt-2 text-sm text-red-600"
                        v-show="form.errors.password_confirmation"
                    >
                        {{ form.errors.password_confirmation }}
                    </p>
                </div>
            </div>
        </div>
        <Button type="submit" class="mt-4 w-64 sm:w-72">Actualizar</Button>
    </form>
</template>
