<script setup lang="ts">
import { computed, ref } from "vue";
import { Head, router, Link } from "@inertiajs/vue3";
import { Radical, Pagination as PaginationType, Filters } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import RadicalFilters from "@/Components/Radicals/RadicalFilters.vue";
import RadicalGrid from "@/Components/Radicals/RadicalGrid.vue";
import Pagination from "@/Components/Pagination.vue";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";
import { Info, PencilLine, Hash } from "lucide-vue-next";

const props = defineProps<{
    response: PaginationType;
    filters: Filters;
    trazos: number[];
}>();

const radicales = computed(
    () => props.response.data as (Radical & { kanjis_count: number })[],
);

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
            class="mb-3 flex flex-wrap items-end justify-between gap-1 text-nowrap border-b-2 pb-5"
        >
            <Link href="/radicales">
                <h1 class="text-5xl font-semibold sm:text-6xl">
                    Radicales <span class="text-xl sm:text-3xl">「部首」</span>
                </h1>
            </Link>
            <p class="text-lg">
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
        <div v-if="!radicales.length" class="ml-2 text-5xl sm:text-6xl">
            No hay resultados.
        </div>
        <div
            class="grid grid-cols-1 justify-items-center gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6"
        >
            <RadicalGrid :radicales="radicales" />
        </div>
    </main>
    <!-- Paginación -->
    <footer
        class="sticky top-[100vh] mb-6 mt-10 flex flex-col items-center gap-3"
    >
        <HoverCard>
            <HoverCardTrigger>
                <div
                    class="flex cursor-default items-center gap-1 text-muted-foreground"
                >
                    <Info />
                    Información
                </div>
            </HoverCardTrigger>
            <HoverCardContent class="w-fit">
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3">
                        <PencilLine /> Número de trazos
                    </div>
                    <div class="flex items-center gap-3">
                        <Hash /> Número de kanjis<br />donde se usa
                    </div>
                </div>
            </HoverCardContent>
        </HoverCard>
        <Pagination
            :total="response.total"
            :current_page="response.current_page"
            :per_page="response.per_page"
            @update:page="updatePage"
        />
    </footer>
</template>
