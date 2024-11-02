<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Kanji, Lectura, Significado, Radical } from "@/lib/types";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";
import KanjiDetails from "@/Components/KanjiDetails.vue";
import { Button } from "@/Components/ui/button";
import { ScrollText } from "lucide-vue-next";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import { Textarea } from "@/Components/ui/textarea";

const props = defineProps<{
    kanji: Kanji;
    lecturas: Lectura[];
    significados: Significado[];
    radicales: Radical[];
    similares: Kanji[];
}>();

const fetchHistoria = async () => {
    //Obtenemos la historia del usuario si hay un usuario logueado
    //La guardamos en form.historia
    // Y mostramos el modal
};

const form = useForm({
    historia: "",
});

const submit = () => {
    // form.post(route("/historia"));
};
</script>

<template>
    <Head :title="kanji.literal" />
    <MainLayout />
    <main class="container mt-6">
        <ItemDetailsCard
            :literal="kanji.literal"
            tipo="kanjis"
            :titulo="significados[0].significado"
        >
            <template #boton>
                <Dialog>
                    <DialogTrigger as-child>
                        <Button variant="secondary" @click="fetchHistoria">
                            <ScrollText class="mr-2" />
                            Historia
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[500px]">
                        <DialogHeader>
                            <DialogTitle>Crear historia</DialogTitle>
                            <DialogDescription>
                                Añade una historia a este kanji.
                            </DialogDescription>
                        </DialogHeader>
                        <form @submit.prevent="submit">
                            <Textarea
                                v-model="form.historia"
                                class="min-h-32"
                            />
                            <DialogFooter class="mt-3">
                                <Button type="submit"> Guardar cambios </Button>
                            </DialogFooter>
                        </form>
                    </DialogContent>
                </Dialog>
            </template>
            <KanjiDetails v-bind="props" />
        </ItemDetailsCard>
    </main>
</template>
