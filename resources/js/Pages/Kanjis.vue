<script setup lang="ts">
import { computed, ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import { Kanji, Pagination as PaginationType, Filters } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import KanjiGrid from "@/Components/Kanjis/KanjiGrid.vue";
import Pagination from "@/Components/Pagination.vue";
import KanjiFilters from "@/Components/Kanjis/KanjiFilters.vue";

const props = defineProps<{
    response: PaginationType;
    filters: Filters;
    trazos: number[];
    grados: number[];
}>();

const kanjis = computed(() => props.response.data as Kanji[]);

const page = ref(props.filters.page);

const updatePage = (newPage: number) => {
    page.value = newPage;
    fetchResults({ ...props.filters, page: page.value });
};

const fetchResults = (filters: Filters) => {
    router.get("/kanjis", filters, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};
</script>

<template>
    <Head title="Kanjis" />
    <MainLayout />
    <main class="container mt-6">
        <!-- Cabecera -->
        <div class="mb-3 flex items-end justify-between border-b-2 pb-5">
            <h1 class="text-6xl font-semibold">Kanjis</h1>
            <p class="text-lg">
                {{ `${response.total} kanji${response.total != 1 ? "s" : ""}` }}
            </p>
        </div>
        <!-- Formulario de búsqueda -->
        <KanjiFilters
            :filters="filters"
            :trazos="trazos"
            :grados="grados"
            @change="fetchResults"
        />
        <!-- Grid de kanjis -->
        <div class="flex flex-wrap justify-center gap-4">
            <KanjiGrid :kanjis="kanjis" />
        </div>
    </main>
    <!-- Paginación -->
    <footer class="sticky top-[100vh] mb-6 mt-10 flex justify-center">
        <Pagination
            :key="response.current_page"
            :total="response.total"
            :current_page="response.current_page"
            :per_page="response.per_page"
            @update:page="updatePage"
        />
    </footer>
</template>
