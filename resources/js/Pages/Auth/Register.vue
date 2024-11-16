<script setup lang="ts">
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Label from "@/Components/ui/label/Label.vue";
import Input from "@/Components/ui/input/Input.vue";
import Button from "@/Components/ui/button/Button.vue";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from "@/Components/ui/number-field";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    avatar: "",
    index: "escolar",
    estudio_diario: 10,
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
                <Label for="name"
                    >Nombre <span class="text-red-600">*</span></Label
                >
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

            <div class="mt-2">
                <Label for="email"
                    >Email <span class="text-red-600">*</span></Label
                >
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

            <div class="mt-2">
                <Label for="password"
                    >Contraseña <span class="text-red-600">*</span></Label
                >
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

            <div class="mt-2">
                <Label for="password_confirmation"
                    >Confirmar contraseña
                    <span class="text-red-600">*</span></Label
                >
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

            <div class="mt-2">
                <Label for="avatar">Foto de perfil</Label>
                <Input
                    id="avatar"
                    type="file"
                    @input="form.avatar = $event.target.files[0]"
                />
                <p
                    class="mt-2 text-sm text-red-600"
                    v-show="form.errors.avatar"
                >
                    {{ form.errors.avatar }}
                </p>
            </div>

            <div class="mt-2 flex items-center justify-between">
                <div>
                    <Label for="index"
                        >Selecionar un índice
                        <span class="text-red-600">*</span></Label
                    >
                    <Select required name="index" v-model="form.index">
                        <SelectTrigger>
                            <SelectValue placeholder="Selecciona un índice" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="escolar"> Escolar </SelectItem>
                            <SelectItem value="heisig"> Heisig </SelectItem>
                            <SelectItem value="wanikani"> WaniKani </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <div class="w-32">
                    <Label
                        >Estudio diario
                        <span class="text-red-600">*</span></Label
                    >
                    <NumberField
                        v-model="form.estudio_diario"
                        required
                        :min="10"
                        :max="50"
                        :step="10"
                    >
                        <NumberFieldContent>
                            <NumberFieldDecrement />
                            <NumberFieldInput />
                            <NumberFieldIncrement />
                        </NumberFieldContent>
                    </NumberField>
                </div>
            </div>
            <div>
                <p class="mt-2 text-sm text-red-600" v-show="form.errors.index">
                    {{ form.errors.index }}
                </p>
                <p
                    class="mt-2 text-sm text-red-600"
                    v-show="form.errors.estudio_diario"
                >
                    {{ form.errors.estudio_diario }}
                </p>
            </div>

            <div class="mt-2 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-muted-foreground underline hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
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
