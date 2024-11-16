<script setup lang="ts">
import { onMounted, ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { ChevronLeft, ChevronRight, Play } from "lucide-vue-next";
import { Kanji } from "@/lib/types";
import EstudioLayout from "@/Layouts/EstudioLayout.vue";
import { Button } from "@/Components/ui/button";

const props = defineProps<{ kanjis: Kanji[] }>();

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
            <div class="flex justify-center bg-card rounded-b-md">
                <p class="p-4 text-6xl font-semibold capitalize">
                    {{ kanji.significado }}
                </p>
            </div>
        </template>
        <template #absolute>
            <!-- Botón anterior y siguiente kanji -->
            <Button
                class="absolute shadow-md left-2 top-1/2"
                variant="secondary"
                size="icon"
                @click="changeKanji('prev')"
                :disabled="id == 0"
            >
                <ChevronLeft />
            </Button>
            <Button
                class="absolute shadow-md right-2 top-1/2"
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
                class="sticky top-[100vh] flex flex-wrap justify-center gap-2 mt-10 mb-6 mx-8"
            >
                <Button
                    v-for="(kanjiIndex, index) of kanjis"
                    class="text-2xl"
                    @click="changeKanji(index)"
                >
                    {{ kanjiIndex.literal }}
                </Button>
                <Link href="/repasar">
                    <Button variant="primary-alt">
                        Repasar
                        <Play class="h-5" />
                    </Button>
                </Link>
            </footer>
        </template>
    </EstudioLayout>
</template>
