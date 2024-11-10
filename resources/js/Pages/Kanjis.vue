<script setup lang="ts">
import { reactive, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";
import { ArrowDownWideNarrow, ArrowUpNarrowWide } from "lucide-vue-next";
import { KanjiFilters, Pagination as PaginationType } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import KanjiGrid from "@/Components/KanjiGrid.vue";
import Pagination from "@/Components/Pagination.vue";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

const props = defineProps<{
    response: PaginationType;
    filters: KanjiFilters;
}>();

const filters = reactive({
    page: props.filters.page,
    search: props.filters.search,
    strokes: props.filters.strokes,
    grade: props.filters.grade,
    sortCategory: props.filters.sortCategory,
    sortOrder: props.filters.sortOrder ?? "asc",
});

const updatePage = (page: number) => {
    filters.page = page;
};

const updateSort = () => {
    filters.sortOrder = filters.sortOrder == "asc" ? "desc" : "asc";
};

watch(
    () => ({ ...filters }),
    (newValue, oldValue) => {
        const filters = { ...newValue };
        //Resetea a la primera pag si el cambio lo produjo otro filtro
        if (newValue.page == oldValue.page) {
            filters.page = 1;
        }
        if (newValue.strokes == "0") {
            delete filters.strokes;
        }
        if (newValue.grade == "0") {
            delete filters.grade;
        }
        //Elimina search si está vacío
        if (newValue.search == "") {
            delete filters.search;
        }
        //Elimina el filtro página si solo queda el en primera página
        if (newValue.page == 1 && Object.keys(filters).length == 1) {
            delete filters.page;
        }
        fetchResults(filters);
    },
    { deep: true },
);

const fetchResults = (filters: KanjiFilters) => {
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
        <div class="flex items-end justify-between pb-5 mb-3 border-b-2">
            <h1 class="text-6xl font-semibold">Kanjis</h1>
            <p class="text-lg">{{ response.total }} kanjis</p>
        </div>
        <!-- Formulario de búsqueda -->
        <div
            class="flex flex-col items-center justify-between gap-2 p-2 mb-6 rounded-sm lg:flex-row bg-card"
        >
            <div class="inline-flex flex-col gap-2 md:flex-row w-min">
                <!-- Literal o significado -->
                <Input
                    v-model="filters.search"
                    placeholder="Buscar kanji"
                    class="w-56"
                />
                <!-- Trazos -->
                <Select v-model="filters.strokes">
                    <SelectTrigger class="w-56">
                        <SelectValue placeholder="Trazos" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectLabel>Trazos</SelectLabel>
                        <SelectItem value="0">Todos</SelectItem>
                        <SelectItem value="1">1 trazo</SelectItem>
                        <SelectItem value="2">2 trazos</SelectItem>
                        <SelectItem value="3">3 trazos</SelectItem>
                        <SelectItem value="4">4 trazos</SelectItem>
                    </SelectContent>
                </Select>
                <!-- Grado -->
                <Select v-model="filters.grade">
                    <SelectTrigger class="w-56">
                        <SelectValue placeholder="Grado" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectLabel>Grado</SelectLabel>
                        <SelectItem value="0">Todos</SelectItem>
                        <SelectItem value="1">Primero</SelectItem>
                        <SelectItem value="2">Segundo</SelectItem>
                        <SelectItem value="3">Tercero</SelectItem>
                        <SelectItem value="4">Cuarto</SelectItem>
                        <SelectItem value="5">Quinto</SelectItem>
                        <SelectItem value="6">Sexto</SelectItem>
                        <SelectItem value="8">Séptimo</SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div class="inline-flex items-center gap-3 w-min">
                <!-- Orden -->
                <Select v-model="filters.sortCategory">
                    <SelectTrigger class="w-40">
                        <SelectValue placeholder="Ordenar" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="indice_escolar"
                            >Indice escolar</SelectItem
                        >
                        <SelectItem value="indice_heisig"
                            >Indice Heisig</SelectItem
                        >
                        <SelectItem value="indice_wanikani"
                            >Indice Wanikani</SelectItem
                        >
                        <SelectItem value="trazos">Trazos</SelectItem>
                        <SelectItem value="grado">Grado</SelectItem>
                        <SelectItem value="frecuencia">Frecuencia</SelectItem>
                        <SelectItem value="abecedario">Alfabético</SelectItem>
                    </SelectContent>
                </Select>
                <Button variant="outline" size="sm" @click="updateSort">
                    <ArrowDownWideNarrow v-if="filters.sortOrder == 'desc'" />
                    <ArrowUpNarrowWide v-else="filters.sortOrder == 'asc'" />
                </Button>
            </div>
        </div>
        <!-- Grid de kanjis -->
        <div class="flex flex-wrap justify-center gap-4">
            <KanjiGrid :kanjis="response.data" />
        </div>
        <!-- Paginación -->
        <div class="flex justify-center mt-6">
            <Pagination
                :key="response.current_page"
                :total="response.total"
                :current_page="response.current_page"
                :per_page="response.per_page"
                @update:page="updatePage"
            />
        </div>
    </main>
</template>

<script lang="ts">
//Hacer lógica orden
//Hacer filtro de trazos y grados dinámico según resultados
</script>
