<script setup lang="ts">
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { Kanji, Lectura, Significado, Radical } from "@/lib/types";
import { ScrollText } from "lucide-vue-next";
import MainLayout from "@/Layouts/MainLayout.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import { Button } from "@/Components/ui/button";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";
import KanjiDetails from "@/Components/KanjiDetails.vue";
import StoryForm from "@/Components/StoryForm.vue";

let isOpen = ref(false);

const props = defineProps<{
    kanji: Kanji;
    lecturas: Lectura[];
    significados: Significado[];
    radicales: Radical[];
    similares: Kanji[];
}>();

const toggleDialog = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <Head :title="kanji.literal" />
    <MainLayout />
    <main class="container mt-6">
        <ItemDetailsCard
            :literal="kanji.literal"
            tipo="kanjis"
            :titulo="kanji.significado"
        >
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
                    <DialogContent class="sm:max-w-[500px] gap-0">
                        <DialogHeader class="mb-4">
                            <DialogTitle>Historia</DialogTitle>
                            <DialogDescription>
                                Añade una historia a este kanji.
                            </DialogDescription>
                        </DialogHeader>
                        <StoryForm :kanji_id="kanji.id" @close="toggleDialog" />
                    </DialogContent>
                </Dialog>
            </template>
            <KanjiDetails v-bind="props" />
        </ItemDetailsCard>
    </main>
</template>
