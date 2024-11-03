<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import { Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Button } from "@/Components/ui/button";
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from "@/Components/ui/pagination";
import { ref } from "vue";
import { ChartLine, Pencil, School } from "lucide-vue-next";

type Pagination = {
    data: Kanji[];
    current_page: number;
    per_page: number;
    total: number;
};

const props = defineProps<{ response: Pagination }>();

const { current_page, data, total, per_page } = props.response;

let page = ref(current_page);

const fetchPage = () => {
    router.get("/kanjis", { page: page.value.toString() });
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
                    <div class="p-4 rounded-md bg-card hover:bg-secondary w-72">
                        <div class="flex items-center gap-6">
                            <h2 class="text-6xl">
                                {{ kanji.literal }}
                            </h2>
                            <p
                                class="text-3xl font-semibold tracking-tight capitalize line-clamp-2 text-ellipsis"
                            >
                                {{ kanji.significado }}
                            </p>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <p><Pencil class="inline" /> {{ kanji.trazos }}</p>
                            <p><School class="inline" /> {{ kanji.grado }}</p>
                            <p v-if="kanji.frecuencia">
                                <ChartLine class="inline" />
                                {{ kanji.frecuencia }}
                            </p>
                        </div>
                    </div>
                </Link>
            </template>
        </div>
        <div class="flex justify-center mt-6">
            <Pagination
                v-slot="{ page }"
                :total="total"
                :sibling-count="2"
                :default-page="current_page"
                :items-per-page="per_page"
                v-model:page="page"
                @update:page="fetchPage"
            >
                <PaginationList
                    v-slot="{ items }"
                    class="flex items-center gap-1"
                >
                    <PaginationFirst />
                    <PaginationPrev />

                    <template v-for="(item, index) in items">
                        <PaginationListItem
                            v-if="item.type === 'page'"
                            :key="index"
                            :value="item.value"
                            as-child
                        >
                            <Button
                                class="w-10 h-10 p-0"
                                :variant="
                                    item.value === page ? 'default' : 'outline'
                                "
                            >
                                {{ item.value }}
                            </Button>
                        </PaginationListItem>
                        <PaginationEllipsis
                            v-else
                            :key="item.type"
                            :index="index"
                        />
                    </template>

                    <PaginationNext />
                    <PaginationLast />
                </PaginationList>
            </Pagination>
        </div>
    </main>
</template>
