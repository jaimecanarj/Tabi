<script setup lang="ts">
import { ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ScrollText } from "lucide-vue-next";
import { Kanji, Reading, Meaning, Radical, Study } from "@/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";
import KanjiDetails from "@/Components/Kanjis/KanjiDetails.vue";
import KanjiProgress from "@/Components/KanjiProgress/KanjiProgress.vue";
import StoryForm from "@/Components/StoryForm.vue";
import { Button } from "@/Components/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";

const page = usePage();

const props = defineProps<{
    kanji: Kanji & { studies: Study[] };
    readings: Reading[];
    meanings: Meaning[];
    radicals: Radical[];
    similarKanjis: Kanji[];
}>();

let isOpen = ref(false);

const toggleDialog = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <Head :title="kanji.literal" />
    <MainLayout />
    <main class="container mt-6">
        <!-- Tarjeta -->
        <ItemDetailsCard
            :literal="kanji.literal"
            type="kanjis"
            :title="kanji.meaning"
        >
            <!-- Botón de historia -->
            <template #boton>
                <Dialog
                    v-if="$page.props.auth.user"
                    :open="isOpen"
                    @update:open="toggleDialog"
                >
                    <DialogTrigger as-child>
                        <Button variant="secondary" class="shadow-md">
                            <ScrollText class="mr-2" />
                            Historia
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="gap-0 bg-card sm:max-w-[500px]">
                        <DialogHeader class="mb-4">
                            <DialogTitle>Historia</DialogTitle>
                            <DialogDescription>
                                Añade una historia a este kanji.
                            </DialogDescription>
                        </DialogHeader>
                        <StoryForm :kanjiId="kanji.id" @close="toggleDialog" />
                    </DialogContent>
                </Dialog>
            </template>
            <!-- Detalles de la tarjeta -->
            <KanjiDetails v-bind="props" />
        </ItemDetailsCard>
        <!-- Progreso del usuario -->
        <KanjiProgress v-if="page.props.auth.user" :studies="kanji.studies!" />
    </main>
</template>
