<script setup lang="ts">
import { reactive, watch } from "vue";
import { ArrowDownWideNarrow, ArrowUpNarrowWide } from "lucide-vue-next";
import { Filters } from "@/lib/types";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

const props = defineProps<{
    filters: Filters;
    trazos: number[];
    grados: number[];
}>();
const emit = defineEmits(["change"]);

const grades = [
    "Primero",
    "Segundo",
    "Tercero",
    "Cuarto",
    "Quinto",
    "Sexto",
    "Séptimo",
];

const filters = reactive({
    page: props.filters.page,
    search: props.filters.search,
    strokes: props.filters.strokes,
    grade: props.filters.grade,
    sortCategory: props.filters.sortCategory,
    sortOrder: props.filters.sortOrder ?? "asc",
});

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
        emit("change", filters);
    },
    { deep: true },
);
</script>

<template>
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
                    <SelectItem v-for="trazo in trazos" :value="String(trazo)">
                        {{ `${trazo} trazo${trazo != 1 ? "s" : ""} ` }}
                    </SelectItem>
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
                    <SelectItem v-for="grado in grados" :value="String(grado)">
                        {{ grades[grado - 1] }}
                    </SelectItem>
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
                    <SelectItem value="indice_escolar">
                        Índice escolar
                    </SelectItem>
                    <SelectItem value="indice_heisig">
                        Índice Heisig
                    </SelectItem>
                    <SelectItem value="indice_wanikani">
                        Índice Wanikani
                    </SelectItem>
                    <SelectItem value="trazos">Trazos</SelectItem>
                    <SelectItem value="grado">Grado</SelectItem>
                    <SelectItem value="frecuencia">Frecuencia</SelectItem>
                    <SelectItem value="significado">Alfabético</SelectItem>
                </SelectContent>
            </Select>
            <Button variant="outline" size="sm" @click="updateSort">
                <ArrowDownWideNarrow v-if="filters.sortOrder == 'desc'" />
                <ArrowUpNarrowWide v-else />
            </Button>
        </div>
    </div>
</template>
