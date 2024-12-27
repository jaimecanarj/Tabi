<script setup lang="ts">
import { onMounted, onUnmounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { Study, Kanji } from "@/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{ kanjis: (Kanji & { studies: Study[] })[] }>();

const getLevelBackground = (kanji: Kanji & { studies: Study[] }) => {
    if (kanji.studies.length) {
        let level = kanjiLevels.find(
            (level) => kanji.studies[0].time / 24 < level.threshold,
        )!;
        return `bg-gradient-${level.color}`;
    } else {
        return "bg-gradient-levels-new";
    }
};

const visibleLimit = ref(300);
const observerTarget = ref<HTMLElement | null>(null);

let observer: IntersectionObserver;

// Observador con IntersectionObserver
onMounted(() => {
    // Crear el observer una vez que el componente esté montado
    observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            visibleLimit.value += 300;

            // Finalizamos el observador cuando se cargan todos los kanjis
            if (visibleLimit.value >= props.kanjis.length && observer) {
                observer.disconnect();
            }
        }
    });

    // Observar el target si está disponible
    if (observerTarget.value) {
        observer.observe(observerTarget.value);
    }
});

// Desmontar el IntersectionObserver
onUnmounted(() => {
    if (observer) observer.disconnect();
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

    <div ref="observerTarget" class="h-1 bg-transparent"></div>
</template>
