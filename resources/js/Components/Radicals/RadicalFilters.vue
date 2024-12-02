<script setup lang="ts">
import { reactive } from "vue";
import { watchDebounced } from "@vueuse/core";
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

const props = defineProps<{ filters: Filters; trazos: number[] }>();
const emit = defineEmits(["change"]);

const filters = reactive({
    page: props.filters.page,
    search: props.filters.search,
    strokes: props.filters.strokes,
    sortCategory: props.filters.sortCategory,
    sortOrder: props.filters.sortOrder ?? "asc",
});

const updateSort = () => {
    filters.sortOrder = filters.sortOrder == "asc" ? "desc" : "asc";
};

watchDebounced(
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
        //Elimina search si está vacío
        if (newValue.search == "") {
            delete filters.search;
        }
        emit("change", filters);
    },
    { deep: true, debounce: 500 },
);
</script>

<template>
    <div
        class="mb-6 flex flex-col items-center justify-between gap-2 rounded-sm bg-card p-2 shadow-md lg:flex-row"
    >
        <div class="inline-flex w-min flex-col gap-2 md:flex-row">
            <!-- Literal o significado -->
            <Input
                v-model="filters.search"
                placeholder="Buscar radical"
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
        </div>
        <div class="inline-flex w-min items-center gap-3">
            <!-- Orden -->
            <Select v-model="filters.sortCategory">
                <SelectTrigger class="w-40">
                    <SelectValue placeholder="Ordenar" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="trazos">Trazos</SelectItem>
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
