<script setup lang="ts">
import { onMounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{ kanjis: (Kanji & { estudios: Estudio[] })[] }>();

const getLevelBackground = (kanji: Kanji & { estudios: Estudio[] }) => {
    if (kanji.estudios.length) {
        let level = kanjiLevels.find(
            (level) => kanji.estudios[0].tiempo / 24 < level.threshold,
        )!;
        return `bg-gradient-${level.color}`;
    } else {
        return "bg-gradient-levels-new";
    }
};

const visibleLimit = ref(500);
const handleScroll = () => {
    const scrollTop = window.scrollY;
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;

    if (scrollTop + windowHeight >= documentHeight) {
        visibleLimit.value += 500;
    }

    //Eliminar evento al cargar todos los kanjis
    if (visibleLimit.value > props.kanjis.length) {
        window.removeEventListener("scroll", handleScroll);
    }
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});
</script>

<template>
    <div
        class="mt-10 grid grid-cols-[repeat(auto-fill,_minmax(48px,_1fr))] gap-1"
    >
        <Link
            :href="`/kanjis/${kanji.id}`"
            v-for="kanji in kanjis.slice(0, visibleLimit)"
            :key="kanji.id"
        >
            <div
                :class="[
                    getLevelBackground(kanji),
                    'w-12 rounded-md p-1 text-center text-2xl text-light',
                ]"
            >
                <h2 class="font-semibold">{{ kanji.literal }}</h2>
            </div>
        </Link>
    </div>
</template>
