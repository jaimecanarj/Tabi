<script setup lang="ts">
import { BookX } from "lucide-vue-next";
import { Study, Kanji } from "@/types";
import { kanjiLevels } from "@/lib/utils";
import HomeKanjiGrid from "@/Components/Home/HomeKanjiGrid.vue";

const props = defineProps<{ data: (Study & { kanji: Kanji })[] }>();

let lastWrong = props.data.map((study) => {
    let level = kanjiLevels.find((level) => study.time / 24 < level.threshold)!;
    return { ...study, level };
});
</script>

<template>
    <HomeKanjiGrid :studies="lastWrong" type="wrong">
        <template #title> <BookX :size="32" /> Últimos fallos </template>
    </HomeKanjiGrid>
</template>
