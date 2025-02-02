<script setup lang="ts">
import { BookType } from "lucide-vue-next";
import { Study, Kanji } from "@/types";
import { kanjiLevels } from "@/lib/utils";
import HomeKanjiGrid from "@/Components/Home/HomeKanjiGrid.vue";

const props = defineProps<{ data: (Study & { kanji: Kanji })[] }>();

let lastStudies = props.data.map((study) => {
    let level = kanjiLevels.find((level) => study.time / 24 < level.threshold)!;
    return { ...study, level };
});
</script>

<template>
    <HomeKanjiGrid :studies="lastStudies" type="last">
        <template #title><BookType :size="32" />Últimos repasados</template>
    </HomeKanjiGrid>
</template>
