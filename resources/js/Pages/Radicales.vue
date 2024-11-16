<script setup lang="ts">
import { computed, ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import { Radical, Pagination as PaginationType, Filters } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import RadicalFilters from "@/Components/RadicalFilters.vue";
import RadicalGrid from "@/Components/RadicalGrid.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps<{
    response: PaginationType;
    filters: Filters;
    trazos: number[];
}>();

const radicales = computed(() => props.response.data as Radical[]);

const page = ref(props.response.current_page);

const updatePage = (newPage: number) => {
    page.value = newPage;
    fetchResults({ ...props.filters, page: page.value });
};

const fetchResults = (filters: Filters) => {
    router.get("/radicales", filters, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Radicales" />
    <MainLayout />
    <main class="container mt-6">
        <!-- Cabecera -->
        <div
            class="flex flex-wrap items-end justify-between pb-5 mb-3 border-b-2 gap-y-3"
        >
            <h1 class="text-6xl font-semibold">Radicales</h1>
            <p class="text-lg ml-3">
                {{
                    `${response.total} radical${response.total != 1 ? "es" : ""}`
                }}
            </p>
        </div>
        <!-- Formulario de búsqueda -->
        <RadicalFilters
            :filters="filters"
            :trazos="trazos"
            @change="fetchResults"
        />
        <!-- Grid de radicales -->
        <div class="flex flex-wrap justify-center gap-4">
            <RadicalGrid :radicales="radicales" />
        </div>
    </main>
    <!-- Paginación -->
    <footer class="sticky top-[100vh] flex justify-center mt-10 mb-6">
        <Pagination
            :total="response.total"
            :current_page="response.current_page"
            :per_page="response.per_page"
            @update:page="updatePage"
        />
    </footer>
</template>
