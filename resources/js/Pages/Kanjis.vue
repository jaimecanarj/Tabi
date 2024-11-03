<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import { Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import { ChartLine, Pencil, School } from "lucide-vue-next";
import Pagination from "@/Components/Pagination.vue";
import { Badge } from "@/Components/ui/badge";

type Pagination = {
    data: Kanji[];
    current_page: number;
    per_page: number;
    total: number;
};

const props = defineProps<{ response: Pagination }>();

const { current_page, data, total, per_page } = props.response;

const fetchPage = (page: number) => {
    router.get("/kanjis", { page: page.toString() });
};
</script>

<template>
    <Head title="Kanjis" />
    <MainLayout />
    <main class="container mt-6">
        <div class="flex items-end justify-between pb-5 mb-3 border-b-2">
            <h1 class="text-6xl font-semibold">Kanjis</h1>
            <p class="text-lg">{{ total }} kanjis</p>
        </div>
        <div class="flex flex-wrap justify-center gap-4">
            <template v-for="kanji of data">
                <Link :href="`/kanjis/${kanji.id}`">
                    <div
                        class="flex border rounded-md shadow-md bg-card hover:bg-secondary w-72 h-36"
                    >
                        <div
                            class="flex items-center p-4 rounded-l-md bg-primary"
                        >
                            <h2 class="text-6xl text-primary-foreground">
                                {{ kanji.literal }}
                            </h2>
                        </div>
                        <div class="flex flex-col justify-between px-4 py-2">
                            <p
                                class="w-40 text-2xl font-semibold tracking-tight capitalize hyphens-auto line-clamp-2"
                                lang="es"
                            >
                                {{ kanji.significado }}
                            </p>
                            <div>
                                <Badge variant="secondary" class="space-x-2">
                                    <p>
                                        <Pencil class="inline h-5" />
                                        {{ kanji.trazos }}
                                    </p>
                                    <p>
                                        <School class="inline h-5" />
                                        {{ kanji.grado }}
                                    </p>
                                    <p v-if="kanji.frecuencia">
                                        <ChartLine class="inline h-5" />
                                        {{ kanji.frecuencia }}
                                    </p>
                                </Badge>
                            </div>
                        </div>
                    </div>
                </Link>
            </template>
        </div>
        <div class="flex justify-center mt-6">
            <Pagination
                :total="total"
                :current_page="current_page"
                :per_page="per_page"
                @change-page="fetchPage"
            />
        </div>
    </main>
</template>
