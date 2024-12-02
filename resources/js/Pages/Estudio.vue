<script setup lang="ts">
import { onMounted, ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { ChevronLeft, ChevronRight, CircleArrowRight } from "lucide-vue-next";
import { Kanji, Radical } from "@/lib/types";
import EstudioLayout from "@/Layouts/EstudioLayout.vue";
import { Button } from "@/Components/ui/button";

const props = defineProps<{ kanjis: (Kanji & { radicales: Radical[] })[] }>();

let id = 0;
let kanji = ref(props.kanjis[id]);

const changeKanji = (change: string | number) => {
    //Cambiar según paginación
    if (typeof change == "number") {
        id = change;
        kanji.value = props.kanjis[change];
    }
    //Cambiar según botón anterior y siguiente
    else if (change == "next") {
        if (id == props.kanjis.length - 1) return;
        id++;
        kanji.value = props.kanjis[id];
    } else if (change == "prev") {
        if (id == 0) return;
        id--;
        kanji.value = props.kanjis[id];
    }
};

onMounted(() => {
    //Cambiar de kanji usando las flechas del teclado
    window.addEventListener("keydown", (event) => {
        if (event.key == "ArrowLeft") changeKanji("prev");
        else if (event.key == "ArrowRight") changeKanji("next");
    });
});
</script>

<template>
    <Head title="Estudio" />
    <EstudioLayout :kanji="kanji" :showData="true">
        <template #significado>
            <div class="flex justify-center rounded-b-md bg-card">
                <p class="p-4 text-6xl font-semibold first-letter:capitalize">
                    {{ kanji.significado }}
                </p>
            </div>
        </template>
        <template #absolute>
            <!-- Botón anterior y siguiente kanji -->
            <Button
                class="absolute left-2 top-1/2 shadow-md"
                variant="secondary"
                size="icon"
                @click="changeKanji('prev')"
                :disabled="id == 0"
            >
                <ChevronLeft />
            </Button>
            <Button
                class="absolute right-2 top-1/2 shadow-md"
                variant="secondary"
                size="icon"
                @click="changeKanji('next')"
                :disabled="id == kanjis.length - 1"
            >
                <ChevronRight />
            </Button>
        </template>
        <template #footer>
            <!-- Selector de kanji -->
            <footer
                class="sticky top-[100vh] mx-8 mb-6 mt-10 flex flex-wrap justify-center gap-2"
            >
                <Button
                    v-for="(kanjiIndex, index) of kanjis"
                    variant="secondaryGradient"
                    size="gradient"
                    @click="changeKanji(index)"
                >
                    {{ kanjiIndex.literal }}
                </Button>
                <Link href="/repasar">
                    <Button class="h-12">
                        <p>Repasar</p>
                        <CircleArrowRight :size="24" class="ml-1" />
                    </Button>
                </Link>
            </footer>
        </template>
    </EstudioLayout>
</template>
