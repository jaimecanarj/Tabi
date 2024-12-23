<script setup lang="ts" generic="TData">
import { type Table } from "@tanstack/vue-table";
import {
    ChevronLeft,
    ChevronRight,
    ChevronsLeft,
    ChevronsRight,
} from "lucide-vue-next";

import { Button } from "@/Components/ui/button";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";

interface DataTablePaginationProps {
    table: Table<TData>;
}
defineProps<DataTablePaginationProps>();
</script>

<template>
    <div
        class="flex flex-col items-center justify-between gap-3 px-2 sm:flex-row"
    >
        <div class="mb-3 flex-1 text-sm font-medium sm:mb-0">
            {{ table.getFilteredRowModel().rows.length }} fila{{
                table.getFilteredRowModel().rows.length > 1 ? "s" : ""
            }}
        </div>
        <div class="flex items-center space-x-6 lg:space-x-8">
            <div class="flex items-center space-x-2">
                <p class="text-sm font-medium">Filas</p>
                <!--@ts-ignore-->
                <Select
                    :model-value="`${table.getState().pagination.pageSize}`"
                    @update:model-value="table.setPageSize"
                >
                    <SelectTrigger class="h-8 w-[70px]">
                        <SelectValue
                            :placeholder="`${table.getState().pagination.pageSize}`"
                        />
                    </SelectTrigger>
                    <SelectContent side="top">
                        <SelectItem
                            v-for="pageSize in [10, 20, 30, 40, 50]"
                            :key="pageSize"
                            :value="`${pageSize}`"
                        >
                            {{ pageSize }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div
                class="flex max-w-28 items-center justify-center text-sm font-medium"
            >
                {{ table.getState().pagination.pageIndex + 1 }} de
                {{ table.getPageCount() }}
            </div>
            <div class="flex items-center sm:space-x-2">
                <Button
                    variant="outline"
                    class="hidden h-8 w-8 p-0 lg:flex"
                    :disabled="!table.getCanPreviousPage()"
                    @click="table.setPageIndex(0)"
                >
                    <span class="sr-only">Go to first page</span>
                    <ChevronsLeft class="h-4 w-4" />
                </Button>
                <Button
                    variant="outline"
                    class="h-8 w-8 p-0"
                    :disabled="!table.getCanPreviousPage()"
                    @click="table.previousPage()"
                >
                    <span class="sr-only">Go to previous page</span>
                    <ChevronLeft class="h-4 w-4" />
                </Button>
                <Button
                    variant="outline"
                    class="h-8 w-8 p-0"
                    :disabled="!table.getCanNextPage()"
                    @click="table.nextPage()"
                >
                    <span class="sr-only">Go to next page</span>
                    <ChevronRight class="h-4 w-4" />
                </Button>
                <Button
                    variant="outline"
                    class="hidden h-8 w-8 p-0 lg:flex"
                    :disabled="!table.getCanNextPage()"
                    @click="table.setPageIndex(table.getPageCount() - 1)"
                >
                    <span class="sr-only">Go to last page</span>
                    <ChevronsRight class="h-4 w-4" />
                </Button>
            </div>
        </div>
    </div>
</template>
