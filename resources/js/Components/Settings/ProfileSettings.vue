<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Label } from "@/Components/ui/label";
import { BookMarked, CaseSensitive, Calendar1, User } from "lucide-vue-next";
import Button from "../ui/button/Button.vue";
import { Input } from "@/Components/ui/input";
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from "@/Components/ui/number-field";
import { useForm, usePage } from "@inertiajs/vue3";
import { toast } from "@/Components/ui/toast";
import { ref } from "vue";

const page = usePage();
const user = page.props.auth.user!;
let avatarPath = ref(`/storage/${user.avatar}`);

type Form = {
    name: string;
    index: string;
    estudio_diario: number;
    avatar: File | null;
};

const form = useForm<Form>({
    name: user.name,
    index: user.indice,
    estudio_diario: user.estudio_diario,
    avatar: null,
});

const updateImage = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.avatar = target.files![0];
    avatarPath.value = URL.createObjectURL(target.files![0]);
};

const submit = () => {
    form.post("/profile-settings", {
        onSuccess: () => {
            toast({
                title: "Perfil actualizado",
            });
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <div
            class="mb-6 flex flex-col space-y-8 rounded-md bg-card p-6 shadow-xl md:mb-0 md:flex-row md:space-x-10 md:space-y-0 lg:space-x-20"
        >
            <div class="flex flex-col items-center gap-2">
                <!-- Foto de perfil -->
                <div
                    :class="[
                        {
                            'bg-gradient-primary-to-alt':
                                !user.avatar && !form.avatar,
                        },
                        'flex h-80 basis-2/5 items-center justify-center rounded-lg xl:basis-1/3',
                    ]"
                >
                    <img
                        v-if="user.avatar || form.avatar"
                        :src="avatarPath"
                        alt="avatar"
                        class="h-80 rounded-lg object-contain"
                    />
                    <User v-else :size="200" class="text-light" />
                </div>
                <Input
                    type="file"
                    name="avatar"
                    class="w-64 sm:w-72"
                    @input="updateImage"
                />
                <p
                    class="mt-2 text-sm text-red-600"
                    v-show="form.errors.avatar"
                >
                    {{ form.errors.avatar }}
                </p>
            </div>
            <!-- Información -->
            <div
                class="flex basis-3/5 flex-col items-center md:items-start xl:basis-2/3"
            >
                <!-- Nombre -->
                <div>
                    <Label for="name" class="flex items-end gap-1 text-xl">
                        <CaseSensitive strokeWidth="1.5" />Nombre
                    </Label>
                    <Input
                        type="text"
                        name="name"
                        required
                        v-model="form.name"
                        class="mt-2 w-64 sm:w-72"
                    />
                    <p
                        class="mt-2 text-sm text-red-600"
                        v-show="form.errors.name"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>
                <!-- Índice -->
                <div class="mt-5">
                    <Label for="name" class="flex gap-1 text-xl">
                        <BookMarked strokeWidth="1.5" />Índice
                    </Label>
                    <p class="text-sm text-muted-foreground">
                        No recomendado si ya tienes estudios.
                    </p>
                    <Select required name="index" v-model="form.index">
                        <SelectTrigger class="mt-2 w-64 sm:w-72">
                            <SelectValue placeholder="Selecciona un índice" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="escolar"> Escolar </SelectItem>
                            <SelectItem value="heisig"> Heisig </SelectItem>
                            <SelectItem value="wanikani"> WaniKani </SelectItem>
                        </SelectContent>
                    </Select>
                    <p
                        class="mt-2 text-sm text-red-600"
                        v-show="form.errors.index"
                    >
                        {{ form.errors.index }}
                    </p>
                </div>
                <!-- Estudio diario -->
                <div class="mt-5">
                    <Label for="name" class="flex gap-1 text-xl">
                        <Calendar1 strokeWidth="1.5" />Estudio diario:
                    </Label>
                    <NumberField
                        v-model="form.estudio_diario"
                        required
                        :min="10"
                        :max="50"
                        :step="10"
                        class="mt-2 w-64 sm:w-72"
                    >
                        <NumberFieldContent>
                            <NumberFieldDecrement />
                            <NumberFieldInput />
                            <NumberFieldIncrement />
                        </NumberFieldContent>
                    </NumberField>
                    <p
                        class="mt-2 text-sm text-red-600"
                        v-show="form.errors.estudio_diario"
                    >
                        {{ form.errors.estudio_diario }}
                    </p>
                    <Button
                        :class="[
                            { 'opacity-25': form.processing },
                            'mt-4 w-64 sm:w-72 md:mt-10',
                        ]"
                        :disabled="form.processing"
                    >
                        Guardar cambios
                    </Button>
                </div>
            </div>
        </div>
    </form>
</template>
