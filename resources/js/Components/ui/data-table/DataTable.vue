<script setup lang="ts" generic="TData">
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import type {
    ColumnDef,
    SortingState,
    ColumnFiltersState,
} from "@tanstack/vue-table";
import {
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getFilteredRowModel,
    useVueTable,
} from "@tanstack/vue-table";
import { Input } from "@/Components/ui/input";
import { cn, valueUpdater } from "@/lib/utils";
import { Button } from "@/Components/ui/button";
import { Pagination } from "@/Components/ui/data-table";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";

const props = defineProps<{
    columns: ColumnDef<TData>[];
    data: TData[];
    name: string;
}>();

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);

const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnFilters),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        columnPinning: {
            left: ["literal", "name"],
        },
    },
});

const filterColumn = ref<string>("");
switch (props.name) {
    case "kanjis":
    case "radicales": {
        filterColumn.value = "significado";
        break;
    }
    case "usuarios": {
        filterColumn.value = "email";
        break;
    }
}
</script>

<template>
    <div class="flex items-center justify-between gap-3 py-4">
        <Input
            :key="name"
            class="max-w-sm"
            placeholder="Filtrar..."
            :model-value="
                table.getColumn(filterColumn)?.getFilterValue() as string
            "
            @update:model-value="
                table.getColumn(filterColumn)?.setFilterValue($event)
            "
        />
        <Link :href="`/admin/${name}/crear`">
            <Button variant="secondary" size="icon"><Plus /></Button>
        </Link>
    </div>
    <div class="rounded-md border">
        <Table>
            <TableHeader class="group bg-card">
                <TableRow
                    v-for="headerGroup in table.getHeaderGroups()"
                    :key="headerGroup.id"
                    class="group-hover:bg-muted"
                >
                    <TableHead
                        v-for="header in headerGroup.headers"
                        :key="header.id"
                        :data-pinned="header.column.getIsPinned()"
                        :class="
                            cn(
                                {
                                    'sticky bg-card group-hover:bg-muted':
                                        header.column.getIsPinned(),
                                },
                                header.column.getIsPinned() === 'left'
                                    ? 'left-0'
                                    : 'right-0',
                            )
                        "
                    >
                        <FlexRender
                            v-if="!header.isPlaceholder"
                            :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows?.length">
                    <TableRow
                        v-for="row in table.getRowModel().rows"
                        :key="row.id"
                        class="group"
                        :data-state="
                            row.getIsSelected() ? 'selected' : undefined
                        "
                    >
                        <TableCell
                            v-for="cell in row.getVisibleCells()"
                            :key="cell.id"
                            :data-pinned="cell.column.getIsPinned()"
                            :class="
                                cn(
                                    {
                                        'sticky bg-background group-hover:bg-muted':
                                            cell.column.getIsPinned(),
                                    },
                                    cell.column.getIsPinned() === 'left'
                                        ? 'left-0'
                                        : 'right-0',
                                )
                            "
                        >
                            <FlexRender
                                :render="cell.column.columnDef.cell"
                                :props="cell.getContext()"
                            />
                        </TableCell>
                    </TableRow>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell
                            :colspan="columns.length"
                            class="h-24 text-center"
                        >
                            No hay resultados.
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>
    <Pagination :table="table" class="mt-6" />
</template>
