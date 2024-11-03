<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Kanji, Lectura, Significado, Radical } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";
import KanjiDetails from "@/Components/KanjiDetails.vue";
import StoryDialog from "@/Components/StoryDialog.vue";

const props = defineProps<{
    kanji: Kanji;
    lecturas: Lectura[];
    significados: Significado[];
    radicales: Radical[];
    similares: Kanji[];
}>();
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
                <StoryDialog
                    v-if="$page.props.auth.user"
                    :kanji_id="kanji.id"
                />
            </template>
            <KanjiDetails v-bind="props" />
        </ItemDetailsCard>
    </main>
</template>
