<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { BookType } from "lucide-vue-next";
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{ estudios: (Estudio & { kanji: Kanji })[] }>();

let lastStudies = props.estudios.slice(0, 24);

lastStudies = lastStudies.map((estudio) => {
    let level = kanjiLevels.find(
        (level) => estudio.tiempo / 24 < level.threshold,
    );
    return { ...estudio, level };
});
</script>

<template>
    <section class="mt-10 rounded-xl bg-card p-6 shadow-md">
        <h2 class="flex items-center gap-2 text-3xl font-semibold">
            <BookType :size="32" />Últimos kanjis repasados
        </h2>
        <div
            class="home-grid mt-4 grid max-h-40 gap-2 overflow-hidden sm:max-h-28"
        >
            <div v-for="study in lastStudies">
                <Link :href="`/kanjis/${study.kanji.id}`">
                    <div
                        class="rounded bg-secondary p-2 text-center text-2xl font-semibold"
                    >
                        {{ study.kanji.literal }}
                    </div>
                </Link>
            </div>
        </div>
    </section>
</template>
