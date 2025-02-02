<script setup lang="ts">
import { Select, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { ArrowUpNarrowWide } from "lucide-vue-next";
</script>

<template>
    <div
        class="mb-6 flex flex-col items-center justify-between gap-2 rounded-sm bg-card p-2 shadow-md lg:flex-row"
    >
        <div class="inline-flex w-min flex-col gap-2 md:flex-row">
            <!-- Literal o significado -->
            <Input placeholder="Buscar kanji" class="w-56" disabled />
            <!-- Trazos -->
            <Select disabled>
                <SelectTrigger class="w-56">
                    <SelectValue placeholder="Trazos" />
                </SelectTrigger>
            </Select>
        </div>
        <div class="inline-flex w-min items-center gap-3">
            <!-- Orden -->
            <Select disabled>
                <SelectTrigger class="w-40">
                    <SelectValue placeholder="Ordenar" />
                </SelectTrigger>
            </Select>
            <Button variant="outline" size="sm" disabled>
                <ArrowUpNarrowWide />
            </Button>
        </div>
    </div>
</template>
