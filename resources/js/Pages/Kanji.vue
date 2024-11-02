<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
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
import axios from "axios";

const props = defineProps<{
    kanji: Kanji;
    lecturas: Lectura[];
    significados: Significado[];
    radicales: Radical[];
    similares: Kanji[];
}>();

const page = usePage();

const fetchHistoria = async () => {
    // Mientras se ejecuta esto ponemos un cargando
    if (page.props.auth.user) {
        let historia = await axios.get(
            `/historia/${page.props.auth.user.id}/${props.kanji.id}`,
        );

        if (historia.data) {
            form.id = historia.data.id;
            form.historia = historia.data.historia;
        }
    }
};

const form = useForm({
    id: null,
    historia: "",
    user_id: page.props.auth.user?.id,
    kanji_id: props.kanji.id,
});

const submit = () => {
    form.post("/historia");
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
                <Dialog @update:open="fetchHistoria">
                    <DialogTrigger as-child>
                        <Button variant="secondary">
                            <ScrollText class="mr-2" />
                            Historia
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[500px]">
                        <DialogHeader>
                            <DialogTitle v-if="form.id">
                                Editar historia
                            </DialogTitle>
                            <DialogTitle v-else>Crear historia</DialogTitle>
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
