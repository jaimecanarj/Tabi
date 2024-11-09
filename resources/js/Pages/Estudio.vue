<script setup lang="ts">
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { ChevronLeft, ChevronRight, Play } from "lucide-vue-next";
import { Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import StoryForm from "@/Components/StoryForm.vue";
import { Button } from "@/Components/ui/button";

const props = defineProps<{ kanjis: Kanji[] }>();

let id = 0;
let kanji = ref(props.kanjis[id]);

const changeKanji = (change: string | number) => {
    //Cambiar según paginación
    if (typeof change == "number") {
        kanji.value = props.kanjis[change];
    }
    //Cambiar según botón anterior y siguiente
    else if (change == "next") {
        id++;
        kanji.value = props.kanjis[id];
    } else if (change == "prev") {
        id--;
        kanji.value = props.kanjis[id];
    }
};
</script>

<template>
    <Head title="Estudio" />
    <MainLayout />
    <main class="container relative mt-12">
        <!-- Tarjeta -->
        <div class="flex flex-col mb-10 shadow-xl">
            <div
                class="flex justify-center items-center rounded-t-md text-[200px] font-bold bg-gradient-primary text-primary-foreground leading-tight"
            >
                <h2>{{ kanji.literal }}</h2>
            </div>
            <div class="flex justify-center bg-card rounded-b-md">
                <p class="p-4 text-6xl font-semibold capitalize">
                    {{ kanji.significado }}
                </p>
            </div>
        </div>
        <div class="grid gap-10 lg:grid-cols-2">
            <!-- Radicales -->
            <div class="p-5 rounded-md shadow-md bg-card">
                <h3 class="pb-2 text-4xl font-semibold">Radicales</h3>
                <p class="text-muted-foreground">
                    Este kanji está compuesto de:
                </p>
                <div class="flex flex-wrap mt-3 gap-7">
                    <Link
                        v-for="radical of kanji.radicales"
                        :href="`/radicales/${radical.id}`"
                    >
                        <Button class="text-2xl">
                            {{ radical.literal }}
                        </Button>
                        <span class="ml-2 text-xl capitalize">
                            {{ radical.significado }}
                        </span>
                    </Link>
                </div>
            </div>

            <!-- Historia -->
            <div class="p-5 rounded-md shadow-md bg-card">
                <h3 class="pb-1 text-4xl font-semibold">Historia</h3>
                <div>
                    <p class="mb-3 text-muted-foreground">
                        Añade una historia a este kanji.
                    </p>
                    <StoryForm :kanji_id="kanji.id" :key="kanji.id" />
                </div>
            </div>
        </div>
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
    </main>
    <!-- Selector de kanji -->
    <footer
        class="sticky top-[100vh] flex flex-wrap justify-center gap-2 mt-10 mb-6"
    >
        <Button
            v-for="(kanjiIndex, index) of kanjis"
            class="text-2xl"
            @click="changeKanji(index)"
        >
            {{ kanjiIndex.literal }}
        </Button>
        <Button variant="primary-alt">
            Repasar
            <Play class="h-5" />
        </Button>
    </footer>
</template>
